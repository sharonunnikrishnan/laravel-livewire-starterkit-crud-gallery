<?php

namespace App\Livewire\Posts;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\PostService;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class FormModel extends Component
{

    use WithFileUploads;

    #[Validate('required|string|max:100')]
    public $name = null;
    #[Validate('required|string|max:255')]
    public $description = null;
    #[Validate('required|string')]
    public $postdate = null;
    #[Validate('required|string')]
    public $status = 'active';
    #[Validate('nullable|image|max:5120')]
    public $image = null;

    public $postId = null;
    public $isView = false;
    public $existingImage = null;


    public function savePost(PostService $postService)
    {
        $validatedPostRequest = $this->validate();

        if($this->postId) {
            $postService->updatePost($this->postId, $validatedPostRequest);
        }
        else
        {
            $postService->savePost($validatedPostRequest);
        }
         
        $this->reset();

        $this->dispatch('flash',[
            'message' => 'Post created successfully',
            'type' => 'success'
        ]);

        $this->dispatch('refresh-post-listing');

        // Flux::modal('post-modal')->show();
        Flux::modal('post-modal')->close();
    }

    #[On('open-post-model')]
    public function postDetail($mode,$post = null)
    {
        $this->isView = $mode === 'view'; 

        if($mode === 'create')
        {
            $this->isView = false;
            $this->reset();
        }
        else{ 

            $this->postId = $post['id'];
            $this->name = $post['name'];
            $this->description = $post['description'];
            $this->postdate = $post['postdate'];
            $this->status = $post['status'];
            $this->existingImage = $post['image'];
        }
    }

    public function render()
    {
        return view('livewire.posts.form-model');
    }
}
