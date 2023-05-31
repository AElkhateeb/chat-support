<?php

namespace App\Http\Requests\Admin\Reply;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

use Auth;
class DestroyReply extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows(Auth::user()->load('roles')['roles'][0]['guard_name'].'.reply.delete', $this->reply);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
