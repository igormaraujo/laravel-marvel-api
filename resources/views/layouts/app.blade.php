<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="h-full">
  <div class="min-h-full">
    <nav class="bg-red-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg"
                class="block h-10 w-auto fill-current text-gray-100">
                <path
                  d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z" />
              </svg>
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <a href="{{ route('home') }}" @class([
                    'bg-red-900 text-white' => Route::is('home'),
                    'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is('home'),
                    'px-3 py-2 rounded-md text-sm font-medium',
                ])>Home</a>
                <a href="{{ route('characters.index') }}" @class([
                    'bg-red-900 text-white' => Route::is('characters.index'),
                    'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is(
                        'characters.index',
                    ),
                    'px-3 py-2 rounded-md text-sm font-medium',
                ])>Characters</a>
                <a href="{{ route('comics.index') }}" @class([
                    'bg-red-900 text-white' => Route::is('comics.index'),
                    'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is(
                        'comics.index',
                    ),
                    'px-3 py-2 rounded-md text-sm font-medium',
                ])>Comics</a>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <a id="login-button" href="{{ route('login') }}"
                class="text-gray-300 hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
              <a id="register-button" href="{{ route('register') }}"
                class="text-gray-300 hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
              <a id="favorites-button" href="{{ route('favorites.index') }}" @class([
                  'bg-red-900 text-white' => Route::is('favorites.index'),
                  'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is(
                      'favorites.index',
                  ),
                  'px-3 py-2 rounded-md text-sm font-medium hidden',
              ])>My
                Favorites</a>
              <form id="logout-button" action="{{ route('logout') }}" method="POST" class="hidden">
                <input type="hidden" name="_token" value="" />
                <button type="submit"
                  class='text-gray-300 hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'>Logout</button>
              </form>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <button type="button"
              class="bg-red-900 inline-flex items-center justify-center p-2 rounded-md text-red-400 hover:text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-800 focus:ring-white"
              onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" aria-controls="mobile-menu"
              aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <!--
                    Heroicon name: outline/menu

                    Menu open: "hidden", Menu closed: "block"
                  -->
              <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <!--
                    Heroicon name: outline/x

                    Menu open: "block", Menu closed: "hidden"
                  -->
              <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu, show/hide based on menu state. -->
      <div class="hidden md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
          <a href="{{ route('home') }}" @class([
              'bg-red-900 text-white' => Route::is('home'),
              'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is('home'),
              'block py-2 rounded-md text-base font-medium pl-2',
          ])>Home</a>

          <a href="{{ route('characters.index') }}" @class([
              'bg-red-900 text-white' => Route::is('characters.index'),
              'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is(
                  'characters.index',
              ),
              'block py-2 rounded-md text-base font-medium pl-2',
          ])>Characters</a>

          <a href="{{ route('comics.index') }}" @class([
              'bg-red-900 text-white' => Route::is('comics.index'),
              'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is(
                  'comics.index',
              ),
              'block py-2 rounded-md text-base font-medium pl-2',
          ])>Comics</a>

          <a id="mb-login-button" href="{{ route('login') }}" class="text-gray-300 hover:bg-red-700 hover:text-white block py-2 rounded-md text-base font-medium pl-2">Login</a>
          <a id="mb-register-button" href="{{ route('register') }}" class="text-gray-300 hover:bg-red-700 hover:text-white block py-2 rounded-md text-base font-medium pl-2">Register</a>
          <a id="mb-favorites-button" href="{{ route('favorites.index') }}" @class([
              'bg-red-900 text-white' => Route::is('favorites.index'),
              'text-gray-300 hover:bg-red-700 hover:text-white' => !Route::is(
                  'favorites.index',
              ),
              'block py-2 rounded-md text-base font-medium pl-2 hidden',
          ])>My Favorites</a>
          <form id="mb-logout-button" action="{{ route('logout') }}" method="POST" class="hidden">
            <input type="hidden" name="_token" value="" />
            <button type="submit"
              class='text-gray-300 hover:bg-red-700 hover:text-white block py-2 rounded-md text-base font-medium pl-2'>Logout</button>
          </form>
        </div>
      </div>
    </nav>

    @if (!Route::is('home'))
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold text-gray-900">
            {{ $header }}
          </h1>
        </div>
      </header>
    @endif
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{ $slot }}
      </div>
    </main>
    <footer class="border-t bg-red-800">
      <div
        class="
              container
              flex flex-col flex-wrap
              px-4
              py-16
              mx-auto
              md:items-center
              lg:items-start
              md:flex-row md:flex-nowrap
            ">
        <div class="flex-shrink-0 w-64 mx-auto text-center md:mx-0 md:text-left">
          <a
            class="
                  flex
                  items-center
                  justify-center
                  md:justify-start
                ">
            <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg"
              class="block h-32 w-auto fill-current text-gray-100">
              <path
                d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z" />
            </svg>
          </a>
        </div>
        <div class="justify-between w-full mt-4 text-center lg:flex">
          <div class="w-full px-4 lg:w-1/3 md:w-1/2">
            <h2 class="mb-2 font-bold tracking-widest text-white">
              Useful Links
            </h2>
            <ul class="mb-8 space-y-2 text-sm list-none">
              <li>
                <a class="text-gray-300 hover:text-white" href="{{ route('home') }}">Home</a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white" href="{{ route('characters.index') }}">Characters</a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white" href="{{ route('comics.index') }}">Comics</a>
              </li>
            </ul>
          </div>
          <div class="w-full px-4 lg:w-1/3 md:w-1/2">
            <h2 class="mb-2 font-bold tracking-widest text-white">
              Useful Links
            </h2>
            <ul class="mb-8 space-y-2 text-sm list-none">
              <li>
                <a class="text-gray-300 hover:text-white" href="{{ route('login') }}">Login</a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white" href="{{ route('register') }}">Register</a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white" href="{{ route('favorites.index') }}">My Favorites</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="flex justify-center">
        <p class="text-base text-white">
          Data provided by Marvel. © 2021 Marvel
        </p>
      </div>
    </footer>

  </div>
  <script>
    var prev_handler = window.onload;
    window.onload = async function() {
      const response = await fetch('/user', {redirect: 'manual'});
      if (response.ok) {
        const user = await response.json();
        document.querySelector('meta[name="csrf-token"]').content = user.token;
        const forms = document.querySelectorAll('input[name="_token"]');
        for (let i = 0; i < forms.length; i++) {
          forms[i].value = user.token;
        }
        document.getElementById('login-button').classList.toggle('hidden');
        document.getElementById('register-button').classList.toggle('hidden');
        document.getElementById('favorites-button').classList.toggle('hidden');
        document.getElementById('logout-button').classList.toggle('hidden');
        document.getElementById('mb-login-button').classList.toggle('hidden');
        document.getElementById('mb-register-button').classList.toggle('hidden');
        document.getElementById('mb-favorites-button').classList.toggle('hidden');
        document.getElementById('mb-logout-button').classList.toggle('hidden');
      }
    }
  </script>
</body>

</html>
