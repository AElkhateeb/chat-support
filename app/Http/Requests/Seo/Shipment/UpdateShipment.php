<?php

namespace App\Http\Requests\Seo\Shipment;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateShipment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('seo.shipment.edit', $this->shipment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'weight' => ['sometimes', 'numeric'],
            'pkg_num' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'string'],
            'published_at' => ['sometimes', 'date'],
            'end_at' => ['sometimes', 'date'],
            'prod_kind' => ['sometimes', 'string'],
            'prod_price' => ['sometimes', 'string'],
            'way_id' => ['sometimes', 'integer'],
            'from_user_id' => ['nullable', 'integer'],
            'to_user_id' => ['nullable', 'integer'],
            'pay_way' => ['nullable', 'integer'],
            'publish_now' => ['nullable', 'boolean'],
            'unpublish_now' => ['nullable', 'boolean'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        if (isset($sanitized['publish_now']) && $sanitized['publish_now'] === true) {
            $sanitized['published_at'] = Carbon::now();
        }

        if (isset($sanitized['unpublish_now']) && $sanitized['unpublish_now'] === true) {
            $sanitized['published_at'] = null;
        }

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
