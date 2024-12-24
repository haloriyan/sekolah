@extends('layouts.admin')

@section('title', "Dashboard")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
    
@section('content')
<div class="p-10 flex flex-col gap-10">
    <div class="flex gap-8">
        <div class="flex flex-col basis-48 grow rounded-lg bg-red-500 text-white">
            <div class="flex items-center gap-4 p-6 py-8">
                <ion-icon name="people-outline" class="text-4xl"></ion-icon>
                <div class="flex grow text-2xl font-bold justify-end">{{ $guru_count }}</div>
            </div>
            <a href="{{ route('admin.master.guru') }}" class="bg-red-700 p-6 py-4 flex gap-4 rounded-b-lg">
                <div class="text-xs flex grow font-medium">Guru</div>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </div>
        <div class="flex flex-col basis-48 grow rounded-lg bg-blue-500 text-white">
            <div class="flex items-center gap-4 p-6 py-8">
                <ion-icon name="people-outline" class="text-4xl"></ion-icon>
                <div class="flex grow text-2xl font-bold justify-end">{{ $jurusan_count }}</div>
            </div>
            <a href="{{ route('admin.master.jurusan') }}" class="bg-blue-700 p-6 py-4 flex gap-4 rounded-b-lg">
                <div class="text-xs flex grow font-medium">Jurusan</div>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </div>
        <div class="flex flex-col basis-48 grow rounded-lg bg-green-500 text-white">
            <div class="flex items-center gap-4 p-6 py-8">
                <ion-icon name="people-outline" class="text-4xl"></ion-icon>
                <div class="flex grow text-2xl font-bold justify-end">{{ $ekskul_count }}</div>
            </div>
            <a href="{{ route('admin.master.ekskul') }}" class="bg-green-700 p-6 py-4 flex gap-4 rounded-b-lg">
                <div class="text-xs flex grow font-medium">Ekstrakurikuler</div>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </div>
        <div class="flex flex-col basis-48 grow rounded-lg bg-red-500 text-white">
            <div class="flex items-center gap-4 p-6 py-8">
                <ion-icon name="file-tray-full-outline" class="text-4xl"></ion-icon>
                <div class="flex grow text-2xl font-bold justify-end">{{ $berkas_count }}</div>
            </div>
            <a href="{{ route('admin.master.guru') }}" class="bg-red-700 p-6 py-4 flex gap-4 rounded-b-lg">
                <div class="text-xs flex grow font-medium">Berkas</div>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div class="flex items-start gap-8">
        <div class="flex flex-col basis-96 grow bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center gap-4">
                <h3 class="flex grow">Galeri</h3>
                <a href="{{ route('admin.master.galeri') }}">
                    <ion-icon name="arrow-forward-outline"></ion-icon>
                </a>
            </div>
            <div class="flex gap-4 items-start mt-4">
                @foreach ($images as $col => $item)
                    <div class="flex flex-col gap-4">
                        @foreach ($item as $image)
                            <div>
                                <img src="{{ asset('storage/gallery/' . $image->gallery_id . '/' . $image->filename) }}" alt="{{ $image->filename}}">
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col w-5/12 bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center gap-4">
                <h3 class="flex grow">Berita Terbaru</h3>
                <a href="{{ route('admin.content.news') }}">
                    <ion-icon name="arrow-forward-outline"></ion-icon>
                </a>
            </div>
            <div class="flex flex-col gap-4 mt-6">
                @foreach ($beritas as $berita)
                    <a href="{{ route('news.read', $berita->slug) }}" class="flex items-center gap-4">
                        <img src="{{ asset('storage/news_images/' . $berita->featured_image) }}" alt="{{ $berita->title }}" class="h-16 aspect-square rounded-lg object-cover">
                        <div class="flex grow text-xs text-slate-700">{{ $berita->title }}</div>
                        <div class="text-xs text-slate-500 flex basis-20 gap-2 justify-end">
                            <ion-icon name="eye-outline"></ion-icon>
                            {{ $berita->hit }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection