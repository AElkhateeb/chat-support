<?php

namespace App\Http\Requests\Seo\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateApplication extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('seo.application.edit', $this->application);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fullname' => ['sometimes', 'string'],
            'job_id' => ['sometimes', 'integer'],
            'bday' => ['sometimes', 'date'],
            'male' => ['sometimes', 'boolean'],
            'military' => ['sometimes', 'string'],
            'email' => ['nullable', 'email', 'string'],
            'phone' => ['sometimes', 'string'],
            'phone_2' => ['nullable', 'string'],
            'city' => ['sometimes', 'string'],
            'area' => ['sometimes', 'string'],
            'education' => ['sometimes', 'string'],
            'experience' => ['sometimes', 'string'],

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
