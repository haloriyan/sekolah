@extends('layouts.page')

@section('title', "Sejarah Singkat")

@php
    $sejarah = copywriting('sejarah');
@endphp
    
@section('content')
<div class="w-full flex gap-20 mobile:gap-10 mobile:flex-col-reverse mt-20 p-20">
    <div class="flex flex-col gap-4 basis-72 grow">
        <h1 class="text-4xl text-slate-700 font-bold">Sejarah Singkat</h1>
        <div class="w-24 h-2 bg-primary mt-2 mb-4"></div>
        <div class="text-slate-700 text-sm leading-8">
            {!! $sejarah->content !!}
        </div>
    </div>
    @include('components.right')
</div>
@endsection