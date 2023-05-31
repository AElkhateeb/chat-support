@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reply.actions.edit', ['name' => $reply->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <reply-form
                :action="'{{ $reply->resource_url }}'"
                :data="{{ $reply->toJsonAllLocales() }}"
                :patterns="{{ $patterns->map(function($pattern) { return ['id' => $pattern->id, 'label' =>  $pattern->pattern]; })->toJson() }}"
                :locales="{{ json_encode($locales) }}"
                :send-empty-locales="false"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.reply.actions.edit', ['name' => $reply->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.reply.components.form-elements')
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