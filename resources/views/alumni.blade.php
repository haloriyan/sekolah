@extends('layouts.page')

@section('title', "Alumni")
    
@section('content')
<div class="p-10 mt-20">
    <div class="flex items-center gap-4 grow">
        <div class="flex flex-col gap-4 grow">
            <h1 class="text-3xl text-slate-700 font-bold">Alumni</h1>
            <div class="w-24 h-2 bg-primary mt-2"></div>
        </div>
        <form class="border rounded-full p-2 w-4/12 flex items-center gap-2">
            <input type="text" name="q" class="h-12 outline-0 px-4 w-full text-sm text-slate-700" placeholder="Cari alumni" value="{{ $request->q }}">
            @if ($request->q != "")
                <a href="{{ route('page.alumni') }}" class="text-red-500 text-lg">
                    <ion-icon name="close-outline"></ion-icon>
                </a>
            @endif
            <button class="h-12 aspect-square bg-primary text-white rounded-full">
                <ion-icon name="search-outline"></ion-icon>
            </button>
        </form>
    </div>

    <div class="mt-8 flex flex-wrap gap-8">
        @foreach ($alumnis as $alumni)
            <div class="w-64 max-w-80 aspect-square relative flex flex-col grow cursor-pointer" onclick="detail('{{ $alumni }}')">
                <img src="{{ asset('storage/foto_alumni/' . $alumni->photo) }}" alt="{{ $alumni->name }}" class="w-full">
                <div class="absolute top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 hover:bg-opacity-0 flex flex-col gap-1 justify-end text-white p-4">
                    <h4 class="text-lg font-medium">{{ $alumni->name }}</h4>
                    {{-- <div class="text-xs">{{ $alumni->gtk }}</div> --}}
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $alumnis->links() }}
    </div>
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="display">
    <form class="bg-white shadow-lg rounded-lg p-10 w-6/12 mobile:w-10/12 flex flex-col gap-2 mt-4">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Alumni</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#display')"></ion-icon>
        </div>

        <div class="flex mobile:flex-col mt-4 items-start gap-12 mobile:gap-4">
            <img id="foto_alumni" alt="foto" class="h-64 w-64 rounded-lg mobile:h-24 relative flex flex-col gap-2 items-center justify-center object-cover">

            <div class="flex flex-col gap-6 grow">
                <div class="flex gap-4">
                    <div class="flex flex-col grow gap-2 basis-32">
                        <div class="text-xs text-slate-500">Nama</div>
                        <div class="text-sm text-slate-600 font-medium" id="name"></div>
                    </div>
                    <div class="flex flex-col grow gap-2 basis-32">
                        <div class="text-xs text-slate-500">Kontak</div>
                        <div class="text-sm text-slate-600 font-medium" id="contact"></div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex flex-col grow gap-2 basis-32">
                        <div class="text-xs text-slate-500">Aktif</div>
                        <div class="text-sm text-slate-600 font-medium" id="active"></div>
                    </div>
                    <div class="flex flex-col grow gap-2 basis-32">
                        <div class="text-xs text-slate-500">Melanjutkan ke</div>
                        <div class="text-sm text-slate-600 font-medium" id="melanjutkan"></div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex flex-col grow gap-2 basis-32">
                        <div class="text-xs text-slate-500">Pekerjaan</div>
                        <div class="text-sm text-slate-600 font-medium" id="pekerjaan"></div>
                    </div>
                    <div class="flex flex-col grow gap-2 basis-32">
                        <div class="text-xs text-slate-500">Perusahaan</div>
                        <div class="text-sm text-slate-600 font-medium" id="perusahaan"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    const detail = data => {
        data = JSON.parse(data);
        toggleHidden('#display');
        select("#foto_alumni").src = `/storage/foto_alumni/${data.photo}`;
        select("#display #name").innerHTML = data.name;
        select("#display #contact").innerHTML = data.contact;
        select("#display #active").innerHTML = `${data.angkatan} - ${data.tahun_lulus}`;
        select("#display #melanjutkan").innerHTML = data.melanjutkan;
        select("#display #pekerjaan").innerHTML = data.pekerjaan;
        select("#display #perusahaan").innerHTML = data.perusahaan;
    }
</script>
@endsection