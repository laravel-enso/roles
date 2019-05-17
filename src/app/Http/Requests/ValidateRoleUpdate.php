<?php

namespace LaravelEnso\Roles\app\Http\Requests;

class ValidateRoleUpdate extends ValidateRoleStore
{
    protected function nameUnique()
    {
        return parent::nameUnique()
            ->ignore($this->route('role')->id);
    }
}
