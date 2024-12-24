@extends('layouts.install')

@section('title', "MULAI")
    
@section('content')

<div class="flex flex-col justify-center grow gap-4">
    <h1 class="text-5xl text-slate-700 font-medium">PEMASANGAN SELESAI</h1>
    <div class="text-slate-600 leading-7 mt-4">Pemasangan berhasil dijalankan dengan baik. Silahkan login ke dashboard administrator</div>
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 mt-12">
        <div class="text-lg text-slate-600">MASUK KE DASHBOARD</div>
        <ion-icon name="arrow-forward-outline" class="text-3xl"></ion-icon>
    </a>
</div>
@endsection