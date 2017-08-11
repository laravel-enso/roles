@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Roles"))

@section('content')

    <page v-cloak>
        <span slot="header">
            <a class="btn btn-primary" href="/system/roles/create">
                {{ __("Create Role") }}
            </a>
        </span>
        <div class="col-md-12">
            <data-table source="/system/roles"
                id="roles-table">
            </data-table>
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app'
        });

    </script>

@endpush