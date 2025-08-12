<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\HandleGeneralErrorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    protected $handleGeneralErrorService;

    public function __construct(HandleGeneralErrorService $handleGeneralErrorService)
    {
        $this->handleGeneralErrorService = $handleGeneralErrorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource|CommentResource
    {
        try {
            return CommentResource::collection(Comment::with('post.user')->get());
        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request): CommentResource|JsonResponse
    {
        try {
            $validated = $request->validated();

            $post = Post::find($request->input('post_id'));

            if (! post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found',
                ], Response::HTTP_NOT_FOUND);
            }

            $comment = $post->comments()->create($validated);

            return new CommentResource($comment);

        } catch (\Throwable $th) {

            return $this->handleGeneralErrorService->log($th);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResource|CommentResource
    {
        try {
            return new CommentResource($comment);
        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResource|CommentResource
    {
        try {
            $validated = $request->validated();

            $comment->update($validated);

            return new CommentResource($comment);

        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        try {
            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted',
            ]);
        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }

    }
}
