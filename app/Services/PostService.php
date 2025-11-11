<?php

namespace App\Services;

use App\Models\Posts;
use Illuminate\Support\Str;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected $postRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function savePost($postRequest)
    {
        //$project = new Project();
        // dd($postRequest);

        if(!empty($postRequest['image']))
        {
            $postImage = $postRequest['image'];

            #upload project image
            $postImagePath = $postImage->store('posts', 'private');

            $postRequest['image'] = $postImagePath;
        }

        $postRequest['slug'] = Str::slug($postRequest['name']);

        return $this->postRepository->savePost($postRequest);
    }

    public function getAllPosts()
    {
        return $this->postRepository->getPostQuery();
    } 

    public function updatePost($postId, $postRequest)
    {
        $post = $this->getAllPosts()->find($postId);

        if($post)
        {
            if(!empty($postRequest['image']))
            {
                $postImage = $postRequest['image'];

                #upload project image
                $postImagePath = $postImage->store('posts', 'private');

                $postRequest['image'] = $postImagePath;

                if($post->image && Storage::disk('private')->exists($post->image)){
                    Storage::delete($post->image);
                }

                $post->image = $postImagePath;
            }

            $postRequest['slug'] = Str::slug($postRequest['name']);

            $post->name = $postRequest['name'];
            $post->slug = Str::slug($postRequest['name']);
            $post->description = $postRequest['description'];
            $post->status = $postRequest['status'];

            // $post->update($postRequest);
            return $post->save();
        }
    }

    public function deletePost($id)
    {
        $post = Posts::findOrFail($id);

        if ($post->image && Storage::disk('private')->exists($post->image)) {
            Storage::disk('private')->delete($post->image);
        }

        $post->delete();
    }

}
