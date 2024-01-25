<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

</head>
<style>
     html, body {
    height: 100%;

}
.footer {
      position: fixed;
      bottom: 0;
      width: 100%;
    }
</style>
@include('page.user.template.navbar')


<body class="bg-sky-950">

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="flex mx-auto rounded-lg lg:max-w-prose">

            <div class="w-full px-6 py-8 md:px-8 lg:w-1xl">
                <div class="flex justify-center mx-auto">
                </div>

                <p class="mt-3 text-xl text-center text-white  ">
                  Silahkan Login Dulu Ya!!
                </p>

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-white  " for="LoggingEmailAddress">Email Address</label>
                    <input id="LoggingEmailAddress" name="email" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" type="email" />
                </div>

                <div class="mt-4">
                    <div class="flex justify-between">
                        <label class="block mb-2 text-sm font-medium text-white " for="loggingPassword">Password</label>
                    </div>

                    <input id="loggingPassword" name="password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" type="password" />
                </div>
                <a href="#" class="text-xs text-white  hover:underline">Forget Password?</a>

                <div class="mt-6">
                    <button class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        {{ __('Log in') }}
                    </button>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>

                    <a href="/register" class="text-xs  uppercase text-white  hover:underline">or sign up</a>

                    <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
                </div>
            </div>
        </div>
    </form>

</body>
<footer class="footer footer-center p-4 bg-base-300 text-base-content">
    <aside>
      <p>Copyright © 2023 - All right reserved by Toko Baju XYZ </p>
    </aside>
</footer>

</html>



