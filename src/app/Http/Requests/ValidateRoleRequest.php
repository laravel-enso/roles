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
        $role = $this->route('role');
        $nameUnique = Rule::unique('roles', 'name');

        $nameUnique = request()->getMethod() === 'PATCH'
            ? $nameUnique->ignore($role->id)
            : $nameUnique;

        return [
            'name' => ['required', $nameUnique],
            'display_name' => 'required',
            'menu_id' => 'required',
        ];
    }
}
