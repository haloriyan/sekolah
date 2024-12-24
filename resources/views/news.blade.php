@extends('layouts.page')

@section('title', "Berita Terbaru")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $beritas = berita(12);
@endphp
    
@section('content')
<div class="p-10 mt-20 flex mobile:flex-col gap-10">
    <div class="flex flex-col gap-4 grow">
        <h1 class="text-3xl text-slate-700 font-bold">Berita Terbaru</h1>
        <div class="w-24 h-2 bg-primary mt-2 mb-4"></div>

        <div class="flex mobile:flex-col flex-wrap gap-6 mt-2">
            @foreach ($beritas as $berita)
                <a href="{{ route('news.read', $berita->slug) }}" class="relative flex flex-col grow basis-72 mobile:hidden mobile:basis-24 max-w-96 bg-primary">
                    <img 
                        src="{{ asset('storage/news_images/' . $berita->featured_image) }}" alt="{{ $berita->title }}"
                        class="w-full aspect-square object-cover"
                    >
                    <div class="absolute top-0 left-0 right-0 bottom-0 flex flex-col gap-2 justify-end text-white bg-black bg-opacity-65 p-8 mobile:p-4">
                        <h4 class="text-sm mobile:text-xs font-medium">{{ $berita->title }}</h4>
                        <div class="text-xs mobile:hidden">{{ Carbon::parse($berita->created_at)->diffForHumans() }}</div>
                    </div>
                </a>
                <a href="{{ route('news.read', $berita->slug) }}" class="desktop:hidden flex items-center gap-4">
                    <img 
                        src="{{ asset('storage/news_images/' . $berita->featured_image) }}" alt="{{ $berita->title }}"
                        class="h-20 rounded-lg aspect-square object-cover"
                    >
                    <div class="flex flex-col grow gap-2">
                        <div class="text-sm text-slate-600 font-medium">{{ Substring($berita->title, 50) }}</div>
                        <div class="text-xs text-slate-500">{{ Carbon::parse($berita->created_at)->diffForHumans() }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @include('components.right', [
        'disabled' => ['berita']
    ])
</div>
@endsection