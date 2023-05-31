<?php

namespace App\Http\Requests\Seo\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreApplication extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('seo.application.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string'],
            'job_id' => ['required', 'integer'],
            'bday' => ['required', 'date'],
            'male' => ['required', 'boolean'],
            'military' => ['required', 'string'],
            'email' => ['nullable', 'email', 'string'],
            'phone' => ['required', 'string'],
            'phone_2' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'area' => ['required', 'string'],
            'education' => ['required', 'string'],
            'experience' => ['required', 'string'],

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
