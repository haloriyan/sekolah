<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
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
<body>

<div class="fixed top-0 left-0 right-0 bottom-0 p-20 mobile:p-10 bg-white bg-opacity-80 flex flex-col gap-4">
    @yield('content')
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const select = dom => document.querySelector(dom);
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