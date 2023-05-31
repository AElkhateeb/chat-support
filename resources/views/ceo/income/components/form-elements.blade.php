<div class="row form-inline" style="padding-bottom: 10px;" v-cloak>
    <div :class="{'col-xl-10 col-md-11 text-right': !isFormLocalized, 'col text-center': isFormLocalized, 'hidden': onSmallScreen }">
        <small>{{ trans('brackets/admin-ui::admin.forms.currently_editing_translation') }}<span v-if="!isFormLocalized && otherLocales.length > 1"> {{ trans('brackets/admin-ui::admin.forms.more_can_be_managed') }}</span><span v-if="!isFormLocalized"> | <a href="#" @click.prevent="showLocalization">{{ trans('brackets/admin-ui::admin.forms.manage_translations') }}</a></span></small>
        <i class="localization-error" v-if="!isFormLocalized && showLocalizedValidationError"></i>
    </div>

    <div class="col text-center" :class="{'language-mobile': onSmallScreen, 'has-error': !isFormLocalized && showLocalizedValidationError}" v-if="isFormLocalized || onSmallScreen" v-cloak>
        <small>{{ trans('brackets/admin-ui::admin.forms.choose_translation_to_edit') }}
            <select class="form-control" v-model="currentLocale">
                <option :value="defaultLocale" v-if="onSmallScreen">@{{defaultLocale.toUpperCase()}}</option>
                <option v-for="locale in otherLocales" :value="locale">@{{locale.toUpperCase()}}</option>
            </select>
            <i class="localization-error" v-if="isFormLocalized && showLocalizedValidationError"></i>
            <span>|</span>
            <a href="#" @click.prevent="hideLocalization">{{ trans('brackets/admin-ui::admin.forms.hide') }}</a>
        </small>
    </div>
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('income_{{ $locale }}'), 'has-success': fields.income_{{ $locale }} && fields.income_{{ $locale }}.valid }">
                <label for="income_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.income.columns.income') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.income.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('income_{{ $locale }}'), 'form-control-success': fields.income_{{ $locale }} && fields.income_{{ $locale }}.valid }" id="income_{{ $locale }}" name="income_{{ $locale }}" placeholder="{{ trans('admin.income.columns.income') }}">
                    <div v-if="errors.has('income_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('income_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pattern_id'), 'has-success': fields.pattern_id && fields.pattern_id.valid }">
    <label for="pattern_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.income.columns.pattern_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect
                v-model="form.pattern"
                :options="patterns"
                :multiple="false"
                track-by="id"
                label="label"
                tag-placeholder="{{ __('Select Pattern') }}"
                placeholder="{{ __('pattern') }}">
            </multiselect>
        <div v-if="errors.has('pattern_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pattern_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('replay_id'), 'has-success': fields.replay_id && fields.replay_id.valid }">
    <label for="replay_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.income.columns.replay_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect
                v-model="form.replay"
                :options="replies"
                :multiple="false"
                track-by="id"
                label="label"
                tag-placeholder="{{ __('Select Replay') }}"
                placeholder="{{ __('replay') }}">
            </multiselect>
        <div v-if="errors.has('replay_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('replay_id') }}</div>
    </div>
</div>


