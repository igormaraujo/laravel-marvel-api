<x-app-layout>
  <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28 mb-5">
    <div class="sm:text-center lg:text-left">
      <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
        <span class="block xl:inline">Check out your favorites</span>
        <span class="block text-red-600 xl:inline">Marvel characters and comics</span>
      </h1>
      <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
        This is a
        <a href="https://laravel.com/" class="underline text-red-600 visited:text-red-800" target="_blank">Laravel</a>
         exemple project that uses the
         <a href="https://developer.marvel.com/" class="underline text-red-600 visited:text-red-800" target="_blank">Marvel API</a>
          to display the most popular characters and comics.
      </p>
      <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
        <div class="rounded-md shadow">
          <a href="{{ route('characters.index')}}"
            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg md:px-10">
            Characters
          </a>
        </div>
        <div class="mt-3 sm:mt-0 sm:ml-3">
          <a href="{{ route('comics.index')}}"
            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-4 md:text-lg md:px-10">
            Comics
          </a>
        </div>
      </div>
    </div>
  </main>
  <div class="flex flex-col bg-white m-auto p-auto">
    <h1 class="flex py-5 font-bold text-4xl text-gray-800  ml-3">
      Top Favorite Characters
    </h1>
    <div class="flex overflow-x-scroll pb-10 hide-scroll-bar">
      <div class="flex flex-nowrap ">
        @foreach ($characters as $character)
          <div class="inline-block px-3">
            <div
              class="w-64 h-64 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
              <a href="{{ route('characters.show', $character->id) }}">
                <img src="{{ $character->thumbnail }}" alt="{{ $character->name }}">
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="flex flex-col bg-white m-auto p-auto">
    <h1 class="flex py-5 font-bold text-4xl text-gray-800 ml-3">
      Top Favorite Comics
    </h1>
    <div class="flex overflow-x-scroll pb-10 hide-scroll-bar">
      <div class="flex flex-nowrap ">
        @foreach ($comics as $comic)
          <div class="inline-block px-3">
            <div
              class="w-64 h-64 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
              <a href="{{ route('comics.show', $comic->id) }}">
                <img src="{{ $comic->thumbnail }}" alt="{{ $comic->title }}">
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <style>
    .hide-scroll-bar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .hide-scroll-bar::-webkit-scrollbar {
      display: none;
    }

  </style>
</x-app-layout>
