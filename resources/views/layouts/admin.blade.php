<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    {{-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {!! json_encode(config('tailwind')) !!}
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        div, aside, header { transition: 0.4s; }
        body {
            font-family: "Poppins", sans-serif;
            font-style: normal;
            font-weight: 400;
        }
    </style>
    @yield('head')
</head>
<body class="bg-slate-100">

<div class="fixed top-0 left-0 right-0 z-20 flex items-center">
    <a href="{{ route('index') }}" class="w-72 h-20 flex gap-4 items-center justify-center bg-white" id="LeftHeader">
        {{-- <img src="#" alt="Logo Heaedr" class="h-12 w-12 bg-slate-200 rounded-lg"> --}}
        {!! logo() !!}
        <h1 class="text-slate-700 font-bold text-sm">{{ env('APP_NAME') }}</h1>
    </a>
    <div class="bg-white h-20 flex items-center gap-4 grow px-10 border-b" id="header">
        <div class="h-12 aspect-square flex items-center justify-start cursor-pointer" onclick="toggleSidebar()">
            <ion-icon name="grid-outline"></ion-icon>
        </div>
        <div class="flex flex-col grow">
            <div class="text-xl font-bold text-slate-700">@yield('title')</div>
            @yield('subtitle')
        </div>
        @yield('header.right')
    </div>
</div>

<div class="fixed top-20 left-0 bottom-0 w-72 z-10 bg-white shadow p-4" id="sidebar">
    @php
        $routeName = Route::currentRouteName();
        $routes = explode(".", $routeName);
    @endphp
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 {{ $routeName == 'admin.dashboard' ? 'bg-primary-transparent text-primary' : 'text-slate-500' }}">
        <div class="h-12 w-1 {{ $routeName == 'admin.dashboard' ? 'bg-primary' : 'bg-white' }}"></div>
        <ion-icon name="home-outline"></ion-icon>
        <div class="text-sm flex">Dashboard</div>
    </a>

    <div class="group relative">
        <a href="#" class="flex items-center gap-4 text-slate-500 {{ @$routes[1] == 'master' ? 'bg-primary-transparent text-primary' : '' }}">
            <div class="h-12 w-1 {{ @$routes[1] == 'master' ? 'bg-primary' : 'bg-white' }}"></div>
            <ion-icon name="cube-outline" class="{{ @$routes[1] == 'master' ? 'text-primary' : '' }}"></ion-icon>
            <div class="text-sm flex grow {{ @$routes[1] == 'master' ? 'text-primary' : '' }}">Master Data</div>
            <ion-icon name="chevron-down-outline" class="me-4"></ion-icon>
        </a>
        <div class="{{ @$routes[1] == 'master' ? 'flex' : 'hidden' }} group-hover:flex flex-col pb-6">
            <a href="{{ route('admin.master.guru') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="people-outline" class="{{ @$routes[2] == 'guru' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'guru' ? 'text-primary' : '' }}">Guru & GTK</div>
            </a>
            <a href="{{ route('admin.master.alumni') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="people-outline" class="{{ @$routes[2] == 'alumni' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'alumni' ? 'text-primary' : '' }}">Alumni</div>
            </a>
            <a href="{{ route('admin.master.galeri') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="images-outline" class="{{ @$routes[2] == 'galeri' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'galeri' ? 'text-primary' : '' }}">Galeri</div>
            </a>
            <a href="{{ route('admin.master.ekskul') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="list-outline" class="{{ @$routes[2] == 'ekskul' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'ekskul' ? 'text-primary' : '' }}">Ekstrakurikuler</div>
            </a>
            <a href="{{ route('admin.master.jurusan') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="list-outline" class="{{ @$routes[2] == 'jurusan' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'jurusan' ? 'text-primary' : '' }}">Jurusan</div>
            </a>
            <a href="{{ route('admin.master.sarpras') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="list-outline" class="{{ @$routes[2] == 'sarpras' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'sarpras' ? 'text-primary' : '' }}">Sarana & Prasarana</div>
            </a>
            <a href="{{ route('admin.master.unduhan') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="file-tray-full-outline" class="{{ @$routes[2] == 'unduhan' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'unduhan' ? 'text-primary' : '' }}">Berkas / Unduhan</div>
            </a>
            <a href="{{ route('admin.master.admin') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="people-outline" class="{{ @$routes[2] == 'admin' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'admin' ? 'text-primary' : '' }}">User Admin</div>
            </a>
        </div>
    </div>

    <div class="group relative">
        <a href="#" class="flex items-center gap-4 text-slate-500 {{ @$routes[1] == 'content' ? 'bg-primary-transparent text-primary' : '' }}">
            <div class="h-12 w-1 {{ @$routes[1] == 'content' ? 'bg-primary' : 'bg-white' }}"></div>
            <ion-icon name="create-outline" class="{{ @$routes[1] == 'content' ? 'text-primary' : '' }}"></ion-icon>
            <div class="text-sm flex grow {{ @$routes[1] == 'content' ? 'text-primary' : '' }}">Konten</div>
            <ion-icon name="chevron-down-outline" class="me-4"></ion-icon>
        </a>
        <div class="{{ @$routes[1] == 'content' ? 'flex' : 'hidden' }} group-hover:flex flex-col mt-2 mb-2">
            <a href="{{ route('admin.content.news') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="list-outline" class="{{ @$routes[2] == 'news' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'news' ? 'text-primary' : '' }}">Berita</div>
            </a>
            <a href="{{ route('admin.content.sejarah') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="time-outline" class="{{ @$routes[2] == 'sejarah' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'sejarah' ? 'text-primary' : '' }}">Sejarah Singkat</div>
            </a>
            <a href="{{ route('admin.content.sambutanKepsek') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="person-outline" class="{{ @$routes[2] == 'sambutanKepsek' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'sambutanKepsek' ? 'text-primary' : '' }}">Sambutan Kepala Sekolah</div>
            </a>
            <a href="{{ route('admin.content.visiMisi') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="list-outline" class="{{ @$routes[2] == 'visiMisi' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'visiMisi' ? 'text-primary' : '' }}">Visi & Misi</div>
            </a>
        </div>
    </div>

    <div class="group relative">
        <a href="#" class="flex items-center gap-4 text-slate-500 {{ @$routes[1] == 'settings' ? 'bg-primary-transparent text-primary' : '' }}">
            <div class="h-12 w-1 {{ @$routes[1] == 'settings' ? 'bg-primary' : 'bg-white' }}"></div>
            <ion-icon name="cog-outline" class="{{ @$routes[1] == 'settings' ? 'text-primary' : '' }}"></ion-icon>
            <div class="text-sm flex grow {{ @$routes[1] == 'settings' ? 'text-primary' : '' }}">Pengaturan</div>
            <ion-icon name="chevron-down-outline" class="me-4"></ion-icon>
        </a>
        <div class="{{ @$routes[1] == 'settings' ? 'flex' : 'hidden' }} group-hover:flex flex-col pb-6">
            <a href="{{ route('admin.settings.basic') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="cube-outline" class="{{ @$routes[2] == 'basic' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'basic' ? 'text-primary' : '' }}">Dasar</div>
            </a>
            <a href="{{ route('admin.settings.backup') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="cloud-done-outline" class="{{ @$routes[2] == 'backup' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'backup' ? 'text-primary' : '' }}">Cadangkan / Pulihkan</div>
            </a>
            <a href="{{ route('admin.settings.slideshow') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="images-outline" class="{{ @$routes[2] == 'slideshow' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'slideshow' ? 'text-primary' : '' }}">Slideshow</div>
            </a>
        </div>
    </div>
</div>

<div class="absolute top-20 left-72 right-0 z-10" id="content">
    @yield('content')
</div>

@yield('ModalArea')

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const select = dom => document.querySelector(dom);
    const header = select("#header");
    const LeftHeader = select("#LeftHeader");
    const sidebar = select("#sidebar");
    const content = select("#content");
    // const ProfileMenu = select("#ProfileMenu");

    // const randomString = (length) => Array.from({ length }, () => Math.random().toString(36)[2]).join('');
    const randomString = (length) => Array.from({ length }, (_, i) => i < length / 2 ? String.fromCharCode(97 + Math.floor(Math.random() * 26)) : Math.floor(Math.random() * 10)).join('');

    const toggleSidebar = () => {
        LeftHeader.classList.toggle('w-0');
        
        if (sidebar.classList.contains('w-72')) {
            // close
            sidebar.classList.add('w-0');
            sidebar.classList.remove('w-72');
            content.classList.add('left-0');
            content.classList.remove('left-72');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 210);
        } else  {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('w-72');
            content.classList.remove('left-0');
            content.classList.add('left-72');
            setTimeout(() => {
                sidebar.classList.remove('w-0');
            }, 10)
        }
    }
    const toggleHidden = target => {
        select(target).classList.toggle('hidden');
    }
    const Currency = (amount) => {
        let props = {};
        props.encode = (prefix = 'Rp') => {                                                               
            let result = '';                                                                              
            let amountRev = amount.toString().split('').reverse().join('');
            for (let i = 0; i < amountRev.length; i++) {
                if (i % 3 === 0) {
                    result += amountRev.substr(i,3)+'.';
                }
            }
            return prefix + ' ' + result.split('',result.length-1).reverse().join('');
        }
        props.decode = () => {
            return parseInt(amount.replace(/,.*|[^0-9]/g, ''), 10);
        }

        return props;
    }
    const onChangeImage = (input, target) => {
        let file = input.files[0];
        let reader = new FileReader();
        let imagePreview = select(target);
        
        reader.onload = function () {
            let source = reader.result;
            imagePreview.style.backgroundImage = `url(${source})`;
            imagePreview.style.backgroundSize = "cover";
            imagePreview.style.backgroundPosition = "center center";
            
            Array.from(imagePreview.childNodes.values()).map(ch => {
                if (ch.tagName !== "INPUT") {
                    ch.remove();
                }
            })
        }

        reader.readAsDataURL(file);
    }
</script>
@yield('javascript')

</body>
</html>