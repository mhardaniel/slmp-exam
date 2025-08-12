<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Services\HandleGeneralErrorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    protected $handleGeneralErrorService;

    public function __construct(HandleGeneralErrorService $handleGeneralErrorService)
    {
        $this->handleGeneralErrorService = $handleGeneralErrorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse|JsonResource
    {
        try {
            return PostResource::collection(Post::with('user')->get());
        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }

    }

    /**
     * Display a listing of the resource.
     */
    public function postComments(Post $post): JsonResponse|JsonResource
    {
        return CommentResource::collection($post->comments);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse|PostResource
    {
        try {
            $validated = $request->validated();

            $user = User::find($request->input('user_id'));

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], Response::HTTP_NOT_FOUND);
            }

            $post = $user->posts()->create($validated);

            return new PostResource($post);

        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse|PostResource
    {
        try {

            return new PostResource($post);
        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse|PostResource
    {
        try {
            $validated = $request->validated();

            $post->update($validated);

            return new PostResource($post);

        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted',
            ]);
        } catch (\Throwable $th) {
            return $this->handleGeneralErrorService->log($th);
        }

    }
}
