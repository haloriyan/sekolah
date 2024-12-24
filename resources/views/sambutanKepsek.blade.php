@extends('layouts.page')

@section('title', "Sambutan Kepala Sekolah")

@php
    $sambutan = copywriting('sambutan_kepala_sekolah');
@endphp
    
@section('content')
<div class="w-full flex gap-20 mobile:gap-10 mobile:flex-col-reverse mt-20 p-20">
    <div class="flex flex-col gap-4 basis-72 grow">
        <h1 class="text-4xl text-slate-700 font-bold">Sambutan Kepala Sekolah</h1>
        <div class="w-24 h-2 bg-primary mt-2 mb-4"></div>
        <div class="text-slate-700 text-sm leading-8">
            {{ $sambutan->content }}
        </div>
    </div>
    @if ($sambutan->image != null)
        <img 
            src="{{ asset('storage/copywriting_images/' . $sambutan->image) }}" 
            alt="foto_kepsek"
            class="w-3/12 rounded-lg object-cover aspect-square"
        >
    @endif
</div>
@endsection