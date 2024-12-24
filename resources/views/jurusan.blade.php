@extends('layouts.page')

@section('title', $jurusan->title)
    
@section('content')
<div class="w-full bg-cover bg-center relative mt-20" style="aspect-ratio: 5/2;background-image: url(/storage/foto_jurusan/{{ $jurusan->images[0]->filename }})">
    <div class="absolute z-20 top-0 left-0 right-0 bottom-0 p-10 flex gap-10 bg-black bg-opacity-75">
        <div class="flex flex-col gap-4 justify-center text-white">
            <div class="text-sm">Jurusan</div>
            <h1 class="text-3xl font-bold">{{ $jurusan->title }}</h1>
        </div>
    </div>
</div>

<div class="p-10 flex gap-10">
    <div class="flex flex-col grow text-slate-700 text-sm basis-96 leading-8">
        {!! $jurusan->description !!}
    </div>
    @include('components.right')
</div>

<div class="p-10 flex flex-wrap gap-10 justify-center">
    @foreach ($jurusan->images as $image)
        <div class="relative basis-96 flex flex-col grow">
            <img 
                src="{{ asset('storage/foto_jurusan/' . $image->filename) }}" alt="{{ $image->filename }}"
            >
        </div>
    @endforeach
</div>
@endsection

@section('javascript')
{{--  --}}
@endsection