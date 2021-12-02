<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class MarvelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Marvel';
    }
}
