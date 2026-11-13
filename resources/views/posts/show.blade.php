@extends('layouts.app')

@section('title', 'Barangay Bulletin – Purok Hisu-an')

@section('content')
<div class="relative board-frame rounded-2xl p-4 sm:p-10 my-3 max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center text-sm sm:text-base font-bold text-stone-900 bg-[#fdfaf5] hover:bg-white px-5 py-2.5 rounded-lg shadow-md border-2 border-stone-400 transition">
            📌 &larr; Back to Bulletin Board
        </a>
    </div>

    <div class="relative max-w-3xl mx-auto">
        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20 text-3xl pin-head">
            @if ($post->is_pinned)
                <span>📌</span>
            @else
                <span>📍</span>
            @endif
        </div>

        <article class="bg-[#fefdfa] border-2 border-stone-300 rounded-2xl p-6 sm:p-10 shadow-2xl relative">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6 pb-4 border-b-2 border-stone-200">
                <span class="font-bold px-3.5 py-1 bg-amber-100 text-amber-950 rounded-md border border-amber-300 text-xs sm:text-sm tracking-wide">
                    {{ $post->category }}
                </span>

                <div class="flex items-center space-x-2">
                    @if ($post->is_pinned)
                        <span class="bg-red-700 text-white font-black px-3 py-1 rounded text-xs shadow-xs tracking-wider">
                            📌 OFFICIAL PINNED ADVISORY
                        </span>
                    @endif
                    <span class="text-stone-600 text-xs sm:text-sm font-semibold">
                        {{ $post->published_at ? $post->published_at->format('F d, Y \a\t h:i A') : 'Draft' }}
                    </span>
                </div>
            </div>

            <h1 class="text-2xl sm:text-4xl font-black text-stone-950 tracking-tight leading-tight mb-6">
                {{ $post->title }}
            </h1>

            <div class="text-stone-900 text-base sm:text-lg leading-relaxed whitespace-pre-line mb-6 border-l-4 border-amber-600/70 pl-4 py-1">
                {{ $post->body }}
            </div>

            @if ($post->tags->isNotEmpty())
                <div class="flex flex-wrap gap-1.5 mb-8">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="inline-block bg-stone-100 hover:bg-stone-200 border border-stone-300 text-stone-800 text-xs font-semibold px-2.5 py-1 rounded transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="pt-4 border-t-2 border-stone-200 flex items-center justify-between text-xs sm:text-sm font-bold text-stone-700">
                <a href="{{ route('authors.show', $post->author) }}" class="bg-stone-200/80 hover:bg-amber-200 text-stone-900 px-3 py-1 rounded-md transition">
                    ✍️ {{ $post->author?->name ?? 'Author #' . $post->author_id }} ({{ $post->author?->position }})
                </a>
                <span class="bg-stone-100 text-stone-900 px-3 py-1 rounded-md border border-stone-300">
                    👀 {{ $post->views }} Views
                </span>
            </div>
        </article>

        {{-- Comments Section --}}
        <section class="mt-8 bg-[#fefdfa] border-2 border-stone-300 rounded-2xl p-6 sm:p-8 shadow-xl">
            <h2 class="text-xl font-black text-stone-900 mb-6 flex items-center gap-2">
                <span>💬 Comments</span>
                <span class="text-sm font-semibold bg-stone-200 text-stone-800 px-2.5 py-0.5 rounded-full">
                    {{ $post->comments->count() }}
                </span>
            </h2>

            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-950 font-semibold rounded-xl text-sm">
                    ✅ {{ session('status') }}
                </div>
            @endif

            @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-8">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-rose-100 border border-rose-300 text-rose-900 rounded-xl text-sm">
                            <p class="font-bold mb-1">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="body" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Leave a Comment</label>
                        <textarea 
                            name="body" 
                            id="body" 
                            rows="3" 
                            required 
                            placeholder="Share your thoughts on this notice..."
                            class="w-full px-4 py-2.5 border-2 border-stone-300 rounded-lg focus:outline-none focus:border-amber-600 text-stone-800 text-sm"
                        >{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-amber-700 hover:bg-amber-800 text-white font-bold px-5 py-2 rounded-lg text-sm shadow transition cursor-pointer">
                        Post Comment
                    </button>
                </form>
            @else
                <div class="mb-8 p-4 bg-amber-50 rounded-lg border border-amber-200 text-sm text-stone-700 flex items-center justify-between">
                    <span>Sign in to comment</span>
                    <a href="{{ route('login') }}" class="font-bold text-amber-800 hover:underline">
                        Sign In &rarr;
                    </a>
                </div>
            @endauth

            <div class="space-y-4">
                @forelse ($post->comments as $comment)
                    <div class="p-4 bg-stone-50 border border-stone-200 rounded-xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-stone-900 text-sm">
                                👤 {{ $comment->user?->name ?? 'Resident' }}
                            </span>
                            <span class="text-stone-500 text-xs">
                                {{ $comment->created_at ? $comment->created_at->diffForHumans() : '' }}
                            </span>
                        </div>
                        <p class="text-stone-800 text-sm leading-relaxed">
                            {{ $comment->body }}
                        </p>
                    </div>
                @empty
                    <p class="text-stone-500 text-sm italic">No comments yet. Be the first to comment!</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
