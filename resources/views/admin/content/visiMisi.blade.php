@extends('layouts.admin')
@section('title', "Visi & Misi")
    
@section('content')
<form class="p-10 flex flex-col gap-10" method="POST" action="{{ route('admin.copywriting.update') }}">
    @csrf
    <input type="hidden" name="to_update[]" value="visi">
    <input type="hidden" name="to_update[]" value="misi">
    <input type="hidden" name="r" value="{{ Route::current()->uri }}">

    <div class="flex gap-10">
        <div class="flex flex-col grow gap-2 bg-white rounded-lg shadow-lg p-10">
            <h3 class="text-2xl text-slate-700 font-medium">Visi</h3>
            <textarea name="visi_content" class="outline-0 border rounded-lg p-6 text-sm text-slate-700 mt-2" rows="10">{{ $visi->content }}</textarea>
        </div>
        <div class="flex flex-col grow gap-2 bg-white rounded-lg shadow-lg p-10">
            <h3 class="text-2xl text-slate-700 font-medium">Misi</h3>
            <textarea name="misi_content" class="outline-0 border rounded-lg p-6 text-sm text-slate-700 mt-2" rows="10">{{ $misi->content }}</textarea>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-10 flex justify-end">
        <button class="bg-green-500 text-white text-sm font-medium p-3 px-6">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection