@extends('ceo.layout.default')

@section('title', trans('admin.boot-admin.actions.edit', ['name' => $bootAdmin->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <boot-admin-form
                :action="'{{ $bootAdmin->ceo_url }}'"
                :data="{{ $bootAdmin->toJson() }}"
                :patterns="{{ $patterns->map(function($pattern) { return ['id' => $pattern->id, 'label' =>  $pattern->pattern]; })->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.boot-admin.actions.edit', ['name' => $bootAdmin->id]) }}
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