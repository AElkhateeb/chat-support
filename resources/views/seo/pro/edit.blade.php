@extends('seo.layout.default')

@section('title', trans('admin.pro.actions.edit', ['name' => $pro->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <pro-form
                :action="'{{ $pro->seo_url }}'"
                :data="{{ $pro->toJsonAllLocales() }}"
                :locales="{{ json_encode($locales) }}"
                :send-empty-locales="false"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.pro.actions.edit', ['name' => $pro->title]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.pro.components.form-elements')
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
