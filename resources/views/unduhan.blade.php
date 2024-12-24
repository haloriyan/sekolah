@extends('layouts.page')

@section('title', "Unduhan")
    
@section('content')
<div class="w-full flex gap-20 mobile:gap-10 mobile:flex-col-reverse mt-20 p-20">
    <div class="flex flex-col gap-4 basis-72 grow">
        <div class="flex items-center gap-4">
            <div class="flex flex-col gap-4 grow">
                <h1 class="text-4xl text-slate-700 font-bold">Unduhan</h1>
                <div class="w-24 h-2 bg-primary mt-2 mb-4"></div>
            </div>
            <form class="w-7/12">
                <div class="border p-2 px-6 flex items-center gap-4">
                    <input type="text" name="q" value="{{ $request->q }}" class="w-full text-sm text-slate-700 h-10 outline-0" placeholder="Cari berkas">
                    @if ($request->q != "")
                        <a href="{{ route('page.unduhan') }}" class="text-xl text-red-500">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    @else
                        <button>
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-8 mt-10">
            @foreach ($files as $item)
                <div class="flex items-center gap-8">
                    <div class="flex flex-col gap-1 basis-80 grow">
                        <h4 class="text-slate-700 font-medium">{{ $item->title }}</h4>
                        <div class="text-sm text-slate-500">{{ Substring($item->description, 150) }}</div>
                    </div>
                    <form action="{{ route('unduhan.download') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <button class="p-2 px-4 text-sm bg-slate-100 text-slate-700 border" type="button" onclick="detail('{{ $item }}')">
                            <ion-icon name="eye-outline"></ion-icon>
                        </button>
                        <button class="p-2 px-4 text-sm text-white bg-green-500">
                            <ion-icon name="download-outline"></ion-icon>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $files->links() }}</div>
    </div>
    @include('components.right')
</div>

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="detail">
    <form class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-2 mt-4" method="POST" action="{{ route('unduhan.download') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow" id="title"></h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#detail')"></ion-icon>
        </div>

        <div class="text-sm text-slate-600 leading-7 mt-6" id="description"></div>

        <div class="flex gap-8 mt-8">
            <div class="flex flex-col grow gap-1">
                <div class="text-xs text-slate-500">Mime Type</div>
                <div class="text-slate-700 font-medium" id="mimeType"></div>
            </div>
            <div class="flex flex-col grow gap-1">
                <div class="text-xs text-slate-500">Ukuran</div>
                <div class="text-slate-700 font-medium" id="size"></div>
            </div>
        </div>

        <div class="pt-6 mt-6 border-t flex items-center justify-end gap-4">
            <button class="bg-gray-100 text-xs text-slate-600 font-medium p-3 px-6" type="button" onclick="toggleHidden('#detail')">Tutup</button>
            <button class="bg-green-500 text-xs text-white font-medium p-3 px-6">Unduh</button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    const detail = data => {
        data = JSON.parse(data);
        toggleHidden('#detail');
        select('#detail #id').value = data.id;
        select('#detail #title').innerHTML = data.title;
        select('#detail #description').innerHTML = data.description;
        select('#detail #mimeType').innerHTML = data.mimeType;
        select('#detail #size').innerHTML = `${((data.size / 1000) / 1000).toFixed(2)} MB`;
    }
</script>
@endsection