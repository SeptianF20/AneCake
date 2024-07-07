<nav class="flex items-center justify-between p-4 lg:px-8 bg-white/10 backdrop-blur-md" aria-label="Global">
    <div class="flex lg:flex-1 items-center">
        <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img src="{{ URL::asset('/assets/images/anecake.png') }}" alt="" class="img-fluid w-auto h-8">
        </a>
    </div>
    <div class="flex lg:hidden">
        <button type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
            data-drawer-placement="right" aria-controls="drawer-right-example"
            class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>
    <div class="hidden lg:flex lg:gap-x-8">
        <a href="{{route('product.show')}}" class="text-md font-semibold leading-6 text-gray-900 hover:text-gray-700">Produk</a>
        <a href="{{route('checkout')}}" class="text-md font-semibold leading-6 text-gray-900 hover:text-gray-700">Pesanan</a>
        <a href="{{route('topup')}}" class="text-md font-semibold leading-6 text-gray-900 hover:text-gray-700">Top Up</a>
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:gap-x-8 lg:justify-end items-center">
        @if (Auth::guard('member')->check())
            <a href="#" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                {{ Auth::guard('member')->user()->nama }}
            </a>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="ml-4 px-2 py-2 btn btn-outline btn-square">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="#" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                Name
            </a>
            <a href="#" class="ml-4 btn btn-outline btn-square">
                Logout
            </a>
        @endif
    </div>


</nav>

<div class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800"
    id="drawer-right-example" tabindex="-1" aria-labelledby="drawer-right-label">
    <div
        class="fixed inset-y-0 right-0 z-10 w-full px-6 py-6 overflow-y-auto bg-white sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img src="{{ URL::asset('/assets/images/anecake.png') }}" alt="" class="img-fluid w-auto h-8">
            </a>
            <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" data-drawer-hide="drawer-right-example"
                aria-controls="drawer-right-example">
                <span class="sr-only">Close menu</span>
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flow-root mt-6">
            <div class="-my-6 divide-y divide-gray-500/10">
                <div class="py-6 space-y-2">
                    <a href="#dateCheck"
                        class="block px-3 py-2 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Produk</a>
                    <a href="#pricing"
                        class="block px-3 py-2 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Pesanan</a>
                    <a href="#call"
                        class="block px-3 py-2 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Top
                        Up</a>
                </div>
                <div class="py-6">
                    @if (Auth::guard('member')->check())
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                            {{ Auth::guard('member')->user()->nama }}
                        </a>
                    @endif
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"
                        class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const drawerButton = document.querySelector('[data-drawer-show]');
        const drawer = document.getElementById('drawer-right-example');
        const drawerCloseButton = drawer.querySelector('[data-drawer-hide]');

        drawerButton.addEventListener('click', function() {
            drawer.classList.remove('translate-x-full');
        });

        drawerCloseButton.addEventListener('click', function() {
            drawer.classList.add('translate-x-full');
        });
    });
</script>
