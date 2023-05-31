@extends('ceo.layout.default')

@section('title', trans('admin.admin-user.actions.create'))

@section('body')

    <div class="container-xl">

        <div class="card">

            <ceo-admin-form
                :action="'{{ url('ceo/ceo-admin') }}'"
                :activation="!!'{{ $activation }}'"

                inline-template>

                <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action">

                    <div class="card-header">
                        <i class="fa fa-plus"></i> {{ trans('admin.admin-user.actions.create') }}
                    </div>

                    <div class="card-body">

                        @include('ceo.ceo-admin.components.form-elements')

                    </div>

                    <div class="card-footer">
	                    <button type="submit" class="btn btn-primary" :disabled="submiting">
		                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
	                    </button>
                    </div>

                </form>

            </ceo-admin-form>

        </div>

    </div>

@endsection
