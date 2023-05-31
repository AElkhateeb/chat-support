<?php

namespace App\Http\Requests\Admin\Income;
use Auth;
use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateIncome extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows(Auth::user()->load('roles')['roles'][0]['guard_name'].'.income.edit', $this->income);
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'pattern' => ['sometimes'],
            'replay' => ['sometimes'],
            

        ];
    }

    /**
     * Get the validation rules that apply to the requests translatable fields.
     *
     * @return array
     */
    public function translatableRules($locale): array {
        return [
            'income' => ['sometimes', 'string'],
            
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
    public function getReplayId(){
        if ($this->has('replay')){
            return $this->get('replay')['id'];
        }
        return null;
    }
    public function getPatternId(){
        if ($this->has('pattern')){
            return $this->get('pattern')['id'];
        }
        return null;
    }
}
