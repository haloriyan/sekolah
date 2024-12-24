<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') {{ env('APP_NAME') }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {!! json_encode(config('tailwind')) !!}
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        div { transition: 0.4s; }
        body {
            font-family: "Poppins", sans-serif;
            font-style: normal;
            font-weight: 400;
        }
    </style>
    @yield('head')
</head>
<body>

@php
    $routeName = Route::currentRouteName();
    $isWhiteHero = in_array($routeName, ['index', 'contact', 'page.news', 'page.news.read', 'page.jurusan', 'page.ekskul', 'page.visiMisi', 'page.sambutanKepsek', 'page.galeri', 'page.alumni', 'page.gtk', 'page.sejarah', 'page.unduhan', 'page.sarpras']);

    $menus = [
        [
            'label' => "Home",
            'link' => "home",
        ]
    ];
@endphp
    
<div class="fixed top-0 left-0 right-0 h-20 flex items-center justify-center gap-4 px-12 mobile:px-10 z-40 {{ $isWhiteHero ? 'bg-white' : '' }}" id="header">
    <a href="{{ route('index') }}" class="flex grow w-4/12 items-center gap-4">
        {!! logo(46, 'xl', 'header-logo') !!}
        <div class="text-slate-700 font-medium">{{ env('APP_NAME') }}</div>
    </a>
    
    {{-- MOBILE MENU --}}
    <div class="desktop:hidden text-xl" onclick="toggleMenu()">
        <ion-icon name="grid-outline"></ion-icon>
    </div>
    <div class="fixed top-16 left-0 right-0 bottom-0 p-10 bg-white hidden opacity-0 duration-300 flex flex-col" id="header-menu-mobile">
        <div class="flex flex-col grow">
            <a href="{{ route('index') }}" class="py-4 text-2xl text-slate-500 flex items-center gap-4">
                <div class="flex grow">Home</div>
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </a>
            <div class="relative group">
                <a href="#" class="py-4 text-2xl text-slate-500 flex items-center gap-4">
                    <div class="flex grow">Profil</div>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </a>

                <div class="hidden group-hover:flex flex-col gap-4 mt-2 mb-8">
                    <a href="{{ route('page.sambutanKepsek') }}" class="text-sm text-slate-500 flex items-center gap-4">
                        <ion-icon name="laptop-outline" class="text-2xl"></ion-icon>
                        <div class="flex grow">Sambutan Kepala Sekolah</div>
                        <ion-icon name="arrow-forward-outline"></ion-icon>
                    </a>
                </div>
            </div>
            {{-- <a href="{{ route('about') }}" class="py-4 text-2xl text-slate-500 flex items-center gap-4">
                <div class="flex grow">Tentang</div>
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </a> --}}
        </div>
{{-- 
        <a href="#" class="bg-primary rounded-full w-full mt-10 p-4 text-white">
            Hubungi Kami --}}
        </a>
    </div>

    {{-- DESKTOP MENU --}}
    <div class="flex items-center justify-center gap-8 mobile:hidden {{ $isWhiteHero ? '' : 'opacity-0'}}" id="header-menu">
        <a href="{{ route('index') }}" class="h-12 flex items-center text-sm whitespace-nowrap {{ $routeName == 'index' ? 'border-b border-primary text-primary' : 'text-slate-600'}}">
            Home
        </a>
        <div class="relative group">
            <a href="#" class="h-12 flex items-center text-sm whitespace-nowrap gap-2 {{ in_array($routeName, ['page.sambutanKepsek', 'page.visiMisi', 'page.gtk']) ? 'border-b border-primary text-primary' : 'text-slate-600'}}">
                Profil
                <ion-icon name="chevron-down-outline"></ion-icon>
            </a>
            <div class="absolute hidden group-hover:flex flex-col bg-white shadow-lg rounded-md p-4 top-12 left-0 z-10">
                <a href="{{ route('page.sejarah') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.sejarah' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Sejarah Singkat
                </a>
                <a href="{{ route('page.sambutanKepsek') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.sambutanKepsek' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Sambutan Kepala Sekolah
                </a>
                <a href="{{ route('page.visiMisi') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.visiMisi' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Visi & Misi
                </a>
                <a href="{{ route('page.gtk') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.gtk' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Guru & Tenaga Kependidikan
                </a>
            </div>
        </div>
        <div class="relative group">
            <a href="#" class="h-12 flex items-center text-sm whitespace-nowrap gap-2 {{ $routeName == 'page.jurusan' ? 'border-b border-primary text-primary' : 'text-slate-600'}}">
                Jurusan
                <ion-icon name="chevron-down-outline"></ion-icon>
            </a>
            <div class="absolute hidden group-hover:flex flex-col bg-white shadow-lg rounded-md p-4 top-12 left-0 z-10">
                @foreach ($datas['jurusans'] as $jurusan)
                    <a href="{{ route('page.jurusan', $jurusan->slug) }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm text-slate-600 flex items-center gap-2">
                        {{ $jurusan->title }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="relative group">
            <a href="#" class="h-12 flex items-center text-sm whitespace-nowrap gap-2 {{ $routeName == 'page.ekskul' ? 'border-b border-primary text-primary' : 'text-slate-600'}}">
                Ekstrakurikuler
                <ion-icon name="chevron-down-outline"></ion-icon>
            </a>
            <div class="absolute hidden group-hover:flex flex-col bg-white shadow-lg rounded-md p-4 top-12 left-0 z-10">
                @foreach ($datas['ekskuls'] as $ekskul)
                    <a href="{{ route('page.ekskul',$ekskul->slug) }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm text-slate-600 flex items-center gap-2">
                        {{$ekskul->title }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="relative group">
            <a href="#" class="h-12 flex items-center text-sm whitespace-nowrap gap-2 {{ in_array('service', explode('.', $routeName)) ? 'border-b border-primary text-primary' : 'text-slate-600'}}">
                Sarana & Prasarana
                <ion-icon name="chevron-down-outline"></ion-icon>
            </a>
            <div class="absolute hidden group-hover:flex flex-col bg-white shadow-lg rounded-md p-4 top-12 left-0 z-10">
                @foreach ($datas['sarprases'] as $item)
                    <a href="{{ route('page.sarpras', $item->slug) }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm text-slate-600 flex items-center gap-2">
                        {{ $item->title }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="relative group">
            <a href="#" class="h-12 flex items-center text-sm whitespace-nowrap gap-2 {{ in_array($routeName, ['page.news', 'page.galeri', 'page.unduhan', 'page.alumni']) ? 'border-b border-primary text-primary' : 'text-slate-600'}}">
                Informasi
                <ion-icon name="chevron-down-outline"></ion-icon>
            </a>
            <div class="absolute hidden group-hover:flex flex-col bg-white shadow-lg rounded-md p-4 top-12 left-0 z-10">
                <a href="{{ route('page.news') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.news' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Berita
                </a>
                <a href="{{ route('page.galeri') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.galeri' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Galeri
                </a>
                <a href="{{ route('page.alumni') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.alumni' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Alumni
                </a>
                <a href="{{ route('page.unduhan') }}" class="py-2 px-4 hover:bg-gray-100 rounded-md whitespace-nowrap text-sm {{ $routeName == 'page.unduhan' ? 'text-primary' : 'text-slate-600' }} flex items-center gap-2">
                    Unduhan
                </a>
            </div>
        </div>
    </div>
    <div class="flex grow w-4/12 mobile:w-full justify-end mobile:hidden">
        <a href="#" id="cta" class="bg-primary rounded-full p-4 mobile:p-2 px-8 mobile:px-4 text-white text-sm mobile:text-xs font-medium cursor-pointer">Hubungi Kami</a>
    </div>
</div>

<div class="absolute top-0 left-0 right-0 z-10">
    @yield('content')

    <footer class="p-20 mobile:p-10 border-t mt-8 flex mobile:flex-col gap-8 mobile:gap-4">
        <div class="flex flex-col gap-2 w-5/12 mobile:w-full">
            <a href="{{ route('index') }}">
                {!! logo() !!}
            </a>
            <div class="text-slate-400 mt-4">{{ env('APP_NAME') }}</div>
            <div class="text-slate-400 text-sm">{{ env('SCHOOL_ADDRESS') }}</div>
        </div>
        <div class="flex flex-col grow gap-2 mobile:w-full">
            <div class="text-slate-700 text-xl font-bold mb-4">Profil</div>
            <li class="list-none"><a href="{{ route('page.sejarah') }}" class="text-slate-500">Sejarah Singkat</a></li>
            <li class="list-none"><a href="{{ route('page.sambutanKepsek') }}" class="text-slate-500">Sambutan Kepala Sekolah</a></li>
            <li class="list-none"><a href="{{ route('page.visiMisi') }}" class="text-slate-500">Visi & Misi</a></li>
            <li class="list-none"><a href="{{ route('page.gtk') }}" class="text-slate-500">Guru & Tenaga Kependidikan</a></li>
        </div>
        <div class="flex flex-col grow gap-2 mobile:w-full">
            <div class="text-slate-700 text-xl font-bold mb-4">Informasi</div>
            <li class="list-none"><a href="{{ route('page.news') }}" class="text-slate-500">Berita</a></li>
            <li class="list-none"><a href="{{ route('page.galeri') }}" class="text-slate-500">Galeri</a></li>
            <li class="list-none"><a href="{{ route('page.alumni') }}" class="text-slate-500">Alumni</a></li>
            <li class="list-none"><a href="{{ route('page.unduhan') }}" class="text-slate-500">Unduhan</a></li>
        </div>
        <div class="flex flex-col grow gap-2 mobile:w-full">
            <div class="text-slate-700 text-xl opacity-0 font-bold">Kontak</div>
            <a href="mailto:{{ env('SCHOOL_EMAIL') }}" class="flex items-center gap-4">
                <div class="text-primary text-4xl">
                    <ion-icon name="mail-outline"></ion-icon>
                </div>
                <div class="flex flex-col grow">
                    <div class="text-slate-700 font-bold">Email</div>
                    <div class="text-slate-500 text-sm">{{ env('SCHOOL_EMAIL') }}</div>
                </div>
            </diav>
            <a href="tel:{{ env('SCHOOL_PHONE') }}" target="_blank" class="flex items-center gap-4 mt-4">
                <div class="text-primary text-4xl">
                    <ion-icon name="logo-whatsapp"></ion-icon>
                </div>
                <div class="flex flex-col grow">
                    <div class="text-slate-700 font-bold">Telepon</div>
                    <div class="text-slate-500 text-sm">{{ env('SCHOOL_PHONE') }}</div>
                </div>
            </a>
        </div>
    </footer>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const select = dom => document.querySelector(dom);
    const selectAll = dom => document.querySelectorAll(dom);
    const header = document.querySelector("#header");
    const headerLogo = document.querySelector("#header-logo");
    const headerMenu = document.querySelector("#header-menu");
    const headerMenuMobile = document.querySelector("#header-menu-mobile");
    const heightToScreen = document.querySelectorAll(".heightToScreen");
    const logo = "{{ asset('images/' . env('APP_LOGO')) }}";
    const logoWhite = "{{ asset('images/' . env('APP_LOGO')) }}";
    const isWhiteHero = JSON.parse("{{ json_encode($isWhiteHero) }}");

    function isDOM(obj) {
        return obj instanceof Element || obj instanceof HTMLDocument;
    }

    window.addEventListener("scroll", e => {
        let pos = window.scrollY;

        if (pos > 60) {
            header.classList.add('bg-white', 'shadow-lg');
            if (!isWhiteHero) {
                headerLogo.setAttribute('src', logo);
                headerMenu.style.opacity = "1";
            }
        } else {
            header.classList.remove('bg-white', 'shadow-lg');
            if (!isWhiteHero) {
                headerLogo.setAttribute('src', logoWhite);
                headerMenu.style.opacity = "0.01";
            }
        }
    });

    heightToScreen.forEach(item => {
        item.style.height = `${window.innerHeight}px`;
    })

    const toggleFaq = item => {
        document.querySelectorAll('.faq-answer').forEach(item => item.classList.add('hidden'));
        let childs = item.childNodes;
        childs.forEach(item => {
            if (isDOM(item) && item.classList.contains('faq-answer')) {
                item.classList.toggle('hidden');
            }
        })
    }
    const toggleMenu = () => {
        if (headerMenuMobile.classList.contains('hidden')) {
            headerMenuMobile.classList.toggle('hidden');
            setTimeout(() => {
                headerMenuMobile.classList.toggle('opacity-0');
            }, 100);
        } else {
            headerMenuMobile.classList.toggle('opacity-0');
            setTimeout(() => {
                headerMenuMobile.classList.toggle('hidden');
            }, 400);
        }
    }
    const toggleHidden = target => {
        select(target).classList.toggle('hidden');
    }
</script>
@yield('javascript')

</body>
</html>