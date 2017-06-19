<?php

namespace LaravelEnso\RoleManager\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $nameUnique = $this->_method == 'PATCH' ? $nameUnique->ignore($role->id) : $nameUnique;

        return [
            'name'         => ['required', $nameUnique],
            'display_name' => 'required',
            'menu_id'      => 'required',
        ];
    }
}
