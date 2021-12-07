<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      My Favorites
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
  <div class="shadow-md">
    <div class="tab w-full overflow-hidden border-t">
      <input class="absolute opacity-0" id="tab-single-one" type="radio" name="tabs2">
      <label class="block p-5 leading-normal cursor-pointer" for="tab-single-one">Characters</label>
      <div class="tab-content overflow-hidden border-l-2 bg-gray-100 border-red-600 leading-normal">
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 table-auto">
                  <thead class="bg-gray-50">
                    <tr>
                      <th></th>
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
                      <tr class="characters-row">
                        <td class="whitespace-nowrap pl-4">
                          <button type="button" id="{{ $character->id }}" onclick="like(this, 'characters')"
                            class="heart-button bg-white p-1 rounded-full hover:text-gray-400 text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-800 focus:ring-white mx-auto">
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
                              <img class="h-10 w-10" src="{{ $character->thumbnail }}" alt="{{ $character->name }}">
                            </div>
                            <div class="ml-4">
                              <div class="text-sm font-medium text-gray-900">
                                {{ $character->name }}
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                          <a href="{{ route('comics.show', [$character->id]) }}"
                            class="text-red-600 hover:text-red-900">View</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div
                  id="chracters-empty"
                  @class([
                    'hidden' => sizeof($characters) != 0,
                    'flex justify-center bg-gray-50',
                ])>
                  <p class="text-base text-gray-400 py-5">
                    You don't have favorites characters yet.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab w-full overflow-hidden border-t">
      <input class="absolute opacity-0" id="tab-single-two" type="radio" name="tabs2">
      <label class="block p-5 leading-normal cursor-pointer" for="tab-single-two">Comics</label>
      <div class="tab-content overflow-hidden border-l-2 bg-gray-100 border-red-600 leading-normal">
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 table-auto">
                  <thead class="bg-gray-50">
                    <tr>
                      <th></th>
                      <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                      </th>
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($comics as $comic)
                      <tr class="comics-row">
                        <td class="whitespace-nowrap pl-4">
                          <button type="button" id="{{ $comic->id }}" onclick="like(this, 'comics')"
                            class="heart-button bg-white p-1 rounded-full hover:text-gray-400 text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-800 focus:ring-white mx-auto">
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
                              <img class="h-10 w-10" src="{{ $comic->thumbnail }}" alt="{{ $comic->title }}">
                            </div>
                            <div class="ml-4">
                              <div class="text-sm font-medium text-gray-900">
                                {{ $comic->title }}
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                          <a href="{{ route('comics.show', [$comic->id]) }}"
                            class="text-red-600 hover:text-red-900">View</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div
                  id="comics-empty"
                  @class([
                    'hidden' => sizeof($comics) != 0,
                    'flex justify-center bg-gray-50',
                ])>
                  <p class="text-base text-gray-400 py-5">
                    You don't have favorites comics yet.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    var myRadios = document.getElementsByName('tabs2');
    var setCheck;
    var x = 0;
    for (x = 0; x < myRadios.length; x++) {
      myRadios[x].onclick = function() {
        if (setCheck != this) {
          setCheck = this;
        } else {
          this.checked = false;
          setCheck = null;
        }
      };
    }
    async function like(heart, resource) {
      const response = await fetch('/'+ resource +'/' + heart.id, {
        method: 'DELETE',
        redirect: 'manual',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      switch (response.status) {
        case 204:
          heart.parentElement.parentElement.classList.add('hidden')
          const remaing = document.querySelectorAll('tr.'+resource+'-row:not(.hidden)').length
          if (remaing == 0) {
            document.getElementById(resource+'-empty').classList.remove('hidden')
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
      const response = await fetch('/comics/favorites', {
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
  <style>
    /* Tab content - closed */
    .tab-content {
      max-height: 0;
      -webkit-transition: max-height .35s;
      -o-transition: max-height .35s;
      transition: max-height .35s;
    }

    /* :checked - resize to full height */
    .tab input:checked~.tab-content {
      max-height: 100vh;
    }

    /* Label formatting when open */
    .tab input:checked+label {
      /*@apply text-xl p-5 border-l-2 border-red-600 bg-gray-100 text-indigo*/
      font-size: 1.25rem;
      /*.text-xl*/
      padding: 1.25rem;
      /*.p-5*/
      border-left-width: 2px;
      /*.border-l-2*/
      border-color: #DC2626;
      /*.border-indigo*/
      background-color: #f8fafc;
      /*.bg-gray-100 */
      color: #DC2626;
      /*.text-indigo*/
    }

    /* Icon */
    .tab label::after {
      float: right;
      right: 0;
      top: 0;
      display: block;
      width: 1.5em;
      height: 1.5em;
      line-height: 1.5;
      font-size: 1.25rem;
      text-align: center;
      -webkit-transition: all .35s;
      -o-transition: all .35s;
      transition: all .35s;
    }

    /* Icon formatting - closed */
    .tab input[type=checkbox]+label::after {
      content: "+";
      font-weight: bold;
      /*.font-bold*/
      border-width: 1px;
      /*.border*/
      border-radius: 9999px;
      /*.rounded-full */
      border-color: #b8c2cc;
      /*.border-grey*/
    }

    .tab input[type=radio]+label::after {
      content: "\25BE";
      font-weight: bold;
      /*.font-bold*/
      border-width: 1px;
      /*.border*/
      border-radius: 9999px;
      /*.rounded-full */
      border-color: #b8c2cc;
      /*.border-grey*/
    }

    /* Icon formatting - open */
    .tab input[type=checkbox]:checked+label::after {
      transform: rotate(315deg);
      background-color: #DC2626;
      /*.bg-indigo*/
      color: #f8fafc;
      /*.text-grey-lightest*/
    }

    .tab input[type=radio]:checked+label::after {
      transform: rotateX(180deg);
      background-color: #DC2626;
      /*.bg-indigo*/
      color: #f8fafc;
      /*.text-grey-lightest*/
    }

  </style>
</x-app-layout>
