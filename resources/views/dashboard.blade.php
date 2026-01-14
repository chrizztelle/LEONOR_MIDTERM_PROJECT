<x-layouts.app :title="__('Dashboard')">
    <!-- Wrapper with background image -->
    <div class="relative rounded-xl overflow-hidden mb-4 h-60 md:h-72">

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

    <div class="rounded-xl border border-stone-200 bg-gradient-to-b from-stone-50 via-stone-100 to-stone-50 p-6 dark:border-stone-700 dark:from-stone-900 dark:via-stone-800 dark:to-stone-900">

                {{-- Header + Export --}}
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-stone-900 dark:text-stone-100">
                            Search & Filter Rooms
                        </h2>
                        <p class="mt-1 text-sm text-stone-600 dark:text-stone-400">
                            Find rooms by number or type
                        </p>
                    </div>

                    <form method="GET" action="{{ route('rooms.export') }}" enctype="multipart/form-data">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="type_filter" value="{{ request('type_filter') }}">

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg
                                bg-amber-600 px-4 py-2 text-sm font-medium text-white
                                transition hover:bg-amber-700
                                focus:ring-2 focus:ring-amber-500/40">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export PDF
                        </button>
                    </form>
                </div>

                {{-- Filters --}}
                <form action="{{ route('dashboard') }}" method="GET" enctype="multipart/form-data"
                    class="grid gap-4 md:grid-cols-3">

                    {{-- Search --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">
                            Search Room
                        </label>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by room number"
                            class="w-full rounded-lg border border-stone-300 bg-stone-50
                                px-4 py-2 text-sm text-stone-900 placeholder-stone-400
                                focus:border-amber-500 focus:outline-none
                                focus:ring-2 focus:ring-amber-500/30
                                dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100"
                        >
                    </div>

                    {{-- Room Type --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">
                            Filter by Room Type
                        </label>
                        <select
                            name="type_filter"
                            class="w-full rounded-lg border border-stone-300 bg-stone-50
                                px-4 py-2 text-sm text-stone-900
                                focus:border-amber-500 focus:outline-none
                                focus:ring-2 focus:ring-amber-500/30
                                dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100"
                        >
                            <option value="">All Types</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}"
                                    {{ request('type_filter') == $type->id ? 'selected' : '' }}>
                                    {{ $type->room_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="flex-1 rounded-lg bg-amber-600 px-4 py-2
                                text-sm font-medium text-white
                                transition hover:bg-amber-700
                                focus:ring-2 focus:ring-amber-500/30">
                            Apply
                        </button>

                        <a
                            href="{{ route('rooms.index') }}"
                            class="rounded-lg border border-stone-300 px-4 py-2
                                text-sm font-medium text-stone-700
                                transition hover:bg-stone-100
                                dark:border-stone-600 dark:text-stone-300 dark:hover:bg-stone-700">
                            Clear
                        </a>
                    </div>

                </form>
            </div>

            @if($rooms->count())
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-4">
                    @foreach($rooms as $room)
                        <div class="rounded-xl overflow-hidden bg-amber-100 shadow-lg dark:bg-amber-900/30">
                            @if($room->photo)
                                <img src="{{ Storage::url($room->photo) }}" class="w-full h-40 object-cover" alt="{{ $room->room_number }}">
                            @else
                                <div class="w-full h-40 flex items-center justify-center bg-amber-200 dark:bg-amber-700">
                                    <span class="text-2xl font-bold text-amber-800 dark:text-amber-300">
                                        {{ strtoupper(substr($room->room_number, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                            <p class="mt-2 text-center text-amber-900 dark:text-amber-200 font-medium">
                                {{ $room->room_number }} – {{ $room->type ? $room->type->room_type : 'N/A' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-6 text-center text-stone-500 italic dark:text-stone-400">
                    No rooms added yet. Add a room to display visuals.
                </p>
            @endif

    <!-- Bottom-right link -->
    <div class="bg-blue-500 right-6 -bottom-8 h-15 w-15 rounded-full absolute flex items-center justify-center transform transition-transform duration-200 hover:scale-125">
        <a href="{{ route('rooms.index') }}" class="text-5xl text-white">+</a>
    </div>

</x-layouts.app>
