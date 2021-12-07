<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Characters
    </h2>
  </x-slot>
  <div id="alert" @class(["hidden" => !($cache ?? false), "bg-red-600"])>
    <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between flex-wrap">
        <div class="w-0 flex-1 flex items-center">
          <p id="alert-text" class="ml-3 font-medium text-white">
              It's looks like that some problem occurred while fetching data from Marvel API. We are showing a cached version of the data that may be outdated.
          </p>
        </div>
        <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
          <button onclick="document.location.reload(true);" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-red-600 bg-white hover:bg-red-50">
            Try again
          </button>
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
  <div class="flex flex-col">
    <div class="flex">
      <input type="text" name="search" id="search"
        class="focus:ring-red-500 focus:border-red-500 flex-1 block w-full rounded-none rounded-r-md border-gray-300 py-4 my-4"
        placeholder="Search by title" onkeyup="searchCharacter(event)">
      <select name="limit" id="limit" onchange="changeOrder(event)"
        class="focus:ring-red-500 focus:border-red-500 border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 my-4"">
        <option value=" A-Z"> A-Z</option>
        <option value="Z-A" @if (request()->get('orderBy') == '-title') selected @endif>Z-A</option>
      </select>
    </div>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-50">
              <tr>
                <th class="w-2"></th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Name
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($characters['results'] as $character)
                <tr>
                  <td class="whitespace-nowrap pl-4">
                    <button type="button" id="{{ $character['id'] }}" onclick="like(this)"
                      class="heart-button bg-white p-1 rounded-full text-gray-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-800 focus:ring-white mx-auto">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                          d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                          clip-rule="evenodd" />
                      </svg>
                    </button>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10"
                          src="{{ gettype($character['thumbnail']) == 'string' ? str_replace('portrait_uncanny', 'standard_small',$character['thumbnail']) : $character['thumbnail']['path'] . '/standard_small.' . $character['thumbnail']['extension'] }}"
                          alt="{{ $character['name'] }}">
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                          {{ $character['name'] }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('characters.show', [$character['id']]) }}"
                      class="text-red-600 hover:text-red-900">View</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div @class([
              'hidden' => $characters['total'] != 0,
              'flex justify-center bg-gray-50',
          ])>
            <p class="text-base text-gray-400 py-5">
              No characters found
            </p>
          </div>
          <div @class([
              'hidden' => $characters['total'] == 0,
              'bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6',
          ])>
            <div class="flex-1 flex justify-between sm:hidden">
              <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['previus'] - 1) * ($params['limit'] ?? 10)])) }}"
                @class([
                    'hidden' => $pagination['current'] == $pagination['first'],
                    'relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50',
                ])>
                Previous
              </a>
              <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['next'] - 1) * ($params['limit'] ?? 10)])) }}"
                @class([
                    'hidden' => $pagination['current'] == $pagination['last'],
                    'relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50',
                ])>
                Next
              </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing
                  <select name="limit" id="limit" onchange="changePagination(event)"
                    class="focus:ring-red-500 focus:border-red-500 border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"">
                    <option value=" 10">10</option>
                    <option value="25" @if (request()->get('limit') == '25') selected @endif>25</option>
                    <option value="50" @if (request()->get('limit') == '50') selected @endif>50</option>
                    <option value="100" @if (request()->get('limit') == '100') selected @endif>100</option>
                  </select>
                  items,
                  <span class="font-medium">{{ $characters['offset'] + 1 }}</span>
                  to
                  <span class="font-medium"> {{ $characters['offset'] + $characters['count'] }}</span>
                  of
                  <span class="font-medium">{{ $characters['total'] }} </span>
                  results

                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['previus'] - 1) * ($params['limit'] ?? 10)])) }}"
                    @class([
                        'cursor-default pointer-events-none' =>
                            $pagination['current'] == $pagination['first'],
                        'hover:bg-gray-50' => $pagination['current'] != $pagination['first'],
                        'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500',
                    ])>
                    <span class="sr-only">Previous</span>
                    <!-- Heroicon name: solid/chevron-left -->
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                      fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                    </svg>
                  </a>
                  <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['first'] - 1) * ($params['limit'] ?? 10)])) }}"
                    @class([
                        'hidden' => $pagination['current'] == $pagination['first'],
                        'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                    ])>
                    {{ $pagination['first'] }}
                  </a>
                  <span @class([
                      'hidden' => $pagination['previus'] <= $pagination['first'],
                      'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700',
                  ])>
                    ...
                  </span>
                  <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['previus'] - 1) * ($params['limit'] ?? 10)])) }}"
                    @class([
                        'hidden' => $pagination['previus'] <= $pagination['first'],
                        'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                    ])>
                    {{ $pagination['previus'] }}
                  </a>
                  <a href="#"
                    class="z-10 bg-red-50 border-red-500 text-red-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                    {{ $pagination['current'] }}
                  </a>
                  <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['next'] - 1) * ($params['limit'] ?? 10)])) }}"
                    @class([
                        'hidden' => $pagination['next'] >= $pagination['last'] - 1,
                        'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                    ])>
                    {{ $pagination['next'] }}
                  </a>
                  <span @class([
                      'hidden' => $pagination['next'] >= $pagination['last'] - 1,
                      'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700',
                  ])>
                    ...
                  </span>
                  <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['last'] - 1) * ($params['limit'] ?? 10)])) }}"
                    @class([
                        'hidden' => $pagination['current'] == $pagination['last'],
                        'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                    ])>
                    {{ $pagination['last'] }}
                  </a>
                  <a href="{{ route('characters.index', array_merge($params, ['offset' => ($pagination['next'] - 1) * ($params['limit'] ?? 10)])) }}"
                    @class([
                        'cursor-default pointer-events-none' =>
                            $pagination['current'] == $pagination['last'],
                        'hover:bg-gray-50' => $pagination['current'] != $pagination['last'],
                        'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500',
                    ])>
                    <span class="sr-only">Next</span>
                    <!-- Heroicon name: solid/chevron-right -->
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                      fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                    </svg>
                  </a>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function searchCharacter(evt) {
      if (evt.code == "Enter" || evt.code == "NumpadEnter") {
        window.location.href = '{{ route('characters.index', array_merge($params, ['offset' => 0, 'nameStartsWith' => null])) }}'.replaceAll('&amp;',
          '&') + '&nameStartsWith=' + evt.target.value;
      }
    }

    function changePagination(evt) {
      switch (evt.target.value) {
        case '10':
          window.location.href = "{{ route('characters.index', array_merge($params, ['offset' => 0, 'limit' => 10])) }}"
            .replaceAll('&amp;', '&');
          break;
        case '25':
          window.location.href = "{{ route('characters.index', array_merge($params, ['offset' => 0, 'limit' => 25])) }}"
            .replaceAll('&amp;', '&');
          break;
        case '50':
          window.location.href = "{{ route('characters.index', array_merge($params, ['offset' => 0, 'limit' => 50])) }}"
            .replaceAll('&amp;', '&');
          break;
        case '100':
          window.location.href = "{{ route('characters.index', array_merge($params, ['offset' => 0, 'limit' => 100])) }}"
            .replaceAll('&amp;', '&');
          break;
      }
    }

    function changeOrder(evt) {
      switch (evt.target.value) {
        case 'A-Z':
          window.location.href =
            '{{ route('characters.index', array_merge($params, ['offset' => 0, 'orderBy' => 'name'])) }}'.replaceAll(
              '&amp;', '&');
          break;
        case 'Z-A':
          window.location.href =
            '{{ route('characters.index', array_merge($params, ['offset' => 0, 'orderBy' => '-name'])) }}'.replaceAll(
              '&amp;', '&');
          break;
      }
    }
    async function like(heart) {
      const add = heart.classList.contains('text-gray-400');
      const response = await fetch('/characters/' + heart.id, {
        method: add ? 'PUT' : 'DELETE',
        redirect: 'manual',
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
    (async function() {
      const response = await fetch('/characters/favorites', {
        redirect: 'manual',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      if (response.status == 200) {
        const data = await response.json();
        const hearts = document.getElementsByClassName('heart-button');
        for (let i = 0; i < hearts.length; i++) {
          if (data.includes(parseInt(hearts[i].id))) {
            hearts[i].classList.remove('text-gray-400', 'hover:text-red-500');
            hearts[i].classList.add('hover:text-gray-400', 'text-red-500');
          }
        }
      }
    })();
  </script>
</x-app-layout>
