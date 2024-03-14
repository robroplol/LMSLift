<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased text-charcoal bg-gradient-to-br from-white from-5% via-primary via-10% to-raisin to-15%">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-deep-teal dark:bg-dots-lighter selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif

            
            <div class="container p-8">
                <div class="flex justify-center items-end p-0 rounded-md mb-8">
                    <img src="{{URL::asset('/img/logos/purple-swoosh.svg')}}" class="w-16 mr-4" alt="">
                    <h1 class="font-logo text-primary text-5xl uppercase">LMS Lift</h1>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-primary text-charcoal  rounded-md p-8">
                        <h2 class="font-heading text-2xl tracking-tighter font-black mb-4">CSV to iMSCC</h2>
                        <p class="text-lg">Easily transform your CSV LTI page data into the widely accepted Common Cartridge format with our seamless upload tool. Designed for simplicity and efficiency, our platform ensures a hassle-free conversion process, setting the standard for educational content interoperability.</p>
                    </div>
                    <div class="bg-primary text-charcoal  rounded-md p-8">
                        <h2 class="font-heading text-2xl tracking-tighter font-black mb-4">HTML to SCORM Package</h2>
                        <p class="text-lg">We're working on a tool that packages HTML, CSS, and JavaScript files into SCORM packages. It's aimed at making the process of creating digital courses simpler and ensuring they work smoothly on different learning management systems.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
