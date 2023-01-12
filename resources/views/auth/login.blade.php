{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('./layouts.layout')

@section('title', 'Device')

<style>
    .form-login {
        background-color: #e9ecef;
        width: 300px;
    }
</style>

@section('content')
    <div class="content m-auto">
        <form action="{{ route('custom_login') }}" method="post" class="form-login p-3 rounded-3">
            @csrf
            <div class="form-group mt-2 mb-2">
                <label for="">Email address</label>
                <input type="text" class="form-control" name="email" placeholder="Enter your email">
                @if ($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                @if ($errors->has('password'))
                    <div class="text-danger">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="form-group mt-2">
                @if(session('message'))
                    <div class="text-danger">{{ session('message') }}</div>
                @endif
                <a href="">Quên mật khẩu?</a>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
    <script>
        $('.content-all').addClass('d-flex justify-content-center')
    </script>
@endsection
