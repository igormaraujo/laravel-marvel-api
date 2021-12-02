<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Marvel
{
  public static function get($resource, $params = [])
  {
    $now = time();
    return Http::get(config('marvel.endpoint') . $resource, [
      'apikey' => config('marvel.publicKey'),
      'ts' => $now,
      'hash' => md5($now . config('marvel.privateKey') . config('marvel.publicKey')),
    ] + $params);
  }
}
