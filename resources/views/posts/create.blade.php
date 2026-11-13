@extends('layouts.app')

@section('title', 'New Notice - Barangay Bulletin')

@section('content')
<div class="relative board-frame rounded-2xl p-4 sm:p-10 my-3 max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center text-sm font-bold text-stone-900 bg-[#fdfaf5] hover:bg-white px-5 py-2.5 rounded-lg shadow-md border-2 border-stone-400 transition">
            📌 &larr; Back to Bulletin Board
        </a>
    </div>

    <div class="bg-[#fefdfa] border-2 border-stone-300 rounded-2xl p-6 sm:p-8 shadow-xl">
        <h1 class="text-2xl sm:text-3xl font-black text-stone-950 mb-6 pb-4 border-b-2 border-stone-200">
            ✍️ Post a New Community Notice
        </h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-100 border border-rose-300 text-rose-900 rounded-xl text-sm">
                <p class="font-bold mb-1">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('posts.store') }}" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Notice Title <span class="text-rose-600">*</span>
                </label>
                <input 
                    type="text" 
                    id="title"
                    name="title" 
                    value="{{ old('title') }}" 
                    required 
                    maxlength="120"
                    placeholder="e.g. Schedule of Free Anti-Rabies Vaccination" 
                    class="w-full px-4 py-2.5 border-2 border-stone-300 rounded-lg focus:outline-none focus:border-amber-600 text-stone-900 text-sm font-semibold"
                >
                @error('title')
                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Category <span class="text-rose-600">*</span>
                </label>
                <select 
                    id="category"
                    name="category" 
                    required
                    class="w-full px-4 py-2.5 border-2 border-stone-300 rounded-lg focus:outline-none focus:border-amber-600 text-stone-900 text-sm font-semibold cursor-pointer"
                >
                    <option value="">Select a category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags (Checkboxes) -->
            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">
                    Tags <span class="text-rose-600">*</span> (Choose at least one)
                </span>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($tags as $tag)
                        <label class="flex items-center space-x-2 bg-stone-50 p-2.5 rounded-lg border border-stone-200 hover:bg-stone-100 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="tags[]" 
                                value="{{ $tag->id }}"
                                @checked(is_array(old('tags')) && in_array($tag->id, old('tags')))
                                class="rounded border-stone-300 text-amber-600 focus:ring-amber-500 w-4 h-4 cursor-pointer"
                            >
                            <span class="text-xs font-semibold text-stone-800">#{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tags')
                    <p class="text-xs text-rose-600 mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Body -->
            <div>
                <label for="body" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Announcement Body <span class="text-rose-600">*</span> (Minimum 20 characters)
                </label>
                <textarea 
                    id="body"
                    name="body" 
                    rows="6" 
                    required 
                    placeholder="Provide complete details about the community notice..."
                    class="w-full px-4 py-2.5 border-2 border-stone-300 rounded-lg focus:outline-none focus:border-amber-600 text-stone-900 text-sm"
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Published -->
            <div class="p-4 bg-amber-50/60 rounded-xl border border-amber-200">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="is_published" 
                        value="1" 
                        @checked(old('is_published', true))
                        class="rounded border-stone-300 text-amber-600 focus:ring-amber-500 w-4 h-4 cursor-pointer"
                    >
                    <div>
                        <span class="text-sm font-bold text-stone-900">Publish immediately to bulletin board</span>
                        <p class="text-xs text-stone-500">Uncheck to save as draft</p>
                    </div>
                </label>
                @error('is_published')
                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-stone-200">
                <a href="{{ route('posts.index') }}" class="text-sm font-bold text-stone-600 hover:text-stone-900">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-bold px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition cursor-pointer text-sm"
                >
                    Publish Notice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

