<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Term;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/search",
     *     summary="جستجوی دکترها و ترم‌ها",
     *     operationId="searchIndex",
     *     tags={"Search"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="کلمه مورد نظر برای جستجو",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="نتایج جستجو",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="results",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="دکتر علی رضایی"),
     *                     @OA\Property(property="type", type="string", example="doctor"),
     *                     @OA\Property(property="url", type="string", example="/doctors/1")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="کلمه‌ای برای جستجو وارد نشده است.")
     * )
     */

    public function index(Request $request)
    {
        $query = $request->input('search');
        $results = [];
        if ($query) {
            $termResults = Term::query()->isMain()
                ->selectRaw("id, title as name, 'term' as type, CONCAT('/terms/', id) as url")
                ->where('title', 'like', "%$query%");
            $doctorResults = Doctor::query()
                ->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$query%"])
                ->selectRaw("id, CONCAT('دکتر ', first_name, ' ', last_name) AS name, 'doctor' AS type, CONCAT('/doctors/', id) AS url");

            $results = $termResults->unionAll($doctorResults)->get();

        }
        return response()->json([
            'results' => $results
        ]);
    }
}
