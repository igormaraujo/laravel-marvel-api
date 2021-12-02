<?php

return [

    'publicKey' => env('MARVEL_PUBLIC_KEY'),
    'privateKey' => env('MARVEL_PRIVATE_KEY'),
    'endpoint' => env('MARVEL_ENDPOINT', 'https://gateway.marvel.com:443/v1/public/'),

];
