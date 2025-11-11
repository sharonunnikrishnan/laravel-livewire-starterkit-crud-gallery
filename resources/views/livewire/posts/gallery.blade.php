<div class="p-4">
    <!-- Header Section -->
    <div class="relative mb-8 w-full">
        <flux:heading size="xl" level="1">{{ __('Post Gallery') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Browse all posts in gallery view') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Include the modal component -->
    <livewire:posts.image-modal />

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-8">
        @forelse($posts as $post)
            <div 
                class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow"
                wire:click="$dispatch('showImageModal', { postId: {{ $post->id }} })"
            >
                @if($post->image)
                    <div class="aspect-[3/4]">
                        <img 
                            src="{{ route('posts.image', basename($post->image)) }}" 
                            alt="{{ $post->name }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        />
                    </div>
                @else
                    <div class="aspect-[3/4] flex items-center justify-center bg-gray-200">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 text-sm mb-2">{{ $post->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <p class="text-gray-500 text-xl">No posts found</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>