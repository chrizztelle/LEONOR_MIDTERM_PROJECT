<x-layouts.app :title="__('Room Management')">
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

        <!-- Main container -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-stone-300 bg-stone-50 dark:border-stone-700 dark:bg-stone-900/50">
            <div class="flex h-full flex-col p-6">

                <!-- Add New Room Form -->
                <div class="mb-6 rounded-lg border border-stone-200 bg-stone-100 p-6 dark:border-stone-700 dark:bg-stone-800/50">
                    <h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">Add New Room</h2>

                    <form action="{{ route('rooms.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        <!-- Room Number -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Room Number</label>
                            <input type="text" name="room_number" value="{{ old('room_number') }}" placeholder="Enter room number" required class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                            @error('room_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room Type -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Room Type</label>
                            <select name="rooms_type_id" required class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                                <option value="">Select a room type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->room_type }}</option>
                                @endforeach
                            </select>
                            @error('rooms_type_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Price Per Night</label>
                            <input type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night') }}" placeholder="Enter price per night" required class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                            @error('price_per_night')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Capacity</label>
                            <input type="number" name="capacity" value="{{ old('capacity') }}" placeholder="Enter capacity" required class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                            @error('capacity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Description</label>
                            <textarea name="description" rows="2" placeholder="Enter room description" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-amber-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                                Add Room
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Room List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">Room List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-stone-200 bg-stone-50 dark:border-stone-700 dark:bg-stone-800/50">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Room Number</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Room Type</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Price Per Night</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Capacity</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-700 dark:text-stone-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-200 dark:divide-stone-700">
                                @forelse($rooms as $room)
                                    <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-700/50" id="room-row-{{ $room->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-stone-900 dark:text-stone-100">{{ $room->room_number }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-stone-900 dark:text-stone-100">{{ $room->type ? $room->type->room_type : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-stone-900 dark:text-stone-100">₱{{ number_format($room->price_per_night, 2) }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-stone-900 dark:text-stone-100">{{ $room->capacity }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-stone-600 dark:text-stone-400">{{ Str::limit($room->description, 50) ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editRoom(
                                                {{ $room->id }},
                                                '{{ addslashes($room->room_number) }}',
                                                '{{ $room->rooms_type_id }}',
                                                '{{ $room->price_per_night }}',
                                                '{{ $room->capacity }}',
                                                '{{ addslashes($room->description) }}'
                                            );" class="text-amber-600 transition-colors hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-stone-400">|</span>
                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this room?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-stone-500 dark:text-stone-400">
                                            No rooms found. Add your first room above!
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

    <!-- Edit Room Modal -->
    <div id="editRoomModal" class="fixed inset-0 hidden items-center justify-center bg-stone-900/50 z-[9999]">
        <div class="w-full max-w-2xl rounded-xl border border-stone-200 bg-stone-50 p-6 dark:border-stone-700 dark:bg-stone-800">
            <h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">Edit Room</h2>

            <form id="editRoomForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Room Number</label>
                        <input type="text" id="edit_room_number" name="room_number" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Room Type</label>
                        <select id="edit_room_type" name="rooms_type_id" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                            <option value="">Select a room type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->room_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Price Per Night</label>
                        <input type="number" step="0.01" id="edit_price_per_night" name="price_per_night" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-700 dark:text-stone-300">Capacity</label>
                        <input type="number" id="edit_capacity" name="capacity" class="w-full rounded-lg border border-stone-300 bg-stone-50 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
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
                            Update Room
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editRoom(id, room_number, rooms_type_id, price_per_night, capacity, description) {
            document.getElementById('editRoomModal').classList.remove('hidden');
            document.getElementById('editRoomModal').classList.add('flex');
            document.getElementById('editRoomForm').action = `/rooms/${id}`;
            document.getElementById('edit_room_number').value = room_number;
            document.getElementById('edit_room_type').value = rooms_type_id;
            document.getElementById('edit_price_per_night').value = price_per_night;
            document.getElementById('edit_capacity').value = capacity;
            document.getElementById('edit_description').value = description || '';
        }

        function closeEditModal() {
            document.getElementById('editRoomModal').classList.add('hidden');
            document.getElementById('editRoomModal').classList.remove('flex');
            document.getElementById('editRoomForm').reset();
        }
    </script>
</x-layouts.app>
