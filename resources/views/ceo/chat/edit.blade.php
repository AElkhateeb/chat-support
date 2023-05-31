@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.chat.actions.edit', ['name' => $chat->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <chat-form
                :action="'{{ $chat->ceo_url }}'"
                :data="{{ $chat->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.chat.actions.edit', ['name' => $chat->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.chat.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </chat-form>

        </div>
    
</div>

@endsection