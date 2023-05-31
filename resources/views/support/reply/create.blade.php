@extends('support.layout.default')

@section('title', trans('admin.reply.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <reply-form
            :action="'{{ url('support/replies') }}'"
            :locales="{{ json_encode($locales) }}"
            :patterns="{{ $patterns->map(function($pattern) { return ['id' => $pattern->id, 'label' =>  $pattern->pattern]; })->toJson() }}"
            :send-empty-locales="false"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.reply.actions.create') }}
                </div>

                <div class="card-body">
                    @include('support.reply.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </reply-form>

        </div>

        </div>

    
@endsection