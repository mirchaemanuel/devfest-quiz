<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GDG Pescara - DevFest Quiz</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                   class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                    in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full ">
        <div class="flex justify-center">
           <img class="w-[200px]" src="{{ Vite::asset('resources/assets/images/quizfest.png') }}" alt="Image logo" title="LOGO" />
        </div>

        <div class="mt-16">
            <section id="welcome" class="my-8 p-8">
                <h2 class="font-bold text-2xl text-center pb-4 mb-4 w-full border-b-2">{{ __('GDG Pescara - DevFest Quiz') }}</h2>
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-2 justify-between items-center font-medium text-xl mb-4 pb-4 border-b-2">
                    <div>
                        {{ __('Players :count', ['count' => $totalUsers]) }}
                    </div>
                    <div>
                        {{ __('Quizzes :count', ['count' => $totalQuizzes]) }}
                    </div>
                    <div>
                        {{ __('Quiz attempts :count', ['count' => $totalQuizAttempts]) }}
                    </div>
                </div>
                <div class="text-lg text-center mx-16 my-4">
                    {{ __("Welcome to the \"Journey of a Commit\" at DevFest. Let's embark on an exploratory path through the lifecycle of a commit. As we unravel the DevOps practices that bring ideas to production, this DevFest Quiz app serves as a real-world example, illustrating the pivotal stages from code commit to deployment. Get ready to dive into the DevFest challenge, test your knowledge, and see DevOps in action!") }}
                </div>
            </section>
            <section id="ranking" class="my-8 px-8 py-8 bg-white rounded">
                <h2 class="font-bold text-2xl mb-4">{{ __('Ranking') }}</h2>
                <div>
                    <livewire:ranking/>
                </div>
            </section>
        </div>

        <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
            <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                <div class="flex items-center gap-4">
                    <a href="https://www.netsons.com"
                       class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                        Netsons
                    </a>
                </div>
            </div>

            <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                Build with Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>
</div>
</body>
</html>
