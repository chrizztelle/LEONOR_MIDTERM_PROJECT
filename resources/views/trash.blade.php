<x-layouts.app :title="__('Room Trash')">
    <div class="space-y-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div
                class="rounded-lg bg-green-50 p-4 text-sm text-green-700 border border-green-200
                       dark:bg-green-900/40 dark:text-green-300 dark:border-green-800"
                x-data="{ show:true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-amber-600 dark:text-amber-400">
                    Room Trash
                </h1>
                <p class="mt-1 text-sm text-stone-600 dark:text-stone-400">
                    Restore or permanently delete rooms
                </p>
            </div>
            <a href="{{ route('rooms.index') }}"
               class="rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700">
                Back to Rooms
            </a>
        </div>

        {{-- Summary Card --}}
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 shadow-sm
                    dark:border-amber-800 dark:bg-amber-900/30">
            <p class="text-sm font-medium text-amber-600 dark:text-amber-400">
                Rooms in Trash
            </p>
            <p class="mt-1 text-3xl font-bold text-amber-900 dark:text-amber-100">
                {{ $rooms->count() }}
            </p>
        </div>

        {{-- Table Container --}}
        <div class="relative overflow-hidden rounded-xl border border-stone-200 bg-stone-50
                    dark:border-stone-700 dark:bg-stone-900/50">
            <div class="p-6">

                <h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">
                    Deleted Rooms
                </h2>

                @if($rooms->isEmpty())
                    <div class="flex items-center justify-center rounded-lg border border-dashed
                                border-stone-300 p-12 dark:border-stone-700">
                        <div class="text-center">
                            <h3 class="text-sm font-medium text-stone-600 dark:text-stone-400">
                                Trash is empty
                            </h3>
                            <p class="mt-1 text-sm text-stone-500 dark:text-stone-500">
                                No deleted rooms found.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-stone-200 dark:border-stone-700">
                        <table class="w-full text-left">
                            <thead class="bg-stone-100 border-b border-stone-200
                                         dark:bg-stone-800/50 dark:border-stone-700">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-semibold text-stone-600 dark:text-stone-300">Room Number</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-stone-600 dark:text-stone-300">Room Type</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-stone-600 dark:text-stone-300">Price</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-stone-600 dark:text-stone-300">Capacity</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-stone-600 dark:text-stone-300">Deleted At</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-stone-600 dark:text-stone-300 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-stone-200 dark:divide-stone-700">
                                @foreach($rooms as $room)
                                    <tr class="transition hover:bg-stone-50 dark:hover:bg-stone-700/50">

                                        {{-- Room Number --}}
                                        <td class="px-4 py-3 text-sm font-medium text-stone-900 dark:text-stone-100">
                                            {{ $room->room_number }}
                                        </td>

                                        {{-- Room Type --}}
                                        <td class="px-4 py-3 text-sm text-stone-600 dark:text-stone-400">
                                            {{ $room->type?->room_type ?? 'N/A' }}
                                        </td>

                                        {{-- Price --}}
                                        <td class="px-4 py-3 text-sm font-semibold text-amber-700 dark:text-amber-400">
                                            ₱{{ number_format($room->price_per_night, 2) }}
                                        </td>

                                        {{-- Capacity --}}
                                        <td class="px-4 py-3 text-sm font-semibold text-amber-700 dark:text-amber-400">
                                            {{ $room->capacity }}
                                        </td>

                                        {{-- Deleted At --}}
                                        <td class="px-4 py-3 text-sm text-stone-500 dark:text-stone-400">
                                            {{ $room->deleted_at->format('M d, Y') }}
                                            <div class="text-xs">
                                                {{ $room->deleted_at->format('h:i A') }}
                                            </div>
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-3">
                                            <div class="flex justify-end gap-2">

                                                {{-- Restore --}}
                                                <form method="POST" action="{{ route('rooms.restore', $room->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Restore this room?')"
                                                        class="rounded-lg bg-green-600 px-3 py-1.5 text-sm
                                                               font-medium text-white hover:bg-green-700">
                                                        Restore
                                                    </button>
                                                </form>

                                                {{-- Delete Forever --}}
                                                <form method="POST" action="{{ route('rooms.force-delete', $room->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Permanently delete this room? This cannot be undone!')"
                                                        class="rounded-lg bg-red-600 px-3 py-1.5 text-sm
                                                               font-medium text-white hover:bg-red-700">
                                                        Delete Forever
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layouts.app>
