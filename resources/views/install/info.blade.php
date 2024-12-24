@extends('layouts.install')

@section('title', "Informasi Dasar")
    
@section('content')

<form action="{{ route('install.run', 'info') }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center grow gap-20">
    @csrf
    <div class="flex flex-col gap-4 w-4/12">
        <h1 class="text-5xl text-slate-700 font-medium">IDENTITAS SEKOLAH</h1>
        <div class="text-slate-600 leading-7 mt-4">Informasi dasar sekolah yang akan ditampilkan pada pengunjung website.</div>
        <div class="flex">
            <div class="h-36 border bg-slate-200 rounded-lg flex flex-col items-center justify-center gap-4 aspect-square relative mt-8" id="LogoArea">
                <ion-icon name="add-circle-outline" class="text-3xl"></ion-icon>
                <div class="text-xs text-slate-700">Logo Sekolah</div>
                <input type="file" name="logo" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#LogoArea')" required>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-2 grow">
        <div class="text-xs text-slate-500 mt-4">Nama Sekolah</div>
        <input type="text" name="APP_NAME" class="w-full h-14 border outline-0 text-sm text-slate-700 px-4" required>
        <div class="text-xs text-slate-500 mt-2">No. Telepon</div>
        <input type="text" name="SCHOOL_PHONE" class="w-full h-14 border outline-0 text-sm text-slate-700 px-4" required>
        <div class="text-xs text-slate-500 mt-2">E-Mail</div>
        <input type="text" name="SCHOOL_EMAIL" class="w-full h-14 border outline-0 text-sm text-slate-700 px-4" required>
        <div class="text-xs text-slate-500 mt-2">Alamat Lengkap</div>
        <textarea name="SCHOOL_ADDRESS" rows="6" class="w-full border outline-0 text-sm text-slate-700 p-4" required></textarea>

        <div class="flex items-center gap-4 mt-8">
            <a href="{{ route('install', 'credential') }}" class="flex items-center gap-4">
                <ion-icon name="arrow-back-outline"></ion-icon>
                <div class="text-sm text-slate-600">KEMBALI</div>
            </a>
            <div class="flex grow"></div>
            <button class="flex items-center gap-4">
                <div class="text-lg text-slate-600">LANJUTKAN</div>
                <ion-icon name="arrow-forward-outline" class="text-3xl"></ion-icon>
            </button>
        </div>
    </div>
</form>
@endsection