<!-- Top 3 cards - Hotel System -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        
            <!-- Total Rooms -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Rooms</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $rooms->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900/30">
                        <svg width="38px" height="38px" viewBox="0 0 1024 1024" fill="#ffffff"><path d="M512 0L1024 512 512 1024 0 512 512 0z"/></svg>
                    </div>
                </div>
            </div>
        
            <!-- Total Room Types -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Room Types</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $types->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-500/30">
                        <svg width="38px" height="38px" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                    </div>
                </div>
            </div>

            <!-- Most Booked Room -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Most Booked Room</p>
                        <h3 class="mt-2 text-xl font-bold text-neutral-900 dark:text-neutral-100">
                            Suite Room
                        </h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>