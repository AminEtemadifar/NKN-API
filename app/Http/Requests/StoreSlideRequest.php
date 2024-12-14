<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSlideRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="StoreResourceRequest",
     *     type="object",
     *     required={"image","slider_id", "ordering"},
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="The title of the slide"
     *     ),
     *     @OA\Property(
     *         property="slider_id",
     *         type="integer",
     *         description="slider id that related to slide"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="A description of the slide"
     *     ),
     *     @OA\Property(
     *         property="ordering",
     *         type="integer",
     *         description="The ordering number for the slide"
     *     ),
     *     @OA\Property(
     *         property="link",
     *         type="string",
     *         format="uri",
     *         description="The link related to the slide"
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="string",
     *         format="binary",
     *         description="An image file for the slide"
     *     ),
     *     @OA\Property(
     *         property="button",
     *         type="array",
     *         description="An array of buttons for the slide",
     *         @OA\Items(
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="The title of the button"
     *             ),
     *             @OA\Property(
     *                 property="link",
     *                 type="string",
     *                 format="uri",
     *                 description="The link for the button"
     *             )
     *         )
     *     )
     * )
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'slider_id' => 'required|exists:sliders,id|integer',
            'description' => 'nullable|string',
            'ordering' => 'required|integer|unique:slides,ordering,NULL,id,deleted_at,NULL',
            'link' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button.*' => 'required|array',
            'button.title' => 'nullable|string',
            'button.link' => 'nullable|link',
        ];
    }
}
