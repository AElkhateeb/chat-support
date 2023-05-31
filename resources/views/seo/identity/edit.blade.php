@extends('seo.layout.default')

@section('title', trans('admin.identity.actions.edit', ['name' => $identity->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <identity-form
                :action="'{{ $identity->seo_url }}'"
                :data="{{ $identity->toJsonAllLocales() }}"
                :locales="{{ json_encode($locales) }}"
                :send-empty-locales="false"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.identity.actions.edit', ['name' => $identity->title]) }}
                    </div>

                    <div class="card-body">
                        @include('seo.identity.components.form-elements')
                        @include('seo.includes.media-uploader', [
                        'mediaCollection' => app(App\Models\Identity::class)->getMediaCollection('identity'),
                        'media' => $identity->getThumbs200ForCollection('identity'),
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

        </identity-form>

        </div>

</div>

@endsection
