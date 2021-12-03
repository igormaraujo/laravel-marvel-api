<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use App\Services\Marvel;
use App\Http\Requests\CharacterRequest;
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
        Cache::put($key, $result, now()->addMinutes(5));
        return response($result, 200)->header('Content-type', 'application/json')->header('Content-Encoding', 'gzip');
      case 'json-none':
        $result = $data->body();
        Cache::put($key, $result, now()->addMinutes(5));
        return response($result, 200)->header('Content-type', 'application/json');
      case 'html-gzip':
        $result = gzencode(
          view('characters.index', ['characters' => $data->json()["data"]])->render(),
          3
        );
        Cache::put($key, $result, now()->addMinutes(5));
        return response($result, 200)->header('Content-Encoding', 'gzip');
      case 'html-none':
        $result = view('characters.index', ['characters' => $data->json()["data"]])->render();
        Cache::put($key, $result, now()->addMinutes(5));
        return response($result, 200);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Character  $character
   * @return \Illuminate\Http\Response
   */
  public function show(Character $character)
  {
    //
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
