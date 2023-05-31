@extends('ceo.layout.default')

@section('title', trans('admin.boot-admin.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <boot-admin-form
            :action="'{{ url('ceo/boot-admins') }}'"
            :patterns="{{ $patterns->map(function($pattern) { return ['id' => $pattern->id, 'label' =>  $pattern->pattern]; })->toJson() }}"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.boot-admin.actions.create') }}
                </div>

                <div class="card-body">
                    @include('ceo.boot-admin.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </boot-admin-form>

        </div>

        </div>

    
@endsection