 
<flux:modal name="post-modal" class="md:w-[32rem]">
    <form wire:submit="savePost" class="space-y-6">
        <div>
            <flux:heading class="font-bold" size="lg">{{ $isView ? 'Post Detail' : ($postId ? 'Update' : 'Create') . ' Post' }} </flux:heading>
            <flux:text class="mt-2">Add a new post using the form below.</flux:text>
        </div>

        <div class="form-group">
            <flux:input :disabled="$isView" wire:model="name" label="Post Title" placeholder="Enter post title" />
        </div>

        <div class="form-group">
            <flux:textarea :disabled="$isView"  wire:model="description" label="Description" placeholder="Short post description" rows="3"/>
        </div>

        <div class="form-group"> 
            <flux:input :disabled="$isView" type="date"  wire:model="postdate"  label="Date"/> 
        </div>

        <div class="form-group">
            <flux:select :disabled="$isView" wire:model="status" placeholder="Select Status...">
                <flux:select.option value="active">Active</flux:select.option>
                <flux:select.option value="inactive">In Active</flux:select.option> 
            </flux:select>
        </div>

        <div class="form-group">
            @if(!$isView)
                <flux:input type="file" wire:model="image" class="cursor-pointer" label="Image" accept="image/*" placeholder="" />
            @endif

            @if($image && !$errors->has('image'))
                <img src="{{ $image->temporaryUrl() }}" alt="Post Image" class="h-18 w-32 mt-5 rounded border"> 
            @elseif($postId && $existingImage) 
                <img src="{{ route('posts.image', basename($existingImage)) }}" alt="Post Image" class="h-18 w-32 mt-5 rounded border"> 
            @endif
        </div>


        <div class="flex justify-end pt-4">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            @if(!$isView)
                <flux:button type="submit" variant="primary" class="cursor-pointer ms-2">{{ $postId ? 'Update' : 'Save' }} Save Post</flux:button>
            @endif
        </div>
    </form>
</flux:modal>
 