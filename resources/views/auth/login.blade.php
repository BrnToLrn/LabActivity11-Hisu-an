@extends('layouts.app')

@section('title', 'Sign In - Barangay Bulletin')

@section('content')
<div class="max-w-md mx-auto my-12">
    <div class="bg-white rounded-2xl shadow-xl border border-stone-200 overflow-hidden">
        <div class="bg-[#341b0b] px-6 py-6 text-amber-50 text-center">
            <h2 class="text-2xl font-bold">Barangay Bulletin Login</h2>
            <p class="text-amber-200 text-sm mt-1">Sign in to post notices and comments</p>
        </div>

        <form method="POST" action="/login" class="p-6 sm:p-8 space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1">Email Address</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="kagawad.hisuan@bulletin.test"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-stone-800 placeholder-stone-400 text-sm transition"
                >
                @error('email') 
                    <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="••••••••" 
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-stone-800 placeholder-stone-400 text-sm transition"
                >
                @error('password') 
                    <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <button 
                type="submit" 
                class="w-full py-2.5 px-4 bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-150 cursor-pointer text-sm"
            >
                Sign in
            </button>

            <div class="pt-2 border-t border-stone-100 text-center">
                <p class="text-xs text-stone-500">
                    Default credentials: <span class="font-mono text-stone-700 font-semibold">bulletin2026</span>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

