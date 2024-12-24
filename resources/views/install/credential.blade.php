@extends('layouts.install')

@section('title', "Kredensial Login Situs")
    
@section('content')
<h1 class="text-5xl text-slate-700 font-medium">KREDENSIAL LOGIN SITUS</h1>
<div class="text-slate-600 leading-7">Buat Username dan Password untuk administrator yang dapat mengelola seluruh konten dalam website CMS sekolah ini.</div>

<form class="flex flex-col grow gap-4" action="{{ route('install.run', 'credential') }}">
    @csrf
</form>

<div class="flex gap-8">
    <div class="flex grow"></div>
    <a href="{{ route('install', 'credential') }}" class="flex items-center gap-4">
        <div class="text-lg text-slate-600">LANJUTKAN</div>
        <ion-icon name="arrow-forward-outline" class="text-3xl"></ion-icon>
    </a>
</div>
@endsection