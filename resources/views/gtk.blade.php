@extends('layouts.page')

@section('title', "Guru & Tenaga Kependidikan")
    
@section('content')
<div class="p-10 mt-20">
    <div class="flex items-center gap-4 grow">
        <div class="flex flex-col gap-4 grow">
            <h1 class="text-3xl text-slate-700 font-bold">Guru & Tenaga Kependidikan</h1>
            <div class="w-24 h-2 bg-primary mt-2"></div>
        </div>
        <form class="border rounded-full p-2 w-4/12 flex items-center gap-2">
            <input type="text" name="q" class="h-12 outline-0 px-4 w-full text-sm text-slate-700" placeholder="Cari guru atau tenaga kependidikan" value="{{ $request->q }}">
            @if ($request->q != "")
                <a href="{{ route('page.gtk') }}" class="text-red-500 text-lg">
                    <ion-icon name="close-outline"></ion-icon>
                </a>
            @endif
            <button class="h-12 aspect-square bg-primary text-white rounded-full">
                <ion-icon name="search-outline"></ion-icon>
            </button>
        </form>
    </div>

    <div class="mt-8 flex flex-wrap gap-8">
        @foreach ($gurus as $guru)
            <div class="w-64 max-w-72 aspect-square relative flex flex-col grow">
                <img src="{{ asset('storage/foto_gtk/' . $guru->photo) }}" alt="{{ $guru->name }}" class="w-full">
                <div class="absolute top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 hover:bg-opacity-0 flex flex-col gap-1 justify-end text-white p-4">
                    <h4 class="text-lg font-medium">{{ $guru->name }}</h4>
                    <div class="text-xs">{{ $guru->gtk }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $gurus->links() }}
    </div>
</div>
@endsection