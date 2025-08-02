<?php

namespace App\Services;

use App\Models\Post;
use phpDocumentor\Reflection\Types\Integer;

class PostService {

    public function createPost( array $data ){
        $post = Post::create($data);
        return $post;
    }

    public function getPosts (){
        $posts = Post::all();
        return $posts;
    }

    public function getPostById(string $id){
        $post = Post::query()->find($id);
        return $post;
    }

    public function delete(string $id){
        $post = $this->getPostById($id);
        if ( $post ){
            return $post->delete();
        }else{
            return false;
        }
    }

    public function updatePost( array $data, string $id ){
        $post = $this->getPostById($id);
        if ( $post ){
            return $post->update($data);
        }else{
            return false;
        }
    }

}
