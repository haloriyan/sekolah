@extends('layouts.admin')

@section('title', "Pengaturan Dasar")
    
@section('content')
<div class="p-10">
    <form action="{{ route('admin.settings.basic.save') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-10">
        @csrf
        <div class="flex gap-10">
            <div class="flex flex-col gap-2 relative">
                <div class="text-xs text-slate-500">Logo</div>
                {!! logo(172, '[92px]', 'logoPreview') !!}
                <input type="file" id="logo" name="logo" class="absolute top-0 left-0 right-0 bottom-0 cursor-pointer opacity-0" onchange="onChangeImage(this, '#logoPreview')">
            </div>
            <div class="flex flex-col grow gap-2">
                <div class="text-xs text-slate-500">Nama Sekolah</div>
                <input type="text" name="APP_NAME" class="w-full h-12 border px-4 text-sm text-slate-700 outline-0" value="{{ env('APP_NAME') }}" required>
                <div class="text-xs text-slate-500 mt-4">No. Telepon</div>
                <input type="text" name="SCHOOL_PHONE" class="w-full h-12 border px-4 text-sm text-slate-700 outline-0" value="{{ env('SCHOOL_PHONE') }}" required>
                <div class="text-xs text-slate-500 mt-4">Email</div>
                <input type="text" name="SCHOOL_EMAIL" class="w-full h-12 border px-4 text-sm text-slate-700 outline-0" value="{{ env('SCHOOL_EMAIL') }}" required>
                <div class="text-xs text-slate-500 mt-4">Alamat</div>
                <textarea name="SCHOOL_ADDRESS" class="border p-4 text-sm text-slate-700 outline-0" required rows="8">{{ env('SCHOOL_ADDRESS') }}</textarea>

                <div class="flex items-center mt-4">
                    <div class="text-xs text-slate-500 flex grow">Warna Utama</div>
                    <input type="color" name="BASE_COLOR_INPUT" value="#{{ env('WARNA_UTAMA') }}" onchange="changeColor(this)">
                    <input type="hidden" name="WARNA_UTAMA" id="BaseColor" value="{{ env('WARNA_UTAMA') }}">
                </div>
            </div>
        </div>
        <div class="mt-8 flex justify-end">
            <button class="bg-green-500 text-white text-sm font-medium p-3 px-6">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    const changeColor = input => {
        select("#BaseColor").value = input.value.split('#')[1];
    }
</script>
@endsection