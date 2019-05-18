<?php

namespace LaravelEnso\Roles\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateRoleStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', $this->nameUnique()],
            'display_name' => 'required',
            'description' => 'nullable',
            'menu_id' => 'nullable|exists:menus,id',
        ];
    }

    protected function nameUnique()
    {
        return Rule::unique('roles', 'name');
    }
}
