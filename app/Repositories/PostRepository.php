<?php

namespace App\Repositories;
use App\Models\Posts;

class PostRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function savePost($postRequest)
    {
        return Posts::create($postRequest);
    }

    public function getPostQuery()
    {
        return Posts::query();
    }
}
