@extends('seo.layout.default')

@section('title', trans('admin.service.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <service-form
            :action="'{{ url('seo/services') }}'"
            :locales="{{ json_encode($locales) }}"
            :send-empty-locales="false"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.service.actions.create') }}
                </div>

                <div class="card-body">
                    @include('seo.service.components.form-elements')
                    @include('seo.includes.media-uploader', [
                    'mediaCollection' => app(App\Models\Service::class)->getMediaCollection('service'),
                    'label' => 'Image'
                    ])
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </service-form>

        </div>

        </div>


@endsection
