@extends('layouts.admin')

@section('title', "Slideshow Home")

@section('header.right')
<button class="bg-primary text-white text-xs font-bold h-12 px-6" onclick="toggleHidden('#create')">
    Slide Baru
</button>
@endsection
    
@section('content')
<div class="p-10">
    <div class="bg-white rounded-lg shadow-lg p-10">
        <div class="min-w-full overflow-hidden overflow-x-auto p-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="text-sm text-slate-700 bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left"></th>
                        <th scope="col" class="px-6 py-3 text-left">
                            <ion-icon name="image-outline"></ion-icon>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left">Konten</th>
                        <th scope="col" class="px-6 py-3 text-left">Link Aksi</th>
                        <th scope="col" class="px-6 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($slides as $s => $slide)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm text-slate-700">
                                @if ($s != 0)
                                    <a href="{{ route('admin.settings.slideshow.priority', [$slide->id, 'increase']) }}" class="text-primary">
                                        <ion-icon name="arrow-up-outline"></ion-icon>
                                    </a>
                                @endif
                                @if ($s != count($slides) - 1)
                                    <a href="{{ route('admin.settings.slideshow.priority', [$slide->id, 'decrease']) }}" class="text-primary">
                                        <ion-icon name="arrow-down-outline"></ion-icon>
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                <img src="{{ asset('storage/slideshow_images/' . $slide->image) }}" alt="{{ $slide->title }}" class="h-12 rounded object-cover" style="aspect-ratio: 5/2">
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $slide->title }}
                                <div class="text-xs text-slate-500 mt-1">{{ $slide->description }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                <a href="{{ $slide->link_one }}" class="text-primary underline">
                                    {{ $slide->link_one }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 flex gap-2">
                                <button class="bg-green-500 text-white p-1 px-4 font-medium text-lg" onclick="edit('{{ $slide }}')">
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <button class="bg-red-500 text-white p-1 px-4 font-medium text-lg" onclick="del('{{ $slide }}')">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="create">
    <form class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.settings.slideshow.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Slide Baru</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#create')"></ion-icon>
        </div>

        <div class="w-full rounded-xl border bg-slate-100 flex flex-col items-center justify-center relative text-slate-700 gap-4" style="aspect-ratio: 5/2" id="previewCreate">
            <ion-icon name="cloud-upload-outline" class="text-3xl"></ion-icon>
            <div class="text-sm text-slate-500">Pilih / Letakkan Gambar</div>
            <input type="file" name="image" class="absolute top-0 left-0 right-0 bottom-0 cursor-pointer opacity-0" onchange="onChangeImage(this, '#previewCreate')" required>
        </div>

        <div class="text-xs text-slate-500 mt-2">Judul</div>
        <input type="text" name="title" id="title" class="w-full h-12 text-sm text-slate-700 outline-0 border px-4" required>
        <div class="text-xs text-slate-500 mt-2">Deskripsi</div>
        <textarea name="description" id="description" class="w-full text-sm text-slate-700 outline-0 border p-4" rows="5" required></textarea>
        <div class="text-xs text-slate-500 mt-2">Link Aksi</div>
        <input type="text" name="link_one" id="link_one" class="w-full h-12 text-sm text-slate-700 outline-0 border px-4">

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#create')">Batal</button>
            <button class="bg-primary text-xs text-white font-medium p-3 px-6">Tambahkan</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="edit">
    <form class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.settings.slideshow.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Edit Slide</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#edit')"></ion-icon>
        </div>

        <div class="w-full rounded-xl border bg-slate-100 flex flex-col items-center justify-center relative text-slate-700 gap-4 bg-center bg-cover" style="aspect-ratio: 5/2" id="previewEdit">
            <input type="file" name="image" class="absolute top-0 left-0 right-0 bottom-0 cursor-pointer opacity-0" onchange="onChangeImage(this, '#previewEdit')">
        </div>
        <div class="text-xs text-slate-500 mb-2">Klik gambar untuk mengganti</div>

        <div class="text-xs text-slate-500 mt-2">Judul</div>
        <input type="text" name="title" id="title" class="w-full h-12 text-sm text-slate-700 outline-0 border px-4" required>
        <div class="text-xs text-slate-500 mt-2">Deskripsi</div>
        <textarea name="description" id="description" class="w-full text-sm text-slate-700 outline-0 border p-4" rows="5" required></textarea>
        <div class="text-xs text-slate-500 mt-2">Link Aksi</div>
        <input type="text" name="link_one" id="link_one" class="w-full h-12 text-sm text-slate-700 outline-0 border px-4">

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#edit')">Batal</button>
            <button class="bg-green-500 text-xs text-white font-medium p-3 px-6">Simpan Perubahan</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="delete">
    <form class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.settings.slideshow.delete') }}" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Hapus Slide</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#delete')"></ion-icon>
        </div>

        <div class="text-slate-600 text-sm">Yakin ingin menghapus slide ini?</div>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#delete')">Batal</button>
            <button class="bg-red-500 text-xs text-white font-medium p-3 px-6">Hapus</button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    const del = data => {
        data = JSON.parse(data);
        toggleHidden('#delete');
        select("#delete #id").value = data.id;
        select("#delete #name").innerHTML = data.name;
    }
    const edit = data => {
        data = JSON.parse(data);
        toggleHidden('#edit');
        select("#edit #id").value = data.id;
        select("#edit #title").value = data.title;
        select("#edit #description").value = data.description;
        select("#edit #link_one").value = data.link_one;

        let imagePreview = select("#previewEdit");
        imagePreview.style.backgroundImage = `url(/storage/slideshow_images/${data.image})`;
    }
</script>
@endsection