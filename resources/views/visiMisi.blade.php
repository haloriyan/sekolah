@extends('layouts.page')

@section('title', "Visi & Misi")
    
@section('content')
<div class="p-10 flex gap-10 mt-20">
    <div class="flex flex-col grow basis-72 gap-4">
        <h2 class="text-2xl text-slate-700 font-bold">Visi</h2>
        <div class="w-24 h-1 bg-primary mt-2 mb-6"></div>
        <div class="text-sm text-slate-700">{{ copywriting('visi')->content }}</div>
    </div>
    <div class="flex flex-col grow basis-72 gap-4">
        <h2 class="text-2xl text-slate-700 font-bold">Misi</h2>
        <div class="w-24 h-1 bg-primary mt-2 mb-6"></div>
        <div class="text-sm text-slate-700">{{ copywriting('misi')->content }}</div>
    </div>
</div>
@endsection