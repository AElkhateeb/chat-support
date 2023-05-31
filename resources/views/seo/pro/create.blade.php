@extends('seo.layout.default')

@section('title', trans('admin.pro.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <pro-form
            :action="'{{ url('seo/pros') }}'"
            :locales="{{ json_encode($locales) }}"
            :send-empty-locales="false"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.pro.actions.create') }}
                </div>

                <div class="card-body">
                    @include('seo.pro.components.form-elements')
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </pro-form>

        </div>

        </div>


@endsection
