@extends('layouts.app')

@section('title', $author->name . ' - Barangay Bulletin Profile')

@section('content')
<div class="relative board-frame rounded-2xl p-4 sm:p-10 my-3 max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center text-sm sm:text-base font-bold text-stone-900 bg-[#fdfaf5] hover:bg-white px-5 py-2.5 rounded-lg shadow-md border-2 border-stone-400 transition">
            📌 &larr; Back to Bulletin Board
        </a>
    </div>

    <!-- Author Profile Card -->
    <div class="bg-[#fefdfa] border-2 border-stone-300 rounded-2xl p-6 sm:p-8 shadow-xl mb-8 relative">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b-2 border-stone-200">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-stone-950">
                    ✍️ {{ $author->name }}
                </h1>
                <p class="text-amber-800 font-bold text-base mt-1">
                    Position: <span class="text-stone-800">{{ $author->position }}</span>
                </p>
                <p class="text-stone-500 text-xs mt-0.5">
                    Email: {{ $author->email }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="bg-amber-100 border border-amber-300 text-amber-950 px-4 py-2 rounded-xl text-center shadow-xs">
                    <span class="block text-2xl font-black">{{ $commentsReceivedCount }}</span>
                    <span class="text-xs font-bold uppercase tracking-wider">comments received</span>
                </div>
                <div class="bg-stone-100 border border-stone-300 text-stone-800 px-4 py-2 rounded-xl text-center shadow-xs">
                    <span class="block text-2xl font-black">{{ $author->posts->count() }}</span>
                    <span class="text-xs font-bold uppercase tracking-wider">notices posted</span>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-black text-stone-900 mb-4">
                Published Notices by {{ $author->name }}
            </h2>

            <div class="space-y-4">
                @forelse ($author->posts as $post)
                    <article class="p-5 bg-stone-50 hover:bg-white border-2 border-stone-200 hover:border-amber-400 rounded-xl transition shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded border text-xs font-bold bg-amber-100 text-amber-950 border-amber-300">
                                    {{ $post->category }}
                                </span>
                                @if ($post->is_pinned)
                                    <span class="bg-red-700 text-white font-black px-1.5 py-0.5 rounded text-[10px] tracking-wide">
                                        📌 PINNED
                                    </span>
                                @endif
                            </div>
                            <span class="text-xs text-stone-500 font-semibold">
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}
                            </span>
                        </div>

                        <h3 class="text-lg font-black text-stone-900 mb-1 hover:text-amber-800">
                            <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <p class="text-stone-700 text-sm line-clamp-2 mb-3">
                            {{ $post->body }}
                        </p>

                        <div class="flex items-center justify-between text-xs text-stone-600 pt-2 border-t border-stone-200">
                            <div class="flex flex-wrap gap-1">
                                @foreach ($post->tags as $tag)
                                    <span class="bg-stone-200 text-stone-800 px-2 py-0.5 rounded text-[10px] font-semibold">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="flex items-center gap-3">
                                <span>💬 {{ $post->comments_count }} comments</span>
                                <span>👀 {{ $post->views }} views</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-stone-500 text-sm italic">No published notices found for this author.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

