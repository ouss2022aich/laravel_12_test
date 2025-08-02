<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use function Pest\Laravel\delete;

class PostController extends Controller
{

    public function __construct(private readonly PostService $postService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get posts
        $posts = $this->postService->getPosts();
        //return response
        return response()->json([
            'message' => 'Success',
            'posts' => $posts,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // validate data
       $request->validate([
            'title' => 'required|max:20|min:3',
            'description' => 'required',
            'published_at' => 'required|date',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $validated = $request->only('title', 'description', 'published_at', 'rating');

        // create post into db
        $post = $this->postService->createPost($validated);

        //return response
        return response()->json([
            'message' => 'Success',
            'post' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = $this->postService->getPostById($id);
        if(!$post){
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }else{
            return response()->json([
                'message' => 'Success',
                'post' => $post,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate data
        $request->validate([
            'title' => 'max:20|min:3',
            'description' => '',
            'published_at' => 'date',
            'rating' => 'numeric|min:0|max:5',
        ]);
        $validated = $request->only('title', 'description', 'published_at', 'rating');

        // update post in db
        $updated = $this->postService->updatePost($validated  , $id);

        // return response
        if ($updated){
            return response()->json([
                'message' => 'post updated',
            ]);
        }else{
            return response()->json([
                'message' => 'Post not updated',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deletedPost = $this->postService->delete($id);
        if (!$deletedPost){
            return response()->json([
                'message' => 'error during delete post',
            ], 404);
        }else{
            return response()->json([
                'message' => 'Success',
                'post' => $deletedPost,
            ]);
        }
    }
}
