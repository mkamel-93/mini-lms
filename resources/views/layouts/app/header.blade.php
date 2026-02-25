<!DOCTYPE html>
<html
    class="dark"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header
        class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900"
        container
    >
        <flux:sidebar.toggle
            class="mr-2 lg:hidden"
            icon="bars-2"
            inset="left"
        />

        <x-app-logo
            href="{{ route('dashboard') }}"
            wire:navigate
        />

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item
                icon="layout-grid"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate
            >
                {{ __('Dashboard') }}
            </flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <flux:navbar class="py-0! me-1.5 space-x-0.5 rtl:space-x-reverse">
            <flux:tooltip
                :content="__('Search')"
                position="bottom"
            >
                <flux:navbar.item
                    class="!h-10 [&>div>svg]:size-5"
                    href="#"
                    icon="magnifying-glass"
                    :label="__('Search')"
                />
            </flux:tooltip>
            <flux:tooltip
                :content="__('Repository')"
                position="bottom"
            >
                <flux:navbar.item
                    class="h-10 max-lg:hidden [&>div>svg]:size-5"
                    href="https://github.com/laravel/livewire-starter-kit"
                    icon="folder-git-2"
                    target="_blank"
                    :label="__('Repository')"
                />
            </flux:tooltip>
            <flux:tooltip
                :content="__('Documentation')"
                position="bottom"
            >
                <flux:navbar.item
                    class="h-10 max-lg:hidden [&>div>svg]:size-5"
                    href="https://laravel.com/docs/starter-kits#livewire"
                    icon="book-open-text"
                    target="_blank"
                    :label="__('Documentation')"
                />
            </flux:tooltip>
        </flux:navbar>

        <x-desktop-user-menu />
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar
        class="border-e border-zinc-200 bg-zinc-50 lg:hidden dark:border-zinc-700 dark:bg-zinc-900"
        collapsible="mobile"
        sticky
    >
        <flux:sidebar.header>
            <x-app-logo
                href="{{ route('dashboard') }}"
                :sidebar="true"
                wire:navigate
            />
            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2"
            />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Platform')">
                <flux:sidebar.item
                    icon="layout-grid"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate
                >
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item
                href="https://github.com/laravel/livewire-starter-kit"
                icon="folder-git-2"
                target="_blank"
            >
                {{ __('Repository') }}
            </flux:sidebar.item>
            <flux:sidebar.item
                href="https://laravel.com/docs/starter-kits#livewire"
                icon="book-open-text"
                target="_blank"
            >
                {{ __('Documentation') }}
            </flux:sidebar.item>
        </flux:sidebar.nav>
    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
</body>

</html>
