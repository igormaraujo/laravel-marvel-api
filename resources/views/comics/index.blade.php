<x-guest-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Comics
    </h2>
  </x-slot>
  <div class="flex flex-col">
    <div class="flex">
      <input type="text" name="search" id="search"
        class="focus:ring-red-500 focus:border-red-500 flex-1 block w-full rounded-none rounded-r-md border-gray-300 py-4 my-4"
        placeholder="Search by title" onkeyup="searchComics(event)">
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
                <th></th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Title
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($comics['results'] as $comic)
                <tr>
                  <td class="whitespace-nowrap pl-4">
                    <button type="button" id="{{ $comic['id'] }}" onclick="like(this)"
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
                          src="{{ $comic['thumbnail']['path'] . '/standard_small.' . $comic['thumbnail']['extension'] }}"
                          alt="{{ $comic['title'] }}">
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                          {{ $comic['title'] }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{route('comics.show', [$comic['id']])}}" class="text-red-600 hover:text-red-900">View</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div @class([
              'hidden' => $comics['total'] != 0,
              'flex justify-center bg-gray-50',
          ])>
            <p class="text-base text-gray-400 py-5">
              No comics found
            </p>
          </div>
          <div @class([
              'hidden' => $comics['total'] == 0,
              'bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6',
          ])>
            <div class="flex-1 flex justify-between sm:hidden">
              <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['previus'] - 1) * ($params['limit'] ?? 10)])) }}"
                @class([
                  'hidden' => $pagination['current'] == $pagination['first'],
                  "relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                ])
                >
                Previous
              </a>
              <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['next'] - 1) * ($params['limit'] ?? 10)])) }}"
                @class([
                  'hidden' => $pagination['current'] == $pagination['last'],
                  "relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
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
                  <span class="font-medium">{{ $comics['offset'] + 1 }}</span>
                  to
                  <span class="font-medium"> {{ $comics['offset'] + $comics['count'] }}</span>
                  of
                  <span class="font-medium">{{ $comics['total'] }} </span>
                  results

                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['previus'] - 1) * ($params['limit'] ?? 10)])) }}"
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
                  <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['first'] - 1) * ($params['limit'] ?? 10)])) }}"
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
                  <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['previus'] - 1) * ($params['limit'] ?? 10)])) }}"
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
                  <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['next'] - 1) * ($params['limit'] ?? 10)])) }}"
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
                  <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['last'] - 1) * ($params['limit'] ?? 10)])) }}"
                    @class([
                        'hidden' => $pagination['current'] == $pagination['last'],
                        'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                    ])>
                    {{ $pagination['last'] }}
                  </a>
                  <a href="{{ route('comics.index', array_merge($params, ['offset' => ($pagination['next'] - 1) * ($params['limit'] ?? 10)])) }}"
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
    function searchComics(evt) {
      if (evt.code == "Enter" || evt.code == "NumpadEnter") {
        window.location.href = '{{ route('comics.index', array_merge($params, ['offset' => 0])) }}'.replaceAll('&amp;',
          '&') + '&titleStartsWith=' + evt.target.value;
      }
    }

    function changePagination(evt) {
      switch (evt.target.value) {
        case '10':
          window.location.href = "{{ route('comics.index', array_merge($params, ['offset' => 0, 'limit' => 10])) }}"
            .replaceAll('&amp;', '&');
          break;
        case '25':
          window.location.href = "{{ route('comics.index', array_merge($params, ['offset' => 0, 'limit' => 25])) }}"
            .replaceAll('&amp;', '&');
          break;
        case '50':
          window.location.href = "{{ route('comics.index', array_merge($params, ['offset' => 0, 'limit' => 50])) }}"
            .replaceAll('&amp;', '&');
          break;
        case '100':
          window.location.href = "{{ route('comics.index', array_merge($params, ['offset' => 0, 'limit' => 100])) }}"
            .replaceAll('&amp;', '&');
          break;
      }
    }

    function changeOrder(evt) {
      switch (evt.target.value) {
        case 'A-Z':
          window.location.href =
            '{{ route('comics.index', array_merge($params, ['offset' => 0, 'orderBy' => 'title'])) }}'.replaceAll(
              '&amp;', '&');
          break;
        case 'Z-A':
          window.location.href =
            '{{ route('comics.index', array_merge($params, ['offset' => 0, 'orderBy' => '-title'])) }}'.replaceAll(
              '&amp;', '&');
          break;
      }
    }
    async function like(heart) {
      const add = heart.classList.contains('text-gray-400');
      const response = await fetch('/comics/' + heart.id, {
        method: add ? 'PUT' : 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      if (response.status == 204) {
        if (add) {
          heart.classList.remove('text-gray-400', 'hover:text-red-500');
          heart.classList.add('text-red-500', 'hover:text-gray-400');
        } else {
          heart.classList.remove('text-red-500', 'hover:text-gray-400');
          heart.classList.add('text-gray-400', 'hover:text-red-500');
        }
      }
    }
    window.onload = async function() {
      const response = await fetch('/comics/favorites', {
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
            hearts[i].classList.remove('text-gray-400','hover:text-red-500');
            hearts[i].classList.add('hover:text-gray-400', 'text-red-500');
          }
        }
      }
    };
  </script>
</x-guest-layout>
