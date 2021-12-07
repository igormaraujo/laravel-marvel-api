<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Character;

class HomeController extends Controller
{
    public function __invoke()
    {
      $comics = Comic::withCount('users')->orderBy('users_count','DESC')->limit(10)->get();
      $characters = Character::withCount('users')->orderBy('users_count','DESC')->limit(10)->get();
      return view('home', ['comics' => $comics, 'characters' => $characters]);
    }
}
