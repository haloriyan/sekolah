@extends('layouts.admin')

@section('title', "Edit Sarana & Prasarana")

@section('head')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
        }
    }
</script>
@endsection
    
@section('content')
<form class="flex gap-8 p-10" method="POST" enctype="multipart/form-data" action="{{ route('admin.master.sarpras.update', $sarpras->id) }}">
    @csrf
    <div class="flex flex-col w-7/12 gap-4 bg-white rounded-lg shadow-lg p-10 pb-10">
        <input type="hidden" name="imgToDelete" id="imgToDelete">
        <div class="text-xs text-slate-500">Judul</div>
        <input type="text" name="title" class="w-full h-14 border px-6 outline-0" value="{{ $sarpras->title }}" required>

        <div>
            <div id="editor" class="h-96">{!! $sarpras->description !!}</div>
        </div>
        <textarea name="content" id="content_body" class="hidden">{{ $sarpras->description }}</textarea>
    </div>
    <div class="flex flex-col gap-8 basis-72 grow">
        <div class="bg-white shadow-lg rounded-lg flex items-center justify-end gap-4 p-10">
            <button class="bg-primary text-white font-medium p-3 px-6 text-sm">
                Terbitkan
            </button>
        </div>
        <div class="bg-white shadow-lg rounded-lg flex flex-col gap-4 p-10">
            <div class="text-sm text-slate-500">Gambar</div>
            <div class="flex gap-4 flex-wrap" id="renderImages">
                @foreach ($sarpras->images as $img)
                    {{-- 
                    item.classList.add('w-24', 'aspect-square', 'rounded-lg', 'relative', 'group');
                    item.innerHTML = `<img src='${source}' class='absolute z-10 top-0 left-0 right-0 bottom-0 object-cover rounded-lg w-full'>
                    <div class='absolute z-20 top-2 right-2'>
                        <div class='bg-red-500 h-6 aspect-square rounded text-white text-xs cursor-pointer opacity-25 flex items-center justify-center group-hover:opacity-100' onclick='removeImg(this)'><ion-icon name='close-outline'></ion-icon></div>
                    </div>`;
                     --}}
                    <div class="w-24 aspect-square rounded-lg relative group flex items-center justify-center">
                        <img 
                            src="{{ asset('storage/foto_sarpras/' . $img->filename) }}" 
                            alt="{{ $img->filename}}"
                            class="absolute z-10 top-0 left-0 right-0 bottom-0 object-cover rounded-lg w-full"
                        >
                        <div class='absolute z-20 top-2 right-2'>
                            <div class='bg-red-500 h-6 aspect-square rounded text-white text-xs cursor-pointer opacity-25 flex items-center justify-center group-hover:opacity-100' onclick="removeImg(this, '{{ $img->id }}')"><ion-icon name='close-outline'></ion-icon></div>
                        </div>
                    </div>
                @endforeach
                <div class="w-24 border aspect-square rounded-lg relative flex items-center justify-center">
                    <ion-icon name="add-outline" class="text-xl text-slate-700"></ion-icon>
                    <input type="file" name="images[]" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onSelectImage(this)">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('javascript')
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } from 'ckeditor5';

    let editor;

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        } )
        .then( (newEditor) => {
            editor = newEditor;
        } )
        .catch( /* ... */ );

    let content = select("#content_body");
    setInterval(() => {
        let editorData = editor.getData();
        content.value = editorData;
    }, 300);
</script>
<script>
    const inputImage = select("#image");
    const imagePreview = select("#imagePreview");
    let inputCollections = [];

    const clickOnImage = () => {
        inputImage.click();
    }
    const onSelectImage = input => {
        let file = input.files[0];
        let reader = new FileReader();

        reader.onload = function () {
            let source = reader.result;
            let item = document.createElement('div');
            let parentInput = input.parentNode;
            item.classList.add('w-24', 'aspect-square', 'rounded-lg', 'relative', 'group');
            item.innerHTML = `<img src='${source}' class='absolute z-10 top-0 left-0 right-0 bottom-0 object-cover rounded-lg w-full'>
            <div class='absolute z-20 top-2 right-2'>
                <div class='bg-red-500 h-6 aspect-square rounded text-white text-xs cursor-pointer opacity-25 flex items-center justify-center group-hover:opacity-100' onclick='removeImg(this)'><ion-icon name='close-outline'></ion-icon></div>
            </div>`;

            input.classList.add('hidden');
            let newInput = document.createElement('input');
            newInput.setAttribute('type', 'file');
            newInput.setAttribute('name', 'images[]');
            newInput.setAttribute('onchange', 'onSelectImage(this)');
            newInput.classList.add('absolute', 'top-0', 'left-0', 'right-0', 'bottom-0', 'opacity-0', 'cursor-pointer');

            parentInput.appendChild(newInput);

            select("#renderImages").insertBefore(item, select("#renderImages").firstChild);
        }

        reader.readAsDataURL(file);
    }

    let imagesToDelete = [];
    const removeImg = (that, imgID = null) => {
        that.parentNode.parentNode.remove();
        if (imgID !== null) {
            imagesToDelete.push(imgID);
            select("#imgToDelete").value = imagesToDelete.join('||');
        }
    }

  </script>
@endsection