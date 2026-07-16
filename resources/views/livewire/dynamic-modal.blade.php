<div>
    <div
        x-data="{ show: @entangle('show') }"
        x-show="show"
        x-on:keydown.escape.window="show = false"
        x-init="$watch('show', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden');
            } else {
                document.body.classList.remove('overflow-y-hidden');
            }
        })"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
        style="display: none;"
        wire:key="dynamic-modal-wrapper"
    >
        <div
            x-show="show"
            class="fixed inset-0 transform transition-all"
            x-on:click="$wire.closeModal()"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-slate-900/40"></div>
        </div>

        <div
            x-show="show"
            class="mb-6 bg-white rounded-2xl overflow-hidden shadow-lg transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            @if ($show && $activeComponent)
                @livewire($activeComponent, $arguments, key('dynamic-modal-' . $activeComponent . '-' . md5(json_encode($arguments))))
            @endif
        </div>
    </div>
</div>
