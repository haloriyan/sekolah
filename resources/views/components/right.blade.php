@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<div class="flex flex-col gap-8 min-w-1/12 max-w-96">
    @php
        $sambutanKepsek = copywriting('sambutan_kepala_sekolah');
        $beritas = berita(5);
    @endphp
    <div class="flex flex-col gap-2">
        <h4 class="text-lg text-slate-700 font-medium">Sambutan Kepala Sekolah</h4>
        <div class="w-24 h-1 mb-4 mt-2 bg-primary"></div>
        @if ($sambutanKepsek->image != null)
            <div class="flex mb-4">
                <img 
                    src="{{ asset('storage/copywriting_images/' . $sambutanKepsek->image) }}" 
                    alt="foto_kepsek"
                    class="h-24 rounded-lg object-cover aspect-square"
                >
            </div>
        @endif
        <div class="text-xs text-slate-600 whitespace-normal leading-7">{{ $sambutanKepsek->content }}</div>
    </div>
    @if (!@$disabled || (isset($disabled) && !in_array('berita', @$disabled)))
        <div class="flex flex-col gap-2">
            <h4 class="text-lg text-slate-700 font-medium">Berita</h4>
            <div class="w-12 h-1 mb-4 mt-2 bg-primary"></div>
            <div class="flex flex-col gap-6">
                @foreach ($beritas as $berita)
                    <a href="{{ route('news.read', $berita->slug) }}" class="flex items-start gap-4">
                        <img 
                            src="{{ asset('storage/news_images/' . $berita->featured_image) }}" 
                            alt="{{ $berita->title }}"
                            class="h-16 aspect-square rounded-lg object-cover"
                        >
                        <div class="flex flex-col gap-2 grow">
                            <h5 class="text-slate-600 text-sm font-medium">{{ $berita->title }}</h5>
                            <div class="text-slate-500 text-xs">{{ Carbon::parse($berita->created_at)->diffForHumans() }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>