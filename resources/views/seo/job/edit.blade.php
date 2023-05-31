@extends('seo.layout.default')

@section('title', trans('admin.job.actions.edit', ['name' => $job->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <job-form
                :action="'{{ $job->seo_url }}'"
                :data="{{ $job->toJsonAllLocales() }}"
                :locales="{{ json_encode($locales) }}"
                :send-empty-locales="false"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.job.actions.edit', ['name' => $job->title]) }}
                    </div>

                    <div class="card-body">
                        @include('seo.job.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </job-form>

        </div>

</div>

@endsection
