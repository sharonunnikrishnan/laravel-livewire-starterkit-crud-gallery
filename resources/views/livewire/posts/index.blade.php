<div class="p-4">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Post Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create and manage your posts') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="text-end mb-4"> 
        <flux:modal.trigger name="post-modal">
            <flux:button variant="primary" color="green" icon="plus-circle" class="cursor-pointer">Add Post</flux:button>
        </flux:modal.trigger> 
    </div>  

    <livewire:posts.form-model />

    <div 
        x-data="{ show: false, message: '', type: '' }"
        x-init="window.addEventListener('flash', e => {
            const data = e.detail[0]
            message = data.message;
            type = data.type;
            show = true;
            setTimeout(() => show = false, 4000);
        })"
        x-show="show"
        x-transition
        class="fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white z-50"
        :class="{
            'bg-emerald-600': type === 'success',
            'bg-red-600': type === 'error'
        }"
        style="display:none"
    >
        <span x-text="message"></span>
    </div>

    <div class="overflow-x-auto border rounded-xl shadow-md">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold border-b">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Description</th>
                    <th class="p-4">Status</th>
                    <th class="px-13 py-4">Image</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($posts as $post)
                <tr class="hover:gb-gray-50 transition">
                    <td class="p-4">{{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}</td>
                    <td class="p-4">{{ $post->name }}</td>
                    <td class="p-4">{{ $post->description }}</td>
                    <td class="p-4">{{ $post->status }}</td>
                    <td class="p-4">
                        @if($post->image)
                            <img src="{{ route('posts.image', basename($post->image)) }}" alt="Post Image" class="h-18 w-32 rounded border">  
                        @endif
                    </td>
                    <td class="p-4">
                        <flux:modal.trigger name="post-modal">
                            <flux:button wire:click="$dispatch('open-post-model', { mode: 'view', post: {{ $post }} })"  variant="primary" color="blue" icon="eye" class="cursor-pointer"></flux:button> 
                            <flux:button wire:click="$dispatch('open-post-model', { mode: 'edit', post: {{ $post }} })" variant="primary" color="yellow" icon="pencil" class="cursor-pointer"></flux:button>
                        </flux:modal.trigger>
                        <flux:modal.trigger name="delete-post">
                            <flux:button wire:click="$dispatch('delete-post', { id: {{ $post->id }} })"
                                variant="primary"
                                color="red"
                                icon="trash"
                                class="cursor-pointer">
                            </flux:button>
                        </flux:modal.trigger> 
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center">
                        <flux:text class="flex items-center-justify-center text-red-500">
                            <flux:icon.exclamation-triangle class="mr-2"/>No Posts Found!
                        </flux:text>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $posts->links() }}
    </div>

    <flux:modal name="delete-post" class="min-w-[25rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Post?</flux:heading>
                <flux:text class="mt-2">
                    You're about to delete this post.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deletePost" variant="danger">Delete Post</flux:button>
            </div>
        </div>
    </flux:modal>
</div>