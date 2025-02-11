<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/blogs",
     *     summary="Get a paginated list of blogs",
     *     description="Retrieve a paginated list of blog resources.",
     *     operationId="getBlogs",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/BlogResource"),
     *             @OA\Property(property="links", ref="#/components/schemas/LinksPaginationResource"),
     *             @OA\Property(property="meta", ref="#/components/schemas/MetaPaginationResource"),
     *         )
     *     )
     * )
     */
    public function index()
    {
        return BlogResource::collection(Blog::query()->paginate());
    }

    /**
     * @OA\Post(
     *     path="/blogs",
     *     tags={"Blogs"},
     *     summary="Create a new blog",
     *     description="Store a new blog in the database",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreBlogRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Blog created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BlogResource")
     *     ),
     *       @OA\Response(
     *           response=401,
     *           description="Unauthenticated",
     *       ),
     *       @OA\Response(
     *           response=403,
     *           description="Forbidden"
     *       )
     * )
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();
        $blog['user_id'] = Auth::id();
        $blog = Blog::query()->create($data);

        if ($request->has('main_image')) {
            $blog->clearMediaCollection('image');
            $blog->addMediaFromRequest('main_image')
                ->toMediaCollection('image');

        }

        return BlogResource::make($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
