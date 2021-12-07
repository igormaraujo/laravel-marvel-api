<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use App\Services\Marvel;
use App\Http\Requests\CharacterRequest;
use App\Models\Comic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth')->only('update', 'destroy');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(CharacterRequest $request)
  {
    $default = [
      'orderBy' => 'name',
      'offset' => 0,
      'limit' => 10,
    ];
    $params = array_merge($default, $request->validated());
    $encoding = str_contains($request->headers->get("accept-encoding"), "gzip") ? "gzip" : "none";
    $type = $request->ajax() ? 'json' : 'html';
    $key = $type . '-' . $encoding . '-characters?' . http_build_query($params);
    $cache = Cache::get($key);
    if ($cache) {
      switch ($type . '-' . $encoding) {
        case 'json-gzip':
          return response()->json($cache, 200)->header('Content-Encoding', 'gzip');
        case 'json-none':
          return response()->json($cache, 200);
        case 'html-gzip':
          return response()->make($cache, 200)->header('Content-Encoding', 'gzip');
        case 'html-none':
          return response()->make($cache, 200);
      }
    }
    $data = Marvel::get('characters', $params);
    if ($data->failed() || gettype($data->json()) != "array" || $data->json() === []) {
      $query = Character::orderBy($params["orderBy"]);
      if(array_key_exists('nameStartsWith', $params)) {
        $query->where('name', 'like', $params['nameStartsWith'] . '%');
      }
      $total = $query->count();
      $query->offset($params['offset']);
      $query->limit($params['limit']);
      $data = [
        'results' => $query->get()->toArray(),
        'count' => $query->count(),
        'offset' => $params['offset'],
        'total' => $total,
      ];
      $current = (int) ($params["offset"] + $params["limit"]) / $params["limit"];
      $pagination = [
        'first' => 1,
        'previus' => $current - 1,
        'current' => $current,
        'next' => $current + 1,
        'last' => (int) ceil($data["total"] / $params["limit"]),
      ];
      $result = view('characters.index', ['cache'=> true, 'characters' => $data, 'pagination' => $pagination, 'params' => $request->validated()])->render();
      return response($result, 503);
    }
    $current = (int) ($params["offset"] + $params["limit"]) / $params["limit"];
    $pagination = [
      'first' => 1,
      'previus' => $current - 1,
      'current' => $current,
      'next' => $current + 1,
      'last' => (int) ceil($data->json()["data"]["total"] / $params["limit"]),
    ];
    switch ($type . '-' . $encoding) {
      case 'json-gzip':
        $result = gzencode($data->body(), 3);
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200)->header('Content-type', 'application/json')->header('Content-Encoding', 'gzip');
      case 'json-none':
        $result = $data->body();
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200)->header('Content-type', 'application/json');
      case 'html-gzip':
        $result = gzencode(
          view('characters.index', ['characters' => $data->json()["data"], 'pagination' => $pagination, 'params' => $request->validated()])->render(),
          3
        );
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200)->header('Content-Encoding', 'gzip');
      case 'html-none':
        $result = view('characters.index', ['characters' => $data->json()["data"], 'pagination' => $pagination, 'params' => $request->validated()])->render();
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Character  $character
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $character_id)
  {
    $encoding = str_contains($request->headers->get("accept-encoding"), "gzip") ? "gzip" : "none";
    $key = $encoding . '-characters-' . $character_id;
    $cache = Cache::get($key);
    if ($cache) {
      switch ($encoding) {
        case 'gzip':
          return response($cache, 200)->header('Content-Encoding', 'gzip');
        case 'none':
          return response($cache, 200);
      }
    }
    $character = $this->retriveCharacter($character_id);
    if ($character == null) {
      abort(404);
    }
    switch ($encoding) {
      case 'gzip':
        $result = gzencode(
          view('characters.show', ['character' => $character, 'comics' => $character->comics()->get()])->render(),
          3
        );
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200)->header('Content-Encoding', 'gzip');
      case 'none':
        $result = view('characters.show', ['character' => $character, 'comics' => $character->comics()->get()])->render();
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200);
    }
  }

  /**
   * Add Character as favorite to logged user .
   *
   * @return \Illuminate\Http\Response
   */
  public function update($character_id)
  {
    $character = $this->retriveCharacter($character_id);
    if($character == null) {
      return response()->json([], 404);
    }
    Auth::user()->characters()->attach($character->id);
    return response()->json([], 204);
  }

  /**
   * Remove Cahracter as favorite to logged user.
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($character_id)
  {
    $character = $this->retriveCharacter($character_id);
    if($character == null) {
      return response()->json([], 404);
    }
    Auth::user()->characters()->detach($character->id);
    return response()->json([], 204);
  }

  public function favorites()
  {
    return response()->json(Auth::user()->characters()->pluck('character_id'), 200);
  }

  private function retriveCharacter($character_id)
  {
    $character = Character::find($character_id);
    if (!$character) {
      $data = Marvel::get('characters/' . $character_id);
      if ($data->failed() || gettype($data->json()) != "array" || $data->json() === []) {
        return null;
      }
      $response = $data->json();
      $character = Character::create([
        'id' => $response["data"]["results"][0]["id"],
        'name' => $response["data"]["results"][0]["name"],
        'description' => $response["data"]["results"][0]["description"] ?? '',
        'resourceURI' => $response["data"]["results"][0]["urls"][0]["url"],
        'thumbnail' => $response["data"]["results"][0]["thumbnail"]["path"] . "/portrait_uncanny." . $response["data"]["results"][0]["thumbnail"]["extension"],
        'etag' => $response["etag"],
      ]);
    }
    if($character->comics()->count() < 2) {
      $offset = 0;
      $comics = [];
      do {
        $data = Marvel::get('characters/' . $character_id . '/comics', ['limit' => 100, 'offset' => $offset]);
        if ($data->failed() || gettype($data->json()) != "array" || $data->json() === []) {
          return null;
        }
        $response = $data->json();
        $total = $response["data"]["total"];
        foreach ($response["data"]["results"] as $comic) {
          $comics[] = [
            'id' => $comic["id"],
            'title' => $comic["title"],
            'issn' => $comic["issn"],
            'description' => $comic["description"] ?? '',
            'resourceURI' => $comic["urls"][0]["url"],
            'thumbnail' => $comic["thumbnail"]["path"] . "/portrait_uncanny." . $comic["thumbnail"]["extension"],
            'etag' => '',
          ];
        }
        $offset += 100;
      } while ($offset < $total);
      Comic::upsert($comics, ['id'], ['title', 'issn', 'description', 'resourceURI', 'thumbnail']);
      $character->comics()->sync(array_map(fn ($comic) => $comic['id'], $comics));
    }
    return $character;
  }
}
