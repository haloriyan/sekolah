@extends('layouts.page')

@section('title', "Home")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');

    $sambutan = copywriting('sambutan_kepala_sekolah');
    $beritas = berita(8);
@endphp
    
@section('content')
<div class="mt-20">
    @if ($slides->count() > 0)
        @foreach ($slides as $s => $slide)
            <div class="w-full relative slide-item">
                <img 
                    src="{{ asset('storage/slideshow_images/' . $slide->image) }}" 
                    alt="{{ $slide->title}}"
                    class="w-full object-cover mobile:hidden"
                    style="aspect-ratio: 5/2"
                >
                <img 
                    src="{{ asset('storage/slideshow_images/' . $slide->image) }}" 
                    alt="{{ $slide->title}}"
                    class="w-full object-cover desktop:hidden"
                    style="aspect-ratio: 9/16"
                >
                <div class="absolute top-0 left-0 right-0 bottom-0 flex flex-col gap-4 p-10 justify-center bg-black bg-opacity-50 text-white">
                    <h2 class="text-3xl font-bold mobile:leading-10">{{ $slide->title }}</h2>
                    <div class="mt-2 mobile:text-sm mobile:leading-6">{{ $slide->description }}</div>
                </div>
                <div class="absolute bottom-10 left-0 right-0 flex items-center gap-4 justify-center">
                    @for ($i = 0; $i < count($slides); $i++)
                        <div class="h-3 aspect-square rounded-full border border-white cursor-pointer {{ $i == $s ? 'bg-white' : '' }}" onclick="chooseSlide('{{ $i }}')"></div>
                    @endfor
                </div>
            </div>
        @endforeach
    @endif

    <div class="w-full flex gap-20 mobile:gap-10 mobile:flex-col-reverse p-10 py-20">
        <div class="flex flex-col gap-4 basis-72 grow">
            <h1 class="text-3xl text-slate-700 font-bold">Sambutan Kepala Sekolah</h1>
            <div class="w-24 h-1 bg-primary mt-2 mb-4"></div>
            <div class="text-slate-700 text-sm leading-8">
                {{ $sambutan->content }}
            </div>
        </div>

        @if ($sambutan->image != null)
            <img 
                src="{{ asset('storage/copywriting_images/' . $sambutan->image) }}" 
                alt="foto_kepsek"
                class="w-3/12 rounded-lg object-cover aspect-square"
            >
        @endif
    </div>

    <div class="p-10 flex flex-col gap-4">
        <div class="flex items-center gap-4">
            <div class="flex flex-col grow">
                <h1 class="text-3xl text-slate-700 font-bold">Berita Terbaru</h1>
                <div class="w-24 h-2 bg-primary mt-4 mb-8"></div>
            </div>
            <a href="{{ route('page.news') }}" class="text-primary text-sm flex items-center gap-2 opacity-80">
                LAINNYA
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </a>
        </div>

        <div class="flex mobile:flex-col flex-wrap gap-6">
            @foreach ($beritas as $berita)
                <a href="{{ route('news.read', $berita->slug) }}" class="relative flex flex-col grow basis-72 mobile:hidden mobile:basis-24 max-w-96 bg-primary">
                    <img 
                        src="{{ asset('storage/news_images/' . $berita->featured_image) }}" alt="{{ $berita->title }}"
                        class="w-full aspect-square object-cover"
                    >
                    <div class="absolute top-0 left-0 right-0 bottom-0 flex flex-col gap-2 justify-end text-white bg-black bg-opacity-65 p-8 mobile:p-4">
                        <h4 class="text-sm mobile:text-xs font-medium">{{ $berita->title }}</h4>
                        <div class="text-xs mobile:hidden">{{ Carbon::parse($berita->created_at)->diffForHumans() }}</div>
                    </div>
                </a>
                <a href="{{ route('news.read', $berita->slug) }}" class="desktop:hidden flex items-center gap-4">
                    <img 
                        src="{{ asset('storage/news_images/' . $berita->featured_image) }}" alt="{{ $berita->title }}"
                        class="h-20 rounded-lg aspect-square object-cover"
                    >
                    <div class="flex flex-col grow gap-2">
                        <div class="text-sm text-slate-600 font-medium">{{ Substring($berita->title, 50) }}</div>
                        <div class="text-xs text-slate-500">{{ Carbon::parse($berita->created_at)->diffForHumans() }}</div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="flex gap-10 mt-20 mb-20">
            <div class="flex flex-col gap-2 mt-4">
                <h3 class="text-3xl text-slate-700 font-bold">Ekstrakurikuler</h3>
                <div class="w-24 h-2 bg-primary mt-4"></div>
            </div>
            <div class="flex flex-wrap grow justify-end gap-6">
                @foreach ($datas['ekskuls'] as $ekskul)
                    <a href="{{ route('page.ekskul', $ekskul->slug) }}" class="relative basis-80">
                        <img src="{{ asset('storage/foto_ekskul/' . $ekskul->images[0]->filename) }}" alt="{{ $ekskul->title }}" class="h-56 aspect-video object-cover">
                        <div class="absolute top-0 left-0 right-0 bottom-0 flex flex-col gap-2 items-end justify-end p-6 bg-black bg-opacity-65 text-white hover:bg-opacity-25">
                            <h5 class="text-xl font-bold">{{ $ekskul->title }}</h5>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col items-center grow gap-2 mt-12">
            <h3 class="text-3xl text-slate-700 font-bold">Galeri</h3>
            <div class="w-24 h-2 bg-primary mt-4 mb-8"></div>
        </div>
        
        <div class="flex gap-10 items-start">
            @foreach ($galleries as $col => $item)
                <div class="flex flex-col gap-8">
                    @foreach ($item as $image)
                        <div>
                            <img src="{{ asset('storage/gallery/' . $image->gallery_id . '/' . $image->filename) }}" alt="{{ $image->filename}}">
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    let slides = selectAll(".slide-item");
    let index = 0;
    
    const renderSlide = () => {
        slides.forEach(slide => {
            slide.classList.add('hidden');
        });

        slides[index].classList.remove('hidden');
    }
    renderSlide();

    let slideInterval = setInterval(() => {
        if (index < slides.length - 1) {
            index++;
        } else {
            index = 0;
        }
        renderSlide();
    }, 5000);

    const chooseSlide = choosenIndex => {
        clearInterval(slideInterval);
        index = choosenIndex;
        renderSlide();
        slideInterval = setInterval(() => {
            if (index < slides.length - 1) {
                index++;
            } else {
                index = 0;
            }
            renderSlide();
        }, 5000);
    }
</script>
@endsection