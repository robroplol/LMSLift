<div class="sm:fixed sm:top-0 sm:right-0 p-6 text-end z-10">
    @auth
        <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-ada-orange" wire:navigate>Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="font-semibold text-white hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-ada-orange" wire:navigate>Log in</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ms-4 font-semibold text-white hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-ada-orange" wire:navigate>Register</a>
        @endif
    @endauth
</div>
