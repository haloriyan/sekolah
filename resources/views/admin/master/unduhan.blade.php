@extends('layouts.admin')

@section('title', "Berkas / Unduhan")

@section('header.right')
<div class="flex items-center desktop:w-5/12 gap-4">
    <form class="flex items-center border pe-4 grow">
        <input type="text" name="q" class="w-full flex grow h-12 outline-0 px-4 text-xs text-slate-600" placeholder="Cari nama berkas" value="{{ $request->q }}">
        @if ($request->q == "")
            <ion-icon name="search-outline"></ion-icon>
        @else
            <a href="{{ route('admin.master.unduhan') }}">
                <ion-icon name="close-outline" class="text-red-500"></ion-icon>
            </a>
        @endif
    </form>
    <button class="bg-primary text-white text-xs font-bold h-12 px-6" onclick="toggleHidden('#create')">
        Tambah Data
    </button>
</div>
@endsection

@section('content')
<div class="p-10">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="min-w-full overflow-hidden overflow-x-auto p-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="text-sm text-slate-700 bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">Nama Berkas</th>
                        <th scope="col" class="px-6 py-3 text-left"><ion-icon name="eye-outline"></ion-icon></th>
                        <th scope="col" class="px-6 py-3 text-left"><ion-icon name="download-outline"></ion-icon></th>
                        <th scope="col" class="px-6 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($files as $item)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $item->title }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $item->view_count }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $item->download_count }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700 flex gap-2">
                                <button class="bg-green-500 text-white p-1 px-4 font-medium text-lg" onclick="edit('{{ $item }}')">
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <button class="bg-red-500 text-white p-1 px-4 font-medium text-lg" onclick="del('{{ $item }}')">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $files->links() }}
        </div>
    </div>
</div>
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="create">
    <form class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.unduhan.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Tambah Berkas</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#create')"></ion-icon>
        </div>

        <div class="text-xs text-slate-500 mt-6">Nama Berkas</div>
        <input type="text" name="title" id="title" class="w-full h-14 text-sm text-slate-700 px-4 outline-0 border" required>

        <div class="text-xs text-slate-500 mt-2">Deskripsi</div>
        <textarea name="description" id="description" rows="5" class="w-full text-sm text-slate-700 p-4 outline-0 border" required></textarea>

        <div class="border rounded-lg p-4 flex items-center gap-4 mt-4">
            <div class="text-xs text-slate-500 flex grow">Pilih Berkas</div>
            <input type="file" name="berkas" class="text-xs" required>
        </div>

        <div class="flex items-center justify-end gap-4 mt-6">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#create')">Batal</button>
            <button class="bg-primary text-xs text-white font-medium p-3 px-6">Upload</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="edit">
    <form class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.unduhan.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Edit Berkas</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#edit')"></ion-icon>
        </div>

        <div class="text-xs text-slate-500 mt-6">Nama Berkas</div>
        <input type="text" name="title" id="title" class="w-full h-14 text-sm text-slate-700 px-4 outline-0 border" required>

        <div class="text-xs text-slate-500 mt-2">Deskripsi</div>
        <textarea name="description" id="description" rows="5" class="w-full text-sm text-slate-700 p-4 outline-0 border" required></textarea>

        <div class="border rounded-lg p-4 flex items-center gap-4 mt-4">
            <div class="text-xs text-slate-500 flex grow">Ganti Berkas</div>
            <input type="file" name="berkas" class="text-xs">
        </div>

        <div class="text-xs text-slate-500">Biarkan kosong jika tidak ingin mengganti berkas</div>

        <div class="flex items-center justify-end gap-4 mt-6">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#edit')">Batal</button>
            <button class="bg-green-500 text-xs text-white font-medium p-3 px-6">Simpan Perubahan</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="delete">
    <form class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.unduhan.delete') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Hapus Berkas</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#delete')"></ion-icon>
        </div>

        <div class="text-sm text-slate-700 mt-4">Yakin ingin menghapus <span id="title"></span>?</div>

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
        select("#delete #title").innerHTML = data.title;
    }
    const edit = data => {
        data = JSON.parse(data);
        let imagePreview = select("#imagePreviewEdit");
        
        toggleHidden('#edit');
        select("#edit #id").value = data.id;
        select("#edit #title").value = data.title;
        select("#edit #description").value = data.description;
    }
</script>
@endsection