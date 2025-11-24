<x-layouts.app :title="__('Room Type')">
    <div class="space-y-6">

        @if(session('success'))
            <div 
                x-data="{ show: true }" 
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)" 
                class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300 transition-all duration-500"
            >
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-stone-300 bg-stone-50 dark:border-stone-700 dark:bg-stone-900/50">
            <div class="flex h-full flex-col p-6">

                <!-- Add New Room Type Form -->
                <div class="mb-6 rounded-lg border border-stone-200 bg-stone-100 p-6 dark:border-stone-700 dark:bg-stone-800/50">
                    <h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">Add New Room Type</h2>

                    <form action="{{ route('types.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Room Type</label>
                            <input type="text" name="room_type" value="{{ old('room_type') }}" placeholder="Enter room type" required class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                            @error('room_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Description</label>
                            <textarea name="description" rows="2" placeholder="Enter room description" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-amber-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                                Add Room Type
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Room Type List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">Room Type List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-stone-200 bg-stone-50 dark:border-stone-700 dark:bg-stone-800/50">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Room Type</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-200 dark:divide-stone-700">
                                @forelse($types as $type)
                                    <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-700/50" id="room-row-{{ $type->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-stone-600 dark:text-stone-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-stone-900 dark:text-stone-100">{{ $type->room_type }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-stone-600 dark:text-stone-400">{{ Str::limit($type->description, 50) ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editRoom(
                                                {{ $type->id }},
                                                '{{ addslashes($type->room_type) }}',
                                                '{{ addslashes($type->description) }}'
                                            );" class="text-amber-600 transition-colors hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-stone-400">|</span>
                                            <form action="{{ route('types.destroy', $type->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this room type?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-stone-500 dark:text-stone-400">
                                            No room types found. Add your first type above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Room Type Modal -->
    <div id="editRoomModal" class="fixed inset-0 hidden items-center justify-center bg-stone-900/50 z-[9999]">
        <div class="w-full max-w-2xl rounded-xl border border-stone-200 bg-stone-50 p-6 dark:border-stone-700 dark:bg-stone-800">
            <h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">Edit Room Type</h2>

            <form id="editRoomTypeForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Room Type</label>
                        <input type="text" id="edit_room_type" name="room_type" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Description</label>
                        <textarea id="edit_description" name="description" rows="3" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100"></textarea>
                    </div>

                    <div class="md:col-span-2 mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeEditModal()" class="rounded-lg border border-stone-300 px-4 py-2 text-sm font-medium text-stone-700 transition-colors hover:bg-stone-100 dark:border-stone-600 dark:text-stone-300 dark:hover:bg-stone-700">
                            Cancel
                        </button>
                        <button type="submit" class="rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-amber-700">
                            Update Room Type
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editRoom(id, room_type, description) {
            document.getElementById('editRoomModal').classList.remove('hidden');
            document.getElementById('editRoomModal').classList.add('flex');
            document.getElementById('editRoomTypeForm').action = `/types/${id}`;
            document.getElementById('edit_room_type').value = room_type;
            document.getElementById('edit_description').value = description || '';
        }

        function closeEditModal() {
            document.getElementById('editRoomModal').classList.add('hidden');
            document.getElementById('editRoomModal').classList.remove('flex');
            document.getElementById('editRoomTypeForm').reset();
        }
    </script>
</x-layouts.app>
