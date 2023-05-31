@extends('ceo.layout.default')

@section('title', trans('admin.income.actions.edit', ['name' => $income->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <income-form
                :action="'{{ $income->ceo_url }}'"
                :data="{{ $income->toJsonAllLocales() }}"
                :patterns="{{ $patterns->map(function($pattern) { return ['id' => $pattern->id, 'label' =>  $pattern->pattern]; })->toJson() }}"
                :replies="{{ $replies->map(function($replay) { return ['id' => $replay->id, 'label' =>  $replay->replay]; })->toJson() }}"
                :locales="{{ json_encode($locales) }}"
                :send-empty-locales="false"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.income.actions.edit', ['name' => $income->id]) }}
                    </div>

                    <div class="card-body">
                        @include('ceo.income.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </income-form>

        </div>
    
</div>

@endsection