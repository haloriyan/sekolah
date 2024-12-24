@extends('layouts.admin')

@section('title', "Detail Galeri")
    
@section('content')
<div class="p-10 flex flex-col gap-10">
    <div class="bg-white rounded-lg shadow-lg p-10 flex items-center gap-4">
        <div class="flex flex-col gap-2 grow">
            <div class="text-slate-700 font-medium text-xl">{{ $gallery->title }}</div>
            <div class="text-slate-500 font-medium text-sm">{!! $gallery->description ? $gallery->description : '<i>Deskripsi</i>' !!}</div>
        </div>
        <button class="bg-green-500 text-white font-medium p-3 px-4 flex items-center gap-2">
            <ion-icon name="create-outline"></ion-icon>
            <div class="text-xs">Edit</div>
        </button>
        <button class="bg-red-500 text-white font-medium p-3 px-4 flex items-center gap-2" onclick="del('{{ $gallery }}')">
            <ion-icon name="trash-outline"></ion-icon>
            <div class="text-xs">Hapus</div>
        </button>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-10">
        <div class="flex flex-wrap gap-4">
            @foreach ($images as $img)
                <div class="relative group">
                    <img 
                        src="{{ asset('storage/gallery/' . $gallery->id . '/' . $img->filename) }}" 
                        alt="{{ $img->filename }}"
                        class="h-32 aspect-square rounded-lg object-cover"
                    >
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 flex gap-2">
                        <a href="{{ route('admin.master.galeri.deleteImage', [$gallery->id, $img->id]) }}">
                            <div class="h-8 aspect-square rounded bg-red-500 text-white text-sm cursor-pointer flex items-center justify-center">
                                <ion-icon name="trash-outline"></ion-icon>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            <form id="formUpload" action="{{ route('admin.master.galeri.storeImage') }}" class="h-32 aspect-square rounded-lg flex items-center justify-center border relative" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="gallery_id" id="id" value="{{ $gallery->id }}">
                <input type="file" name="media" class="cursor-pointer absolute top-0 left-0 right-0 bottom-0 opacity-0" onchange="inputFile(this)">
                <ion-icon name="duplicate-outline" class="text-2xl"></ion-icon>
            </form>
        </div>
    </div>
</div>
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="delete">
    <form class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.galeri.delete') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Hapus Album</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#delete')"></ion-icon>
        </div>

        <div class="text-slate-700">Yakin ingin menghapus album <span id="title"></span>?</div>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#delete')">Batal</button>
            <button class="bg-red-500 text-xs text-white font-medium p-3 px-6">Hapus</button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    const inputFile = input => {
        let form = select("#formUpload");
        form.submit();
        form.innerHTML = "<div class='text-slate-500 text-sm'>Uploading...</div>";
    }
    const del = data => {
        data = JSON.parse(data);
        toggleHidden('#delete');
        select("#delete #id").value = data.id;
        select("#delete #title").innerHTML = data.title;
    }
</script>
@endsection