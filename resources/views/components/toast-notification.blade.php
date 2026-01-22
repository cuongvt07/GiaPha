<div x-data="{
    notifications: [],
    add(message, type = 'success') {
        const id = Date.now();
        this.notifications.push({ id, message, type });
        setTimeout(() => this.remove(id), 3000);
    },
    remove(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
    }
}" x-on:notify-success.window="add($event.detail.message || $event.detail, 'success')"
    x-on:notify-error.window="add($event.detail.message || $event.detail, 'error')"
    x-on:notify-warning.window="add($event.detail.message || $event.detail, 'warning')"
    class="fixed top-4 left-1/2 transform -translate-x-1/2 z-[200] w-full max-w-sm px-4 space-y-2 pointer-events-none">

    <template x-for="note in notifications" :key="note.id">
        <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
            class="pointer-events-auto shadow-lg rounded-lg p-3 flex items-center gap-3 border"
            :class="{
                'bg-white border-green-500 text-green-700': note.type === 'success',
                'bg-white border-red-500 text-red-700': note.type === 'error',
                'bg-white border-yellow-500 text-yellow-700': note.type === 'warning'
            }">

            <!-- Icons -->
            <div x-show="note.type === 'success'" class="flex-shrink-0">
                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div x-show="note.type === 'error'" class="flex-shrink-0">
                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div x-show="note.type === 'warning'" class="flex-shrink-0">
                <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Message -->
            <div class="flex-1 text-sm font-medium" x-text="note.message"></div>

            <!-- Close -->
            <button @click="remove(note.id)" class="text-gray-400 hover:text-gray-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>
