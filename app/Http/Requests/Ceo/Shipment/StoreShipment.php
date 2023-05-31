<?php

namespace App\Http\Requests\Seo\Shipment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreShipment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('seo.shipment.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'weight' => ['required', 'numeric'],
            'pkg_num' => ['required', 'integer'],
            'status' => ['required', 'string'],
            'published_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
            'prod_kind' => ['required', 'string'],
            'prod_price' => ['required', 'string'],
            'way_id' => ['required', 'integer'],
            'from_user_id' => ['nullable', 'integer'],
            'to_user_id' => ['nullable', 'integer'],
            'pay_way' => ['nullable', 'integer'],

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

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
