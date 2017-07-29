@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Roles"))

@section('content')

    <section class="content-header">
        <a class="btn btn-primary" href="/system/roles/create">
            {{ __("Create Role") }}
        </a>
        @include('laravel-enso/menumanager::breadcrumbs')
    </section>
    <section class="content">
        <div class="row" v-cloak>
            <div class="col-md-12">
                <data-table source="/system/roles"
                    id="roles-table">
                </data-table>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script>

        let vue = new Vue({
            el: '#app'
        });

    </script>

@endpush