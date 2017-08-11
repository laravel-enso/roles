@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Roles"))

@section('content')

    <page v-cloak>
        <span slot="header">
            <a class="btn btn-primary" href="/system/roles/create">
                {{ __("Create Role") }}
            </a>
            <i class="btn btn-info fa fa-gears"
                v-if="!showRoleConfigurator"
                @click="showRoleConfigurator = !showRoleConfigurator">
            </i>
            <i class="btn btn-warning fa fa-gears"
                v-else
                @click="showRoleConfigurator = !showRoleConfigurator">
            </i>
        </span>

        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <vue-form :data="form"
                v-if="!showRoleConfigurator">
            </vue-form>
            <div class="box box-info" v-if="showRoleConfigurator">
                <div class="box-body">
                    <role-configurator
                        role-id="{{ $role->id }}">
                        <span slot="menus-title">{{ __("Menus") }}</span>
                        <span slot="permissions-title">{{ __("Permissions") }}</span>
                        <span slot="update-button">{{ __("Update") }}</span>
                    </role-configurator>
                </div>
            </div>
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        var vm = new Vue({
            el: '#app',

            data: {
                form: {!! $form !!},
                showRoleConfigurator: false
            }
        });

    </script>

@endpush