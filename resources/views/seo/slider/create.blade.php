@extends('seo.layout.default')

@section('title', trans('admin.slider.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <slider-form
            :action="'{{ url('seo/sliders') }}'"
            :locales="{{ json_encode($locales) }}"
            :send-empty-locales="false"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.slider.actions.create') }}
                </div>

                <div class="card-body">
                    @include('seo.slider.components.form-elements')
                    @include('seo.includes.media-uploader', [
                       'mediaCollection' => app(App\Models\Slider::class)->getMediaCollection('slider'),
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

        </slider-form>

        </div>

        </div>


@endsection
