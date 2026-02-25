<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Create an account')"
            :description="__('Enter your details below to create your account')"
        />

        <!-- Session Status -->
        <x-auth-session-status
            class="text-center"
            :status="session('status')"
        />

        <form
            class="flex flex-col gap-6"
            method="POST"
            action="{{ route('register.store') }}"
        >
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                type="text"
                :label="__('Name')"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                type="email"
                :label="__('Email address')"
                :value="old('email')"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                type="password"
                :label="__('Password')"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                type="password"
                :label="__('Confirm password')"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button
                    class="w-full"
                    data-test="register-user-button"
                    type="submit"
                    variant="primary"
                >
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 text-center text-sm text-zinc-600 rtl:space-x-reverse dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link
                :href="route('login')"
                wire:navigate
            >{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
