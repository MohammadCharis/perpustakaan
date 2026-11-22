<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-login-title">Masuk</h2>
        <div class="mx-auto mt-4 h-1 w-12 rounded-full bg-login-blue"></div>
        <p class="mt-4 text-sm text-login-muted">Masuk untuk mengelola perpustakaan</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ submitting: false, showPassword: false }" @submit="submitting = true">
        @csrf
        <div>
            <label for="email" class="sr-only">Email</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-0 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center text-login-muted">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6"/></svg>
                </span>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email..." class="login-underline-input pl-8" aria-describedby="email-error">
            </div>
            @error('email')
                <p id="email-error" class="mt-2 text-xs font-medium text-red-600">{{ $message === 'These credentials do not match our records.' ? 'Email atau kata sandi salah.' : $message }}</p>
            @enderror
        </div>

        <div class="mt-6">
            <label for="password" class="sr-only">Kata sandi</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-0 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center text-login-muted">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="4" y="10" width="16" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                </span>
                <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="current-password" placeholder="Masukkan kata sandi..." class="login-underline-input pl-8 pr-10" aria-describedby="password-error">
                <button type="button" @click="showPassword = !showPassword" class="absolute right-0 top-1/2 -translate-y-1/2 rounded-lg p-2 text-login-muted hover:text-login-blue focus:outline-none focus:ring-2 focus:ring-login-blue" :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.58 10.58a2 2 0 0 0 2.83 2.83M9.88 4.24A10.7 10.7 0 0 1 12 4c6 0 9.75 8 9.75 8a17.4 17.4 0 0 1-3.04 4.06M6.61 6.61C3.9 8.24 2.25 12 2.25 12S6 20 12 20a10.7 10.7 0 0 0 2.12-.21"/></svg>
                </button>
            </div>
            @error('password')
                <p id="password-error" class="mt-2 text-xs font-medium text-red-600">{{ $message === 'These credentials do not match our records.' ? 'Email atau kata sandi salah.' : $message }}</p>
            @enderror
        </div>

        <div class="mt-5 flex items-center justify-between gap-3 text-xs">
            <label for="remember" class="inline-flex items-center gap-2 text-login-title"><input id="remember" type="checkbox" name="remember" class="rounded border-login-line text-login-blue shadow-sm focus:ring-login-blue"> Ingat saya</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-semibold text-login-blue hover:text-login-blue">Lupa kata sandi?</a>
            @endif
        </div>

        <button type="submit" :disabled="submitting" class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-login-blue px-5 py-3.5 text-sm font-bold tracking-wide text-white shadow-[0_8px_16px_rgba(41,121,255,0.35)] transition hover:-translate-y-0.5 hover:bg-login-blue focus:outline-none focus:ring-2 focus:ring-login-blue focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70">
            <span x-show="!submitting">MASUK</span><span x-show="submitting" x-cloak>Memproses...</span>
        </button>
    </form>
</x-guest-layout>
