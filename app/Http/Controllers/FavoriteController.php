<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __invoke(Request $request)
    {
      if ($request->ajax()) {
        $data = [
          'characters' => Auth::user()->characters()->pluck('character_id'),
          'comics' => Auth::user()->comics()->pluck('comic_id'),
        ];
        return response()->json($data, 200);
      }
      $data = [
        'characters' => Auth::user()->characters()->get(),
        'comics' => Auth::user()->comics()->get()
      ];
      return view('favorites', $data);
    }
}
