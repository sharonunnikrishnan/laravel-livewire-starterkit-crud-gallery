<?php

namespace App\Livewire\Posts;

use Livewire\Component; 
use Livewire\WithPagination;
use App\Services\PostService;
use Livewire\WithoutUrlPagination;

class Gallery extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $postId = null;

    protected $updatesQueryString = [];

    public function getAllPosts(PostService $postService)
    {
        return $postService->getAllPosts()->orderBy('id', 'DESC')->paginate(10);
    }

    public function render(PostService $postService)
    {
        $posts = $this->getAllPosts($postService);
        return view('livewire.posts.gallery', compact('posts'));
    }
}
