<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('template.navbar')
    @vite('resources/css/app.css')
</head>


<body>
    @include('template.loading')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="flex mx-auto rounded-lg lg:max-w-prose">

        <div class="w-full px-6 py-8 md:px-8 lg:w-1xl">
            <div class="flex justify-center mx-auto">
            </div>

            <p class="mt-3 text-xl text-center text-black  ">
                Selamat Bikin akun baru
            </p>
            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-black  " for="LoggingEmailAddress">Nama Lengkap</label>
                <input id="LoggingEmailAddress" type="text" name="name"  class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300"  />
            </div>

            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-black  " for="LoggingEmailAddress">Email Address</label>
                <input id="LoggingEmailAddress" name="email" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" type="email" />
            </div>

            <div class="mt-4">
                <div class="flex justify-between">
                    <label class="block mb-2 text-sm font-medium text-black " for="loggingPassword">Password</label>
                </div>

                <input id="loggingPassword" name="password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" type="password" />
            </div>
            <div class="mt-4">
                <div class="flex justify-between">
                    <label class="block mb-2 text-sm font-medium text-black " for="loggingPassword">Konfirmasi Password</label>
                </div>

                <input id="loggingPassword" name="password_confirmation" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" type="password" />
            </div>

            <div class="mt-6">
                <button class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                    {{ __('Register') }}
                </button>
            </div>


        </div>
    </div>
</form>
<br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</body>
@include('template.footer')
</html>
