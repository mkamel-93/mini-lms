<?php

declare(strict_types=1);

namespace App\Core;

use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;

class BaseComponent extends Component
{
    /**
     * Common rate limiting logic for all components.
     *
     * * @param string $action The name of the action (e.g., 'enroll')
     * @param  int  $maxAttempts  Number of allowed attempts
     * @param  int  $decaySeconds  Time to wait before reset (default 60)
     * @return bool Returns true if the user is rate limited
     */
    protected function isThrottled(string $action, int $maxAttempts = 1, int $decaySeconds = 60): bool
    {
        // Unique key per user, per component (static), and per specific action
        $key = sprintf(
            '%s:%u:%s',
            static::class,
            auth()->id() ?? request()->ip(),
            $action
        );

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            logger($key);
            $seconds = RateLimiter::availableIn($key);

            session()->flash('error', "Too manymanymany attempts. Please wait {$seconds}s.");

            return true;
        }

        RateLimiter::hit($key, $decaySeconds);

        return false;
    }
}
