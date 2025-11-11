<div>
    @if($showModal && $post)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-95" wire:click="closeModal"></div>
            
            <!-- Modal container -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative max-w-7xl w-full max-h-[95vh]">
                    <!-- Close button -->
                    <button 
                        wire:click="closeModal" 
                        class="absolute top-4 right-4 z-20 bg-black/50 hover:bg-black/70 text-white rounded-full p-3 transition-all duration-200 backdrop-blur-sm"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Large image -->
                    <div class="flex items-center justify-center">
                        <img 
                            src="{{ route('posts.image', basename($post->image)) }}" 
                            alt="{{ $post->name }}"
                            class="max-w-full max-h-[90vh] w-auto h-auto object-contain rounded-lg shadow-2xl"
                        />
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>