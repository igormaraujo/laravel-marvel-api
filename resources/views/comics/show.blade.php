<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Comics Details
    </h2>
  </x-slot>

  <div id="alert" class="bg-red-600 hidden">
    <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between flex-wrap">
        <div class="w-0 flex-1 flex items-center">
          <p id="alert-text" class="ml-3 font-medium text-white truncate">
              It's looks like that some problem occurred while fetching data from Marvel API. We are showing a cached version of the data that can be outdated.
          </p>
        </div>
        <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
          <button type="button" class="-mr-1 flex p-2 rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2" onclick="document.getElementById('alert').classList.add('hidden')">
            <span class="sr-only">Dismiss</span>
            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white">
    <div class="pt-6 grid grid-cols-1 lg:grid-cols-2">
      <!-- Image gallery -->
      <div class="mt-6 max-w-2xl mx-auto sm:px-6">
        <div class="aspect-w-3 aspect-h-4 rounded-lg overflow-hidden">
          <img src="{{ $comic->thumbnail }}" alt="{{ $comic->title }}"
            class="w-full h-full object-center object-cover">
        </div>
      </div>

      <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6 ">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            Comic Information
          </h3>
        </div>
        <div class="border-t border-gray-200">
          <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">
                Title
              </dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ $comic->title }}
              </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">
                ISSN
              </dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ $comic->issn ?? '--' }}
              </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">
                Description
              </dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ $comic->description ?? '--' }}
              </dd>
            </div>
            <div class="col-span-3 flex justify-center">
              <a href="{{ $comic->resourceURI }}" target="_blank"
                class="text-gray-300 bg-red-800 hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium my-5 flex">
                See More
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                  class="ml-2">
                  <path
                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                  <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                </svg>
              </a>
              <button id="{{ $comic->id }}" onclick="likeComic(this)"
                class="ml-3 px-3 py-2 rounded-md text-sm font-medium my-5 flex bg-white p-1 text-gray-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-800 focus:ring-white border border-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                    clip-rule="evenodd" />
                </svg>
                Add to favorites
              </button>
            </div>
          </dl>
        </div>
      </div>
    </div>

    <h2 class="text-xl font-extrabold ml-2 mt-5">Characters</h2>
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
              <thead class="bg-gray-50">
                <tr>
                  <th class="w-2"></th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($characters as $character)
                  <tr>
                    <td class="whitespace-nowrap pl-4">
                      <button type="button" id="{{ $character->id }}" onclick="like(this)"
                        class="heart-button bg-white p-1 rounded-full text-gray-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-800 focus:ring-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                        </svg>
                      </button>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <img class="h-10 w-10"
                            src="{{ str_replace('portrait_uncanny', 'standard_small', $character->thumbnail) }}"
                            alt="{{ $character->name }}">
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            {{ $character->name }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="{{ route('characters.show', [$character->id]) }}"
                        class="text-red-600 hover:text-red-900">View</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div @class([
                'hidden' => sizeof($characters) != 0,
                'flex justify-center bg-gray-50',
            ])>
              <p class="text-base text-gray-400 py-5">
                No characters registered
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    async function like(heart) {
      const add = heart.classList.contains('text-gray-400');
      const response = await fetch('/characters/' + heart.id, {
        method: add ? 'PUT' : 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      switch (response.status) {
        case 204:
          if (add) {
            heart.classList.remove('text-gray-400', 'hover:text-red-500');
            heart.classList.add('text-red-500', 'hover:text-gray-400');
          } else {
            heart.classList.remove('text-red-500', 'hover:text-gray-400');
            heart.classList.add('text-gray-400', 'hover:text-red-500');
          }
          break;
        case 401:
          window.location.href = '/login';
          break;
        default:
          document.getElementById('alert-text').innerText = 'Something went wrong, please try again later.';
          const alert = document.getElementById('alert')
          alert.classList.remove('hidden');
          alert.scrollIntoView();
      }
    }
    async function likeComic(heart) {
        const add = heart.innerHTML.includes('Add to favorites');
        const response = await fetch('/comics/' + heart.id, {
          method: add ? 'PUT' : 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        switch (response.status) {
          case 204:
            if (add) {
              heart.classList.remove('text-gray-400', 'hover:text-red-500');
              heart.classList.add('text-red-500', 'hover:text-gray-400');
              heart.innerHTML = heart.innerHTML.replace('Add to favorites', 'Remove from favorites');
            } else {
              heart.classList.remove('text-red-500', 'hover:text-gray-400');
              heart.classList.add('text-gray-400', 'hover:text-red-500');
              heart.innerHTML = heart.innerHTML.replace('Remove from favorites', 'Add to favorites');
            }
            break;
          case 401:
            window.location.href = '/login';
            break;
          default:
            document.getElementById('alert-text').innerText = 'Something went wrong, please try again later.';
            const alert = document.getElementById('alert')
            alert.classList.remove('hidden');
            alert.scrollIntoView();
        }
      }
      (async function() {
        const response = await fetch('/favorites', {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        if (response.status == 200) {
          const data = await response.json();
          const hearts = document.getElementsByClassName('heart-button');
          for (let i = 0; i < hearts.length; i++) {
            if (data.characters.includes(parseInt(hearts[i].id))) {
              hearts[i].classList.remove('text-gray-400', 'hover:text-red-500');
              hearts[i].classList.add('hover:text-gray-400', 'text-red-500');
            }
          }
          if (data.comics.includes({{ $comic->id }})) {
            const heart = document.getElementById({{ $comic->id }});
            heart.classList.remove('text-gray-400', 'hover:text-red-500');
            heart.classList.add('text-red-500', 'hover:text-gray-400');
            heart.innerHTML = heart.innerHTML.replace('Add to favorites', 'Remove from favorites');
          }
        }
      })();
  </script>
</x-app-layout>
