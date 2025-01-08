<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTermRequest;
use App\Http\Requests\UpdateTermRequest;
use App\Http\Resources\TermResource;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * @OA\Get(
     *     path="/terms",
     *     summary="Retrieve a categories items",
     *     description="Retrieve categories items as terms resource",
     *     tags={"Terms"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Categories items retrieved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/TermResource")
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      )
     * )
     */
    public function index()
    {
        //TODO filter by taxonomy_key
        $terms = Term::all();
        return TermResource::collection($terms);

    }

    /**
     * @OA\Post(
     *     path="/terms",
     *     summary="store a category item",
     *     description="Retrieve category item as terms resource",
     *     tags={"Terms"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *            required=true,
     *            @OA\MediaType(
     *                mediaType="multipart/form-data",
     *                @OA\Schema(ref="#/components/schemas/StoreTermResourceRequest")
     *            ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="categories item in store successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TermResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      )
     * )
     */
    public function store(StoreTermRequest $request)
    {
        $data = $request->validated();
        $term = Term::create($data);
        return TermResource::make($term);
    }

    /**
     * @OA\Get(
     *     path="/terms/{id}",
     *     summary="show a category item",
     *     description="Retrieve category item as terms resource",
     *     tags={"Terms"},
     *     security={{"bearerAuth":{}}},

     *     @OA\Response(
     *         response=200,
     *         description="categories item in store successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TermResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      )
     * )
     */
    public function show(Term $term)
    {
        return TermResource::make($term);
    }

    /**
     * @OA\Put(
     *      path="/terms/{id}",
     *      tags={"Terms"},
     *      summary="Update existing category item",
     *      description="Returns updated category item data",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateTermResourceRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TermResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UpdateTermRequest $request, Term $term)
    {
        $term->update($request->validated());
        return TermResource::make($term);
    }

    /**
     * @OA\Delete (
     *     path="/term",
     *     summary="delete existing category item",
     *     tags={"Terms"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="category item destroy successfully",
     *         @OA\Property(
     *             type="bool",
     *             )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      )
     * )
     */
    public function destroy(Term $term)
    {
        return $term->delete();
    }
}
