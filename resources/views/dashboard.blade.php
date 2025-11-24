<x-layouts.app :title="__('Dashboard')">
    <!-- Wrapper with background image -->
    <div class="relative rounded-xl overflow-hidden h-60 md:h-72">

        <!-- Image overlay -->
        <img src="{{ asset('images/back.png') }}" class="absolute opacity-90 inset-0 object-cover" alt="">

        <!-- Top 3 cards -->
        <div class="relative grid auto-rows-2 gap-3 md:grid-cols-3 p-4 
                    h-full items-center">  <!-- CENTER VERTICALLY -->

            <!-- Total Rooms -->
            <div class="rounded-xl border border-neutral-200 bg-white/80 backdrop-blur-md p-6 dark:border-neutral-700 dark:bg-neutral-800/70 h-20 md:h-28">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Total Rooms</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $rooms->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-400 p-3 dark:bg-blue-900/30">
                        <svg width="38px" height="38px" viewBox="0 0 1024 1024" fill="#ffffff">
                            <path d="M512 0L1024 512 512 1024 0 512 512 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Room Types -->
            <div class="rounded-xl border border-neutral-200 bg-white/80 backdrop-blur-md p-6 dark:border-neutral-700 dark:bg-neutral-800/70 h-20 md:h-28">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Total Room Types</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $types->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-500/30">
                        <svg width="38px" height="38px" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 12h18M3 6h18M3 18h18"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Most Booked Room -->
            <div class="rounded-xl border border-neutral-200 bg-white/80 backdrop-blur-md p-6 dark:border-neutral-700 dark:bg-neutral-800/70 h-20 md:h-28">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Most Booked Room</p>
                        <h3 class="mt-2 text-2xl font-bold text-neutral-900 dark:text-neutral-100">Suite Room</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Bottom image section -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
    
        <!-- Image 1 -->
        <div class="rounded-xl overflow-hidden shadow-xl ">
            <img src="{{ asset('images/room1.jpg') }}" class="w-full h-40 object-cover" alt="">
            <p class="mt-2 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                Junior Suite
            </p>
        </div>
    
        <!-- Image 2 -->
        <div class="rounded-xl overflow-hidden shadow-xl">
            <img src="{{ asset('images/room2.jpg') }}" class="w-full h-40 object-cover" alt="">
            <p class="mt-2 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                Suite
            </p>
        </div>
    
        <!-- Image 3 -->
        <div class="rounded-xl overflow-hidden shadow-xl">
            <img src="{{ asset('images/room3.jpg') }}" class="w-full h-40 object-cover" alt="">
            <p class="mt-2 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                Studio
            </p>
        </div>

        <!-- Image 4 -->
        <div class="rounded-xl overflow-hidden shadow-xl">
            <img src="{{ asset('images/room4.jpg') }}" class="w-full h-40 object-cover" alt="">
            <p class="mt-2 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                Deluxe Room
            </p>
        </div>

        <!-- Image 5 -->
        <div class="rounded-xl overflow-hidden shadow-xl">
            <img src="{{ asset('images/room5.jpg') }}" class="w-full h-40 object-cover" alt="">
            <p class="mt-2 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                Standard Room
            </p>
        </div>

        <!-- Image 6 -->
        <div class="rounded-xl overflow-hidden shadow-xl">
            <img src="{{ asset('images/room6.jpg') }}" class="w-full h-40 object-cover" alt="">
            <p class="mt-2 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                Twin Room
            </p>
        </div>
    
    </div>

    <!-- Bottom-right link -->
    <div class="bg-blue-500 right-6 -bottom-8 h-15 w-15 rounded-full absolute flex items-center justify-center transform transition-transform duration-200 hover:scale-125">
        <a href="{{ route('rooms.index') }}" class="text-5xl text-white">+</a>
    </div>

</x-layouts.app>
