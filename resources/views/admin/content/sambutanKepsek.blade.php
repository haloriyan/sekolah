@extends('layouts.admin')
@section('title', "Sambutan Kepala Sekolah")
    
@section('content')
<div class="p-10">
    <div class="bg-white rounded-lg shadow-lg p-10">
        <form class="flex flex-col gap-10" method="POST" action="{{ route('admin.copywriting.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="to_update[]" value="sambutan_kepala_sekolah">
            <input type="hidden" name="r" value="{{ Route::current()->uri }}">

            <div class="flex items-center gap-4">
                <div class="flex flex-col grow gap-2">
                    <div class="font-medium text-slate-700">Foto Kepala Sekolah</div>
                    <div class="text-xs text-slate-500">Pilih foto Kepala Sekolah untuk ditampilkan</div>
                </div>
                <div class="flex items-end flex-col gap-4">
                    <div class="w-32 aspect-square rounded-lg border relative group flex flex-col items-center justify-center bg-cover bg-center" id="prevImage" style="{{ $sambutan->image == null ? '' : 'background-image: url(/storage/copywriting_images/' . $sambutan->image . ')'}}">
                        @if ($sambutan->image == null)
                            <ion-icon name="cloud-upload-outline" class="text-xl"></ion-icon>
                        @endif
                        <input 
                            type="file" 
                            name="sambutan_kepala_sekolah_image" 
                            class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer"
                            onchange="onChangeImage(this, '#prevImage')"
                        >
                    </div>
                    @if ($sambutan->image != null)
                        <div class="text-xs text-slate-500">Klik gambar untuk mengganti</div>
                    @endif
                </div>
            </div>
        
            <textarea name="sambutan_kepala_sekolah_content" class="outline-0 border rounded-lg p-6 text-sm text-slate-700 mt-2" rows="10">{{ $sambutan->content }}</textarea>
            <div class="flex justify-end">
                <button class="bg-green-500 text-white text-sm font-medium p-3 px-6">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection