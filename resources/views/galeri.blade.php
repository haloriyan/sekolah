@extends('layouts.page')

@section('title', "Galeri")
    
@section('content')
<div class="p-10 mt-20">
    <div class="flex flex-col gap-4 grow">
        <h1 class="text-3xl text-slate-700 font-bold">Galeri</h1>
        <div class="w-24 h-2 bg-primary mt-2"></div>
    </div>

    <div class="mt-8 flex flex-wrap gap-8">
        @foreach ($galleries as $gallery)
            <a href="{{ route('page.galeri.detail', $gallery->slug) }}" class="w-64 aspect-square relative flex flex-col grow">
                <img src="{{ asset('storage/gallery/' . $gallery->id . '/' . $gallery->images[0]->filename) }}" alt="{{ $gallery->title }}" class="w-full">
                <div class="absolute top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 hover:bg-opacity-0 flex flex-col gap-1 justify-end text-white p-4">
                    <h4 class="text-lg font-medium">{{ $gallery->title }}</h4>
                    <div class="text-xs">{{ $gallery->images->count() }} media</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection