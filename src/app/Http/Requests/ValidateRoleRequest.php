<?php

namespace LaravelEnso\Roles\app\Http\Requests;

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
        return [
            'name' => ['required', $this->nameUnique()],
            'display_name' => 'required',
            'description' => 'nullable',
            'menu_id' => 'nullable|exists:menus,id',
        ];
    }

    protected function nameUnique()
    {
        return Rule::unique('roles', 'name')
            ->ignore(optional($this->route('role'))->id);
    }
}
