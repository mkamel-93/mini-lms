<!DOCTYPE html>
<html
    class="dark"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <!-- Navigation Header -->
    <header class="border-b border-zinc-200 dark:border-zinc-700">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a
                    class="text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100' }}"
                    href="{{ route('home') }}"
                    wire:navigate
                >
                    {{ __('Home') }}
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    @guest
                        <a
                            class="text-sm font-medium"
                            href="{{ route('login') }}"
                            wire:navigate
                        >
                            {{ __('Login') }}
                        </a>

                        <a
                            class="text-sm font-medium"
                            href="{{ route('register') }}"
                            wire:navigate
                        >
                            {{ __('Register') }}
                        </a>
                    @else
                        <a
                            class="text-sm font-medium"
                            href="{{ route('dashboard') }}"
                            wire:navigate
                        >
                            {{ __('Dashboard') }}
                        </a>

                        <form
                            class="inline text-sm font-medium ml-8"
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf
                            <button
                                class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100"
                                type="submit"
                            >
                                {{ __('Logout') }}
                            </button>
                        </form>
                    @endguest
                </nav>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button
                        class="p-2 text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100"
                        type="button"
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    >
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            class="hidden md:hidden border-t border-zinc-200 dark:border-zinc-700"
            id="mobile-menu"
        >
            <div class="px-2 pt-2 pb-3 space-y-1">
                @guest
                    <a
                        class="block px-3 py-2 text-base font-medium"
                        href="{{ route('login') }}"
                        wire:navigate
                    >
                        {{ __('Login') }}
                    </a>

                    <a
                        class="block px-3 py-2 text-base font-medium"
                        href="{{ route('register') }}"
                        wire:navigate
                    >
                        {{ __('Register') }}
                    </a>
                @else
                    <a
                        class="block px-3 py-2 text-base font-medium"
                        href="{{ route('dashboard') }}"
                        wire:navigate
                    >
                        {{ __('Dashboard') }}
                    </a>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf
                        <button
                            class="block w-full text-left px-3 py-2 text-base font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-50 dark:hover:bg-zinc-900"
                            type="submit"
                        >
                            {{ __('Logout') }}
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-zinc-200 dark:border-zinc-700 mt-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:justify-between sm:items-center">
                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                </div>

                <div class="flex space-x-6">
                    <a
                        class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100"
                        href="https://www.linkedin.com/in/mostafakamel-93/"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ __('Linked-in') }}
                    </a>

                    <a
                        class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100"
                        href="https://github.com/mkamel-93/mini-lms"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ __('Repository') }}
                    </a>

                    <a
                        class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100"
                        href="https://drive.google.com/drive/folders/1ABaBT5Fo2ulw_01Yvjfuk4H8mHHQVqid?usp=sharing"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ __('Docs') }}
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @fluxScripts
</body>

</html>
