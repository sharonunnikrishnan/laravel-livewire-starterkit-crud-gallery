<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\Posts;

class ImageModal extends Component
{
    public $showModal = false;
    public $post;

    protected $listeners = ['showImageModal' => 'openModal'];

    public function openModal($postId)
    {
        $this->post = Posts::find($postId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->post = null;
    }

    public function render()
    {
        return view('livewire.posts.image-modal');
    }
}