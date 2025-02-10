<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

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
     *             @OA\Property(property="data", ref="#/components/schemas/DoctorResource"),
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
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        //
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
