<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BlogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/blogs",
     *     summary="Get a paginated list of blogs",
     *     description="Retrieve a paginated list of blog resources.",
     *     operationId="getBlogs",
     *     tags={"Blogs"},
     *    @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number for pagination",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *    ),
     *    @OA\Parameter(
     *          name="with_slider",
     *          in="query",
     *          description="Include slider blogs",
     *          required=false,
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *    ),
     *    @OA\Parameter(
     *          name="filter[search]",
     *          in="query",
     *          description="Search term to filter blogs by title or sub_title",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="example"
     *          )
     *    ),
     *    @OA\Parameter(
     *          name="filter[user_id]",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *    ),
     *    @OA\Parameter(
     *          name="filter[type]",
     *          in="query",
     *          required=false,
     *          description="'news', 'blog' , social_responsibility",
     *          @OA\Schema(
     *              type="string",
     *          )
     *    ),
     *    @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          description="Sort blogs by title : 'title', 'duration', 'sub_title', 'created_at', 'published_at'",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="title"
     *          )
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/BlogResource")
     *             ),
     *             @OA\Property(property="links", ref="#/components/schemas/LinksPaginationResource"),
     *             @OA\Property(property="meta", ref="#/components/schemas/MetaPaginationResource"),
     *             @OA\Property(
     *                 property="slider",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/BlogResource")
     *             ),
     *         )
     *    )
     * )
     */

    public function index(Request $request)
    {
        $request->mergeIfMissing([
            'filter' => ['type' => 'blog']
        ]);
        $blogs = QueryBuilder::for(Blog::class)
            ->with('user')
            ->orderByDesc('published_at')
            ->allowedFilters([
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    $query->where('title', 'like', '%' . $value . '%');
                    $query->orWhere('sub_title', 'like', '%' . $value . '%');
                }),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('type'),
            ])
            ->defaultSorts('-created_at')->allowedSorts('title', 'duration', 'sub_title', 'created_at', 'published_at')
            ->paginate(request()->per_page);

        if (request()->has('with_slider') && request()->input('with_slider')) {
            return BlogResource::collection($blogs)->additional([
                'slider' => BlogResource::collection(Blog::where('type', $request->input('type'))->limit(5)->orderBy('published_at')->get()),
            ]);
        }
        return BlogResource::collection($blogs);
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
        $data['user_id'] = Auth::id();

        $blog = Blog::create($data);

        $blog->clearMediaCollection('main_image');
        $blog->addMediaFromRequest('main_image')
            ->toMediaCollection('main_image');

        return BlogResource::make($blog);
    }

    /**
     * @OA\Get(
     *     path="/blogs/{slug}",
     *     summary="Get a specific blog",
     *     description="Retrieve a specific blog resource by its ID.",
     *     operationId="getBlogById",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="ID of the blog to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="لورم_ایپسوم_عنوان_اول"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/BlogResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Blog not found"
     *     )
     * )
     */
    public function show(Blog $blog)
    {
        return BlogResource::make($blog);
    }

    /**
     * @OA\Put(
     *     path="/blogs/{slug}",
     *     tags={"Blogs"},
     *     summary="Update an existing blog",
     *     description="Update the details of an existing blog resource.",
     *     operationId="updateBlog",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="ID of the blog to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateBlogRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Blog updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BlogResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Blog not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        /** @var Blog $blog */

        $data = $request->validated();
        $blog->update($data);
        $blog->refresh();
        if ($request->has('main_image')) {
            $blog->clearMediaCollection('main_image');
            $blog->addMediaFromRequest('main_image')
                ->toMediaCollection('main_image');

        }

        return BlogResource::make($blog);
    }

    /**
     * @OA\Delete(
     *     path="/blogs/{slug}",
     *     tags={"Blogs"},
     *     summary="Delete a specific blog",
     *     description="Remove a specific blog resource by its ID.",
     *     operationId="deleteBlog",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="ID of the blog to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Blog deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Blog not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function destroy(Blog $blog)
    {
        return $blog->delete();
    }
}
