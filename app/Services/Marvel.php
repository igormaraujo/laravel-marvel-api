<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Marvel
{
  public static function get($resource, $params = [], $debug = false)
  {
    $tries = 0;
    $success = false;
    $response = null;
    $responses = [];
    do {
      $now = time();
      $response = Http::get(config('marvel.endpoint') . $resource, [
        'apikey' => config('marvel.publicKey'),
        'ts' => $now,
        'hash' => md5($now . config('marvel.privateKey') . config('marvel.publicKey')),
      ] + $params);
      if ($response->ok() && gettype($response->json()) == "array" && $response->json() !== []) {
        $success = true;
      }
      $responses[] = $response->json();
    } while (!$success && $tries++ < config('marvel.retries'));
    if ($debug) {
      ddd($responses);
    }
    return $response;
  }
}
