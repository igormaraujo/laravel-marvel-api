<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use App\Services\Marvel;
use App\Http\Requests\CharacterRequest;
use App\Models\Comic;
use Illuminate\Support\Facades\Cache;

class CharacterController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(CharacterRequest $request)
  {
    $default = [
      'orderBy' => '-modified',
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
          view('characters.index', ['characters' => $data->json()["data"]])->render(),
          3
        );
        Cache::put($key, $result, now()->addHours(5));
        return response($result, 200)->header('Content-Encoding', 'gzip');
      case 'html-none':
        $result = view('characters.index', ['characters' => $data->json()["data"]])->render();
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
    $character = Character::find($character_id);
    if (!$character) {
      $data = Marvel::get('characters/' . $character_id);
      if ($data->failed()) {
        return $data->body();
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

      $offset = 0;
      $comics = [];
      do {
        $response = Marvel::get('characters/' . $character_id . '/comics', ['limit' => 100, 'offset' => $offset])->json();
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
      } while($offset < $total);
      Comic::upsert($comics, ['id'], ['title', 'issn', 'description', 'resourceURI', 'thumbnail']);
      $character->comics()->sync(array_map(fn ($comic) => $comic['id'], $comics));
    }
    // ddd($character->comics()->get());
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
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Character  $character
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Character $character)
  {
    //
  }
}
