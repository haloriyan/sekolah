@extends('layouts.install')

@section('title', "MULAI")
    
@section('content')
<h1 class="text-5xl text-slate-700 font-medium">MULAI</h1>
<div class="text-slate-600 leading-7">Terima kasih telah menggunakan website CMS sekolah dari TakoTekno. Sebelum memulai proses pemasangan, pastikan materi-materi yang dibutuhkan dan tertera pada daftar berikut ini telah siap diunggah.</div>

<div class="flex flex-col grow gap-4">
    <div class="flex items-center gap-4 text-slate-600 mt-8">
        <ion-icon name="checkbox-outline" class="text-2xl w-12"></ion-icon>
        <div>
            <span class="font-bold">Identitas Sekolah</span> meliputi Nama Sekolah, No. Telepon, Email, Alamat Lengkap, dan Logo Sekolah berbentuk persegi ( 1 : 1 ) dengan format PNG
        </div>
    </div>
    <div class="flex items-center gap-4 text-slate-600 mt-2">
        <ion-icon name="checkbox-outline" class="text-2xl w-12"></ion-icon>
        <div>
            <span class="font-bold">Kredensial Login Situs</span> berupa Username dan Password administrator untuk mengelola konten CMS
        </div>
    </div>
    <div class="flex items-center gap-4 text-slate-600 mt-2">
        <ion-icon name="checkbox-outline" class="text-2xl w-12"></ion-icon>
        <div>
            Demo Dummy Data agar pengisian data lebih mudah karena terdapat acuan isian (opsional)
        </div>
    </div>
</div>

<div class="flex gap-8">
    <div class="flex grow"></div>
    <a href="{{ route('install', 'credential') }}" class="flex items-center gap-4">
        <div class="text-lg text-slate-600">LANJUTKAN</div>
        <ion-icon name="arrow-forward-outline" class="text-3xl"></ion-icon>
    </a>
</div>
@endsection