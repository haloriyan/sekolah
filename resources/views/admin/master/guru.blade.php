@extends('layouts.admin')

@section('title', "Data Guru dan Tenaga Kependidikan")
    
@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('header.right')
<div class="flex items-center desktop:w-5/12 gap-4">
    <form class="flex items-center border pe-4 grow">
        <input type="text" name="q" class="w-full flex grow h-12 outline-0 px-4 text-xs text-slate-600" placeholder="Cari nama GTK" value="{{ $request->q }}">
        @if ($request->q == "")
            <ion-icon name="search-outline"></ion-icon>
        @else
            <a href="{{ route('admin.master.guru') }}">
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
    <div class="bg-white rounded-lg shadow-lg p-10">
        <div class="min-w-full overflow-hidden overflow-x-auto p-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="text-sm text-slate-700 bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">
                            <ion-icon name="image-outline"></ion-icon>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left">Jenis Kelamin</th>
                        <th scope="col" class="px-6 py-3 text-left">Jenis GTK</th>
                        <th scope="col" class="px-6 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($gurus as $guru)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm text-slate-700">
                                @if ($guru->photo != null)
                                    <img src="{{ asset('storage/foto_gtk/' . $guru->photo) }}" alt="{{ $guru->name }}" class="h-12 rounded aspect-square object-cover">
                                @else
                                    <div class="h-12 rounded aspect-square bg-gray-100"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $guru->name }}
                                <div class="text-xs text-slate-500 mt-1">{{ $guru->nip }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $guru->gender }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $guru->gtk }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700 flex gap-2">
                                <button class="bg-green-500 text-white p-1 px-4 font-medium text-lg" onclick="edit('{{ $guru }}')">
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <button class="bg-red-500 text-white p-1 px-4 font-medium text-lg" onclick="del('{{ $guru }}')">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $gurus->links() }}
        </div>
    </div>
</div>
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="create">
    <form class="bg-white shadow-lg rounded-lg p-10 w-6/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.guru.store') }}" enctype="multipart/form-data">
    @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Tambah Data GTK</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#create')"></ion-icon>
        </div>

        <div class="flex mobile:flex-col items-start gap-12 mobile:gap-4">
            <div class="flex justify-center">
                <div class="border rounded-lg h-48 aspect-square relative flex flex-col gap-2 items-center justify-center" id="imagePreviewCreate">
                    <ion-icon name="cloud-upload-outline" class="text-4xl text-slate-700"></ion-icon>
                    <div class="text-xs text-slate-500">Pilih Foto</div>
                    <input type="file" name="photo" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#imagePreviewCreate')" required>
                </div>
            </div>
            <div class="flex flex-col gap-2 grow">
                <div class="text-xs text-slate-500">Nama</div>
                <input type="text" name="name" id="name" class="outline-0 h-12 border text-sm px-4 w-full" required>
                <div class="text-xs text-slate-500 mt-2">Email</div>
                <input type="email" name="email" id="email" class="outline-0 h-12 border text-sm px-4 w-full" required>

                <div class="flex items-center gap-4 mt-4">
                    <div class="flex grow text-xs text-slate-500">NIP</div>
                    <input type="text" name="nip" id="nip" class="outline-0 h-12 border text-sm px-4 w-8/12" required>
                </div>

                <div class="flex items-center gap-4 mt-4">
                    <div class="flex grow text-xs text-slate-500">Jenis Kelamin</div>
                    <select name="gender" id="gender" class="outline-0 h-12 border text-sm text-slate-700 px-4" required>
                        <option value="">Pilih</option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>

                <div class="text-xs text-slate-500 mt-2">Jenis GTK</div>
                <input type="text" name="gtk" id="gtk" class="outline-0 h-12 border text-sm px-4 w-full" required>
            </div>
        </div>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#create')">Batal</button>
            <button class="bg-primary text-xs text-white font-medium p-3 px-6">Tambahkan</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="edit">
    <form class="bg-white shadow-lg rounded-lg p-10 w-6/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.guru.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">

        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Edit Data GTK</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#edit')"></ion-icon>
        </div>

        <div class="flex mobile:flex-col items-start gap-12 mobile:gap-4">
            <div class="flex flex-col gap-2 justify-center">
                <div class="border rounded-lg h-48 aspect-square relative flex flex-col gap-2 items-center justify-center bg-cover bg-center" id="imagePreviewEdit">
                    <input type="file" name="photo" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#imagePreviewEdit')" required>
                </div>
                <div class="text-xs text-slate-500">Klik foto untuk mengganti</div>
            </div>
            <div class="flex flex-col gap-2 grow">
                <div class="text-xs text-slate-500">Nama</div>
                <input type="text" name="name" id="name" class="outline-0 h-12 border text-sm px-4 w-full" required>
                <div class="text-xs text-slate-500 mt-2">Email</div>
                <input type="email" name="email" id="email" class="outline-0 h-12 border text-sm px-4 w-full" required>

                <div class="flex items-center gap-4 mt-4">
                    <div class="flex grow text-xs text-slate-500">NIP</div>
                    <input type="text" name="nip" id="nip" class="outline-0 h-12 border text-sm px-4 w-8/12" required>
                </div>

                <div class="flex items-center gap-4 mt-4">
                    <div class="flex grow text-xs text-slate-500">Jenis Kelamin</div>
                    <select name="gender" id="gender" class="outline-0 h-12 border text-sm text-slate-700 px-4" required>
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="text-xs text-slate-500 mt-2">Jenis GTK</div>
                <input type="text" name="gtk" id="gtk" class="outline-0 h-12 border text-sm px-4 w-full" required>
            </div>
        </div>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#edit')">Batal</button>
            <button class="bg-green-500 text-xs text-white font-medium p-3 px-6">Simpan Perubahan</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="delete">
    <form class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.guru.delete') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Hapus Data GTK</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#delete')"></ion-icon>
        </div>

        <div class="text-slate-700 text-sm">Yakin ingin menghapus data <span id="name"></span>?</div>

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
        let imagePreview = select("#imagePreviewEdit");
        
        toggleHidden('#edit');
        select("#edit #id").value = data.id;
        select("#edit #name").value = data.name;
        select("#edit #email").value = data.email;
        select("#edit #nip").value = data.nip;
        select("#edit #gtk").value = data.gtk;
        select(`#edit #gender option[value='${data.gender}']`).selected = true;

        imagePreview.style.backgroundImage = `url(/storage/foto_gtk/${data.photo})`;
    }
</script>
@endsection