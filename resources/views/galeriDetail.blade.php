@extends('layouts.page')

@section('title', $gallery->title)
    
@section('content')
<div class="p-10 mt-20">
    <div class="flex items-center gap-8">
        <a href="{{ route('page.galeri') }}" class="text-slate-700">
            <ion-icon name="arrow-back-outline" class="text-3xl"></ion-icon>
        </a>
        <div class="flex flex-col gap-4 grow">
            <h1 class="text-3xl text-slate-700 font-bold">{{ $gallery->title }}</h1>
            <div class="w-24 h-2 bg-primary mt-2"></div>
        </div>
    </div>

    <div class="mt-8 masonryContainer">
        @foreach ($gallery->images as $image)
            <div class="image-item">
                <img src="{{ asset('storage/gallery/' . $gallery->id . '/' . $image->filename) }}" alt="{{ $gallery->title }}" class="p-4 ">
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/masonryan.min.js') }}"></script>
<script>
    let mas = new Masonryan({
        container: ".masonryContainer",
        items: ".masonryContainer .image-item",
        dividedBy: 4
    });
</script>
@endsection