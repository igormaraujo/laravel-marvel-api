<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CronJob;
use App\Models\Character;
use App\Models\Comic;
use App\Services\Marvel;

class UpdateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $datetime1 = date_create();
      $lastUpdate = CronJob::where(['success' => true])->orderBy('created_at', 'desc')->first();
      if ($lastUpdate) {
        $lastUpdate = $lastUpdate->created_at;
      } else {
        $lastUpdate = date('Y-m-d H:i:s');
      }
      $lastUpdate = substr($lastUpdate, 0, 10);
      $offset = 0;
      $limit = 100;
      $total = 0;
      $characters = [];
      do{
        $result = Marvel::get('characters', ['modifiedSince' => $lastUpdate, 'limit' => 100, 'offset' => $offset]);
        if ($result->failed() || gettype($result->json()) != "array" || $result->json() == []) {
          CronJob::create([
            'success' => false,
            'report' => [
              'detail' => 'failed to get data from marvel api',
              'code' => $result->status()
            ],
          ]);
          return Command::FAILURE;
        }
        $total = $result->json()['data']['total'];
        $characters = array_merge($characters, $result->json()['data']['results']);
        $offset += $limit;
      } while($offset < $total);
      $ids = array_map(function($character){
        return $character['id'];
      }, $characters);
      $dbCharacters = Character::whereIn('id', $ids)->get();
      if(count($dbCharacters) > 0) {
        $dbIds = array_map(function($character){
          return $character["id"];
        }, $dbCharacters->toArray());
        $updatedCharacters = array_filter($characters, function($character) use ($dbIds){
          return in_array($character['id'], $dbIds);
        });
        $updatedCharacters = array_map(function($character){
          return [
            'id' => $character["id"],
            'name' => $character["name"],
            'description' => $character["description"] ?? '',
            'resourceURI' => $character["urls"][0]["url"],
            'thumbnail' => $character["thumbnail"]["path"] . "/portrait_uncanny." . $character["thumbnail"]["extension"],
            'etag' => '',
          ];
        }, $updatedCharacters);
        Character::upsert($updatedCharacters, ['id'], ['name', 'description', 'resourceURI', 'thumbnail']);
      }
      $offset = 0;
      $limit = 100;
      $total = 0;
      $comics = [];
      do{
        $result = Marvel::get('comics', ['modifiedSince' => $lastUpdate, 'limit' => 100, 'offset' => $offset]);
        if ($result->failed() || gettype($result->json()) != "array" || $result->json() == []) {
          CronJob::create([
            'success' => false,
            'report' => [
              'detail' => 'failed to get data from marvel api',
              'code' => $result->status()
            ],
          ]);
          return Command::FAILURE;
        }
        $total = $result->json()['data']['total'];
        $comics = array_merge($comics, $result->json()['data']['results']);
        $offset += $limit;
      } while($offset < $total);
      $ids = array_map(function($comic){
        return $comic['id'];
      }, $comics);
      $dbComics = Comic::whereIn('id', $ids)->get();
      if(count($dbComics) > 0) {
        $dbIds = array_map(function($comic){
          return $comic["id"];
        }, $dbComics->toArray());
        $updatedComics = array_filter($comics, function($comic) use ($dbIds){
          return in_array($comic['id'], $dbIds);
        });
        $updatedComics = array_map(function($comic){
          return [
            'id' => $comic["id"],
            'title' => $comic["title"],
            'issn' => $comic["issn"],
            'description' => $comic["description"] ?? '',
            'resourceURI' => $comic["urls"][0]["url"],
            'thumbnail' => $comic["thumbnail"]["path"] . "/portrait_uncanny." . $comic["thumbnail"]["extension"],
            'etag' => '',
          ];
        }, $updatedComics);
        Comic::upsert($updatedComics, ['id'], ['title', 'issn', 'description', 'resourceURI', 'thumbnail']);
      }
      $datetime2 = date_create();
      $interval = $datetime1->diff($datetime2);
      CronJob::create([
        'report' => [
          'characters' => count($dbCharacters),
          'comcis' => count($dbComics),
          'duration' => $interval->format('%I minutes %S seconds'),
        ],
      ]);
      return Command::SUCCESS;
    }
}
