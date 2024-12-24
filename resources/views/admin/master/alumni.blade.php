@extends('layouts.admin')

@section('title', "Data Alumni")

@section('header.right')
<div class="flex items-center desktop:w-5/12 gap-4">
    <form class="flex items-center border pe-4 grow">
        <input type="text" name="q" class="w-full flex grow h-12 outline-0 px-4 text-xs text-slate-600" placeholder="Cari nama alumni" value="{{ $request->q }}">
        @if ($request->q == "")
            <ion-icon name="search-outline"></ion-icon>
        @else
            <a href="{{ route('admin.master.alumni') }}">
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
                        <th scope="col" class="px-6 py-3 text-left">Periode</th>
                        <th scope="col" class="px-6 py-3 text-left">Pekerjaan</th>
                        <th scope="col" class="px-6 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($alumnis as $alumni)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm text-slate-700">
                                @if ($alumni->photo != null)
                                    <img src="{{ asset('storage/foto_alumni/' . $alumni->photo) }}" alt="{{ $alumni->name }}" class="h-12 rounded aspect-square object-cover">
                                @else
                                    <div class="h-12 rounded aspect-square bg-gray-100"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $alumni->name }}
                                <div class="text-xs text-slate-500 mt-1">{{ $alumni->contact }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $alumni->angkatan }} - {{ $alumni->tahun_lulus }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $alumni->pekerjaan }}
                                <div class="text-xs text-slate-500 mt-1">{{ $alumni->perusahaan }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 flex gap-2">
                                <button class="bg-green-500 text-white p-1 px-4 font-medium text-lg" onclick="edit('{{ $alumni }}')">
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <button class="bg-red-500 text-white p-1 px-4 font-medium text-lg" onclick="del('{{ $alumni }}')">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $alumnis->links() }}
        </div>
    </div>
</div>
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="create">
    <form class="bg-white shadow-lg rounded-lg p-10 w-9/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.alumni.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Tambah Data Alumni</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#create')"></ion-icon>
        </div>

        <div class="flex mobile:flex-col items-start gap-12 mobile:gap-4">
            <div class="flex justify-center">
                <div class="border rounded-lg h-64 mobile:h-24 aspect-square relative flex flex-col gap-2 items-center justify-center" id="imagePreviewCreate">
                    <ion-icon name="cloud-upload-outline" class="text-4xl text-slate-700"></ion-icon>
                    <div class="text-sm mobile:text-xs text-slate-500">Pilih Foto</div>
                    <input type="file" name="photo" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#imagePreviewCreate')">
                </div>
            </div>
            <div class="flex flex-col gap-2 grow">
                <div class="text-xs text-slate-500">Nama</div>
                <input type="text" name="name" id="name" class="outline-0 h-12 border text-sm px-4 w-full" required>
                <div class="text-xs text-slate-500 mt-2">Kontak</div>
                <input type="text" name="contact" id="contact" class="outline-0 h-12 border text-sm px-4 w-full" placeholder="No. Telepon / Email" required>

                <div class="flex items-start gap-4 mt-2">
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Angkatan</div>
                        <input type="text" name="angkatan" id="angkatan" class="outline-0 h-12 border text-sm px-4 w-full" required>
                    </div>
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Tahun Lulus</div>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="outline-0 h-12 border text-sm px-4 w-full" required>
                    </div>
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Melanjutkan ke</div>
                        <input type="text" name="melanjutkan" id="melanjutkan" class="outline-0 h-12 border text-sm px-4 w-full">
                    </div>
                </div>

                <div class="flex items-start gap-4 mt-2">
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Pekerjaan</div>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="outline-0 h-12 border text-sm px-4 w-full">
                    </div>
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Perusahaan</div>
                        <input type="text" name="perusahaan" id="perusahaan" class="outline-0 h-12 border text-sm px-4 w-full">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#create')">Batal</button>
            <button class="bg-primary text-xs text-white font-medium p-3 px-6">Tambahkan</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="edit">
    <form class="bg-white shadow-lg rounded-lg p-10 w-9/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('admin.master.alumni.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Edit Data Alumni</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#edit')"></ion-icon>
        </div>

        <div class="flex mobile:flex-col items-start gap-12 mobile:gap-4">
            <div class="flex flex-col gap-2 justify-center">
                <div class="border rounded-lg h-64 mobile:h-24 aspect-square relative flex flex-col gap-2 items-center justify-center bg-cover bg-center" id="imagePreviewEdit">
                    <input type="file" name="photo" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#imagePreviewEdit')">
                </div>
                <div class="text-xs text-slate-500">Klik foto untuk mengganti</div>
            </div>
            <div class="flex flex-col gap-2 grow">
                <div class="text-xs text-slate-500">Nama</div>
                <input type="text" name="name" id="name" class="outline-0 h-12 border text-sm px-4 w-full" required>
                <div class="text-xs text-slate-500 mt-2">Kontak</div>
                <input type="text" name="contact" id="contact" class="outline-0 h-12 border text-sm px-4 w-full" placeholder="No. Telepon / Email" required>

                <div class="flex items-start gap-4 mt-2">
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Angkatan</div>
                        <input type="text" name="angkatan" id="angkatan" class="outline-0 h-12 border text-sm px-4 w-full" required>
                    </div>
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Tahun Lulus</div>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="outline-0 h-12 border text-sm px-4 w-full" required>
                    </div>
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Melanjutkan ke</div>
                        <input type="text" name="melanjutkan" id="melanjutkan" class="outline-0 h-12 border text-sm px-4 w-full">
                    </div>
                </div>

                <div class="flex items-start gap-4 mt-2">
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Pekerjaan</div>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="outline-0 h-12 border text-sm px-4 w-full">
                    </div>
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-xs text-slate-500">Perusahaan</div>
                        <input type="text" name="perusahaan" id="perusahaan" class="outline-0 h-12 border text-sm px-4 w-full">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#create')">Batal</button>
            <button class="bg-green-500 text-xs text-white font-medium p-3 px-6">Simpan Perubahan</button>
        </div>
    </form>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="delete">
    <form class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-2 mt-4" action="{{ route('admin.master.alumni.delete') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Hapus Data Alumni</h3>
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
        toggleHidden('#edit');
        select("#edit #id").value = data.id;
        select("#edit #name").value = data.name;
        select("#edit #contact").value = data.contact;
        select("#edit #angkatan").value = data.angkatan;
        select("#edit #tahun_lulus").value = data.tahun_lulus;
        select("#edit #pekerjaan").value = data.pekerjaan;
        select("#edit #perusahaan").value = data.perusahaan;

        let imagePreview = select("#imagePreviewEdit");
        imagePreview.style.backgroundImage = `url(/storage/foto_alumni/${data.photo})`;
    }
</script>
@endsection