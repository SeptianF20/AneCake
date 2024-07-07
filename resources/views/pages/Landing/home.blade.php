<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- style -->
    <link href="{{ mix('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- endstyle -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <title>Anecake | Aneka Kue Basah</title>
</head>

<body class="antialiased bg-base-100 overscroll-none">
    <header class="sticky top-0 z-40">
        @include('pages.landing.navbar')
    </header>
    <main class="main-container bg-base-100">
        <!-- hero section -->
        <section class="bg-base-100" id="#home">
            <div class="absolute inset-x-0 overflow-hidden -top-3 -z-10 transform-gpu px-36 blur-3xl"
                aria-hidden="true">
                <div class="mx-auto aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="hero min-h-screen">
                <div class="hero-content flex-col lg:flex-row-reverse">
                    <img src="https://images.unsplash.com/photo-1567560953114-47d97e5aa422?q=80&w=1526&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="max-w-sm rounded-lg shadow-2xl" />
                    <div>
                        <h1 class="text-6xl font-bold font-serif">Aneka kue basah</h1>
                        <p class="py-6 text-lg">
                            Sedia apapun kebutuhan jajan untuk kamu, keluarga, dan tetangga!
                        </p>
                        <button class="btn btn-primary">Get Started</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- produk -->
        <section class="bg-base-200 p-8" id="#home">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex justify-between">
                        <div class="">
                            <h1 class="text-2xl font-bold mb-2">Produk</h1>
                            <p class="mb-4">Produk ini ada berbagai macam</p>
                        </div>
                        <!-- Slider main container -->
                        <div class="swiper">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper my-2 rounded-3xl shadow-2xl">
                                <!-- Slides -->
                                @foreach ($shuffledThumbnails as $thumbnail)
                                    <div class="swiper-slide">
                                        <img src="{{ $thumbnail }}" alt="Image" class="w-full h-auto">
                                    </div>
                                @endforeach
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                            <!-- If we need scrollbar -->
                            <div class="swiper-scrollbar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mx-auto mt-10">
                <div class="grid grid-cols-1 gap-4">
                    <!-- Product Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($products as $item)
                            <div class="card card-compact bg-base-100 w-full shadow-xl">
                                <figure>
                                    <img src="{{ $item->thumbnail }}" alt="" class="h-50 w-72">
                                </figure>
                                <div class="card-body">
                                    <h2 class="card-title">{{ $item->name }}</h2>
                                    <p> {{ moneyFormat($item->price) }}</p>
                                    <div class="card-actions justify-end">
                                        <a href="{{ route('product.show')}}" class="btn btn-primary">Pesan Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- layanan -->
        <section class="" id="#layanan">

        </section>

        <!-- cara pesan -->
        <section class="bg-base-200 p-8" id="#order">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Side - Image or Icon -->
                    <div class="flex items-center justify-center">
                        <img
                            src="https://plus.unsplash.com/premium_photo-1673108852141-e8c3c22a4a22?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" />
                    </div>

                    <!-- Right Side - Steps Explanation -->
                    <div class="space-y-4">
                        <h2 class="text-3xl font-bold">Cara Pesan Aneka Kue</h2>
                        <!-- Step 1 -->
                        <div class="flex space-x-4 items-center">
                            <div class="p-2 bg-white rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">1</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Pilih Tanggal</h3>
                                <p>Pilih tanggal untuk memesan kue.</p>
                            </div>
                        </div> 

                        <!-- Step 3 -->
                        <div class="flex space-x-4 items-center">
                            <div class="p-2 bg-white rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">3</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Isi Data Diri</h3>
                                <p>Masukkan informasi pribadi seperti nama, alamat dan nomor telepon pada saat mendaftar.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex space-x-4 items-center">
                            <div class="p-2 bg-white rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">2</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Pilih Produk</h3>
                                <p>Pilih kue yang diinginkan dari berbagai pilihan produk yang tersedia.</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex space-x-4 items-center">
                            <div class="p-2 bg-white rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">4</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Pembayaran</h3>
                                <p>Lakukan pembayaran sesuai dengan instruksi yang diberikan untuk menyelesaikan
                                    pesanan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- hubungi kami -->
        <section class="relative isolate bg-base-100 p-8" id="#call">
            <div class="container">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div
                        class="relative flex flex-col md:flex-row max-w-2xl gap-16 px-6 py-16 mx-auto bg-white/50 ring-1 ring-white/10 sm:rounded-3xl sm:p-8 lg:mx-0 lg:max-w-none lg:items-center lg:py-20 xl:gap-x-20 xl:px-20">
                        <!-- Google Maps Embed -->
                        <div class="flex-auto order-1 md:order-none">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.378733594742!2d112.13760316066397!3d-7.855372599999977!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7858b267516e1d%3A0x478e9ba641e567fe!2sJl.%20Rinjani%20No.196%2C%20Legosari%2C%20Ploso%20Kidul%2C%20Kec.%20Plosoklaten%2C%20Kabupaten%20Kediri%2C%20Jawa%20Timur%2064175!5e0!3m2!1sid!2sid!4v1719556654895!5m2!1sid!2sid"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <!-- Contact Information -->
                        <div class="flex flex-col space-y-4 order-2 md:order-none">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Hubungi Kami
                            </h2>
                            <p class="mt-6 text-lg leading-8 text-gray-600">
                                Toko Kami berada di Desa Plosokidul Kecamatan Plosoklaten kabupaten Kediri
                            </p>
                            <ul role="list"
                                class="grid grid-cols-1 mt-10 text-base leading-7 text-gray-600 gap-x-8 gap-y-3 sm:grid-cols-2">
                                {{-- <li class="flex gap-x-3">
                                    <svg class="flex-none w-5 h-7" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Konsultasi Persewaan
                                </li> --}}
                                {{-- <li class="flex gap-x-3">
                                    <svg class="flex-none w-5 h-7" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Profesional
                                </li>
                                <li class="flex gap-x-3">
                                    <svg class="flex-none w-5 h-7" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Keuntungan dalam persewaan gedung
                                </li> --}}
                                {{-- <li class="flex gap-x-3">
                                    <svg class="flex-none w-5 h-7" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Jam Kerja
                                </li>
                                <li class="flex gap-x-3">
                                    <svg class="flex-none w-5 h-7" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Akses Mudah
                                </li> --}}
                            </ul>
                        </div>
                        <div class="absolute inset-x-0 flex justify-center overflow-hidden -top-16 -z-10 transform-gpu blur-3xl"
                            aria-hidden="true">
                            <div class="aspect-[1318/752] w-[42.375rem] flex-none bg-gradient-to-r from-[#80caff] to-[#4f46e5] opacity-25"
                                style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer-center bg-base-200 text-base-content p-4">
        <aside>
            <p>Copyright ©
                <script>
                    document.write(new Date().getFullYear())
                </script> - Bannn
            </p>
        </aside>
    </footer>


    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            // direction: 'vertical',
            loop: false,

            // pagination: {
            //     el: '.swiper-pagination',
            //     clickable: true,
            // },
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },
            // Autoplay parameters
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    </script>
    
    <!-- endscript -->
</body>

</html>
