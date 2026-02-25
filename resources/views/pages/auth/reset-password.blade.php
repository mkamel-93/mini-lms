<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Reset password')"
            :description="__('Please enter your new password below')"
        />

        <!-- Session Status -->
        <x-auth-session-status
            class="text-center"
            :status="session('status')"
        />

        <form
            class="flex flex-col gap-6"
            method="POST"
            action="{{ route('password.update') }}"
        >
            @csrf
            <!-- Token -->
            <input
                name="token"
                type="hidden"
                value="{{ request()->route('token') }}"
            >

            <!-- Email Address -->
            <flux:input
                name="email"
                type="email"
                value="{{ request('email') }}"
                :label="__('Email')"
                required
                autocomplete="email"
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
                    data-test="reset-password-button"
                    type="submit"
                    variant="primary"
                >
                    {{ __('Reset password') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>
