<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Character;
use App\Services\Marvel;
use App\Http\Requests\ComicRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class ComicController extends Controller
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
  public function index(ComicRequest $request)
  {
    $default = [
      'orderBy' => '-modified',
      'offset' => 0,
      'limit' => 10,
    ];
    $params = array_merge($default, $request->validated());
    $encoding = str_contains($request->headers->get("accept-encoding"), "gzip") ? "gzip" : "none";
    $type = $request->ajax() ? 'json' : 'html';
    $key = $type . '-' . $encoding . '-comics?' . http_build_query($params);
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
    $data = Marvel::get('comics', $params);
    if ($data->failed()) {
      return $data->body();
    }
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
          view('comics.index', ['comics' => $data->json()["data"]])->render(),
          3
        );
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200)->header('Content-Encoding', 'gzip');
      case 'html-none':
        $result = view('comics.index', ['comics' => $data->json()["data"]])->render();
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
  public function show(Request $request, $comic_id)
  {
    $encoding = str_contains($request->headers->get("accept-encoding"), "gzip") ? "gzip" : "none";
    $key = $encoding . '-comics-' . $comic_id;
    $cache = Cache::get($key);
    if ($cache) {
      switch ($encoding) {
        case 'gzip':
          return response($cache, 200)->header('Content-Encoding', 'gzip');
        case 'none':
          return response($cache, 200);
      }
    }
    $comic = Comic::find($comic_id);
    if (!$comic) {
      $data = Marvel::get('comics/' . $comic_id);
      if ($data->failed()) {
        return $data->body();
      }
      $response = $data->json();
      $comic = Comic::create([
        'id' => $response["data"]["results"][0]["id"],
        'title' => $response["data"]["results"][0]["title"],
        'issn' => $response["data"]["results"][0]["issn"],
        'description' => $response["data"]["results"][0]["description"] ?? '',
        'resourceURI' => $response["data"]["results"][0]["urls"][0]["url"],
        'thumbnail' => $response["data"]["results"][0]["thumbnail"]["path"] . "/portrait_uncanny." . $response["data"]["results"][0]["thumbnail"]["extension"],
        'etag' => $response["etag"],
      ]);
    }
    if ($comic->characters()->count() < 2) {
      $offset = 0;
      $characters = [];
      do {
        $response = Marvel::get('comics/' . $comic_id . '/characters', ['limit' => 100, 'offset' => $offset])->json();
        $total = $response["data"]["total"];
        foreach ($response["data"]["results"] as $character) {
          $characters[] = [
            'id' => $character["id"],
            'name' => $character["name"],
            'description' => $character["description"] ?? '',
            'resourceURI' => $character["urls"][0]["url"],
            'thumbnail' => $character["thumbnail"]["path"] . "/portrait_uncanny." . $character["thumbnail"]["extension"],
            'etag' => '',
          ];
        }
        $offset += 100;
      } while ($offset < $total);
      Character::upsert($characters, ['id'], ['name', 'description', 'resourceURI', 'thumbnail']);
      $comic->characters()->sync(array_map(fn ($character) => $character['id'], $characters));
    }
    switch ($encoding) {
      case 'gzip':
        $result = gzencode(
          view('comics.show', ['comic' => $comic, 'characters' => $comic->characters()->get()])->render(),
          3
        );
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200)->header('Content-Encoding', 'gzip');
      case 'none':
        $result = view('comics.show', ['comic' => $comic, 'characters' => $comic->characters()->get()])->render();
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200);
    }
  }

  /**
   * Add Character as favorite to logged user .
   *
   * @param  \App\Models\Comic  $comic
   * @return \Illuminate\Http\Response
   */
  public function update(Comic $comic)
  {
    Auth::user()->comics()->attach($comic->id);
    return response()->json([], 204);
  }

  /**
   * Remove Cahracter as favorite to logged user.
   *
   * @param  \App\Models\Comic  $comic
   * @return \Illuminate\Http\Response
   */
  public function destroy(Comic $comic)
  {
    Auth::user()->comics()->detach($comic->id);
    return response()->json([], 204);
  }

  public function favorites()
  {
    return response()->json(Auth::user()->comics()->pluck('comic_id'), 200);
  }
}
