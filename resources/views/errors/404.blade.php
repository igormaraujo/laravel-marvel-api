<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="antialiased">
  <div class="relative flex items-top justify-center min-h-screen bg-red-800 sm:items-center sm:pt-0">
    <div class="max-w-xl mx-auto sm:px-6">
      <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
        <div class="px-4 text-lg text-white border-r border-white tracking-wider">
          404 </div>

        <div class="ml-4 text-lg text-white uppercase tracking-wider">
          Not Found </div>
      </div>
      <p class="text-white text-3xl my-3">Sorry, we couldn't find the resource that you are looking for. Here are a few actions that may help you:</p>
      <div class="flex gap-2">
        <button onclick="history.back()" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-4 md:text-lg md:px-10">Go back</button>
        <a href="{{ route('characters.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-4 md:text-lg md:px-10" >Search for characters</a>
        <a href="{{ route('comics.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-4 md:text-lg md:px-10" >Search for comics</a>
      </div>
    </div>
  </div>
</body>

</html>
