@extends('seo.layout.default')

@section('title', trans('admin.testimonial.actions.edit', ['name' => $testimonial->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <testimonial-form
                :action="'{{ $testimonial->seo_url }}'"
                :data="{{ $testimonial->toJsonAllLocales() }}"
                :locales="{{ json_encode($locales) }}"
                :send-empty-locales="false"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.testimonial.actions.edit', ['name' => $testimonial->title]) }}
                    </div>

                    <div class="card-body">
                        @include('seo.testimonial.components.form-elements')
                        @include('seo.includes.media-uploader', [
                        'mediaCollection' => app(App\Models\Testimonial::class)->getMediaCollection('testimonial'),
                        'media' => $testimonial->getThumbs200ForCollection('testimonial'),
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

        </testimonial-form>

        </div>

</div>

@endsection
