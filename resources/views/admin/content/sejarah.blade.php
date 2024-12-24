@extends('layouts.admin')

@section('title', "Sejarah Singkat")

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
<form class="flex flex-col gap-10 p-10" method="POST" action="{{ route('admin.copywriting.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="to_update[]" value="sejarah">
    <input type="hidden" name="r" value="{{ Route::current()->uri }}">
    <div class="bg-white rounded-lg shadow-lg p-10">
        <div class="flex items-center gap-8">
            <h2 class="flex grow text-lg text-slate-700 font-medium">Sejarah Singkat</h2>
            <button class="bg-green-500 text-white text-sm font-medium p-3 px-6">
                Simpan Perubahan
            </button>
        </div>

        <div class="mt-8">
            <div id="editor" class="h-96"></div>
        </div>
        <textarea name="sejarah_content" id="content_body" class="hidden">{{ copywriting('sejarah')->content }}</textarea>
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
            init(newEditor);
        } )
        .catch( e => console.error(e)
         );

    let content = select("#content_body");
    const init = (editor) => {
        console.log(content.value);
        editor.setData(content.value)
        
        setInterval(() => {
            let editorData = editor.getData();
            content.value = editorData;
        }, 300);
    }
</script>
@endsection