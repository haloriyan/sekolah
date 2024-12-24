@extends('layouts.admin')

@section('title', "Album Galeri")

@section('header.right')
<button class="bg-primary text-white text-xs font-bold h-12 px-6 flex items-center gap-2" onclick="toggleHidden('#create')">
    <ion-icon name="add-outline" class="font-bold text-xl"></ion-icon>
    Buat Album
</button>
@endsection
    
@section('content')
<div class="p-10">
    <div class="bg-white rounded-lg shadow-lg p-10">
        <div class="flex gap-8">
            @foreach ($galleries as $gall)
                <a href="{{ route('admin.master.galeri.detail', $gall->id) }}" class="relative group flex flex-col bg-primary text-white grow aspect-square basis-24 max-w-72 p-8 justify-end rounded-lg">
                    <div class="absolute top-0 left-0 right-0 bottom-0 flex flex-col justify-end p-8 z-20 bg-black bg-opacity-25">
                        <h3 class="text-lg font-medium">{{ $gall->title }}</h3>
                    <div class="text-sm">{{ $gall->description }}</div>
                    </div>
                    @if ($gall->image != null)
                        <img 
                            src="{{ asset('storage/gallery/' . $gall->id . '/' . $gall->image->filename) }}" 
                            alt="{{ $gall->title }}"
                            class="absolute top-0 left-0 right-0 bottom-0 rounded-lg object-cover z-10"
                        >
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="create">
    <form class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.galeri.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="galeri">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Buat Album Baru</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#create')"></ion-icon>
        </div>

        <div class="text-xs text-slate-500 mt-2">Judul Album</div>
        <input type="text" name="title" id="title" class="outline-0 h-12 border text-sm px-4 w-full" required>
        <div class="text-xs text-slate-500 mt-2">Deskripsi</div>
        <textarea name="description" id="description" rows="6" class="outline-0 border text-sm px-4 w-full"></textarea>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#create')">Batal</button>
            <button class="bg-primary text-xs text-white font-medium p-3 px-6">Buat</button>
        </div>
    </form>
</div>
@endsection