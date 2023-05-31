@extends('seo.layout.default')

@section('title', trans('admin.contact.actions.edit', ['name' => $contact->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <contact-form
                :action="'{{ $contact->seo_url }}'"
                :data="{{ $contact->toJsonAllLocales() }}"
                :locales="{{ json_encode($locales) }}"
                :send-empty-locales="false"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.contact.actions.edit', ['name' => $contact->title]) }}
                    </div>

                    <div class="card-body">
                        @include('seo.contact.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </contact-form>

        </div>

</div>

@endsection
