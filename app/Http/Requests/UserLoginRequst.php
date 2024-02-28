<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserLoginRequst extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
            // 'password' => [Password::min(8)->symbols()->numbers()],
        ];
    }

    public function authenticate(): array
    {
        $this->ensureIsNotRateLimited();

        $user = Customer::where('email', $this->email)->first();
        
        // if (!$user || !Hash::check($this->password, $user->password)) {

        if (!Auth::guard('customer')->attempt(['email' => $this->validated('email'), 'password' => $this->validated('password'), 'status' => 1], $this->boolean('remember'))) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        $token = $user->createToken('auth_token')->plainTextToken;
        return compact('user', 'token');
    }

   
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
