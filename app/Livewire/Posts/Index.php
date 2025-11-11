<?php

namespace App\Livewire\Posts;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\PostService;
use Livewire\WithoutUrlPagination;

class Index extends Component
{

    use WithPagination, WithoutUrlPagination;
    public $postId = null;

    protected $updatesQueryString = [];

    public function getAllPosts(PostService $postService)
    {
        return $postService->getAllPosts()->orderBy('id', 'DESC')->paginate(10);
    }

    #[On('refresh-post-listing')]
    public function refreshPostListing(PostService $postService)
    {
        $this->getAllPosts($postService);
    }

    #[On('delete-post')]
    public function deletePostConfirmation($id)
    {
        $this->postId = $id;
    }

    public function deletePost(PostService $postService)
    {
        if ($this->postId) {
            $postService->deletePost($this->postId);

            $this->dispatch('flash', [
                'message' => 'Post deleted successfully',
                'type' => 'success'
            ]);

            $this->dispatch('$refresh');

            // refresh posts
            $this->resetPage();

            Flux::modal('delete-post')->close();
        }
    }


    public function render(PostService $postService)
    {
        $posts = $this->getAllPosts($postService);
        return view('livewire.posts.index', compact('posts'));
    }
}
