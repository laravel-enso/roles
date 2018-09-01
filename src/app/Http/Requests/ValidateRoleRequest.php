<?php

namespace LaravelEnso\RoleManager\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $nameUnique = Rule::unique('roles', 'name');

        $nameUnique = $this->method() === 'PATCH'
            ? $nameUnique->ignore($this->route('role')->id)
            : $nameUnique;

        return [
            'name' => ['required', $nameUnique],
            'display_name' => 'required',
            'description' => 'nullable',
            'menu_id' => 'required',
        ];
    }
}
