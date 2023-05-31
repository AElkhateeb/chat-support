<?php

namespace App\Http\Requests\Admin\Message;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

use Auth;
class UpdateMessage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows(Auth::user()->load('roles')['roles'][0]['guard_name'].'.message.edit', $this->message);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'dir' => ['sometimes', 'boolean'],
            'from' => ['sometimes', 'string'],
            'to' => ['sometimes', 'string'],
            'segments' => ['sometimes', 'string'],
            'status' => ['sometimes', 'string'],
            'body' => ['sometimes', 'string'],
            'media' => ['sometimes', 'string'],
            'sender_type' => ['sometimes', 'string'],
            'sender_id' => ['sometimes', 'string'],
            'customer_type' => ['sometimes', 'string'],
            'customer_id' => ['sometimes', 'string'],
            'chat_id' => ['nullable', 'integer'],
            
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
