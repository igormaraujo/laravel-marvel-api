# Laravel Marvel API

LIVE Demo: https://laravel-marvel-api.herokuapp.com/

This is [Laravel](https://laravel.com/) exemple app that uses the [Marvel API](https://developer.marvel.com/) to display the most popular characters and comics.

### Features
- Serach for Marvel Comics or Characters.
- Add/Remove a comic or character to your favorites list.
- See the Top Favorites Characters and Comics.


## Development

### Frontend
- Tailwind CSS.

### Backend
- PHP (Laravel Framework) as server.
- Mysql as databse.
- Redis as cache.
- Mailgun as email delivery.
- Rollbar as error tracking.


### Performance Improvements
- Marvel API implemented as Service Provider with automatic retries.
- Every seach are cached with redis (compiled view with gzip compression).
- Every detail or favorite action, the data are copied for the local database(Mysql).
- Local database fallback in case of an unavailabilty of Marvel API.
- The favorites are delivered by the local database (Still working even if reach the marvel api daily rate limit).
- Client Browser cache with the HTTP cache-control header.
- Cron Job daily to update the local database with modified data from Marvel API


## Run localy

### Requiriments
- Marvel Developer account, [here](https://developer.marvel.com/)
- Docker

### Setup
Rename `.env.example` to `.env`
```
mv .env.example .env
```
Generate a App Key
```
./vendor/bin/sail artisan key:generate
```
Add your Marvel public and private key to your `.env` file 
```
echo 'MARVEL_PUBLIC_KEY=[[YOUR_PUBLIC_KEY_HERE]]' >> .env
echo 'MARVEL_PRIVATE_KEY=[[YOUR_PRIVATE_KEY_HERE]]' >> .env
```
### Run
```
./vendor/bin/sail up
```

