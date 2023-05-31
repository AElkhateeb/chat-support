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
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('replay_{{ $locale }}'), 'has-success': fields.replay_{{ $locale }} && fields.replay_{{ $locale }}.valid }">
                <label for="replay_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.reply.columns.replay') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.replay.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('replay_{{ $locale }}'), 'form-control-success': fields.replay_{{ $locale }} && fields.replay_{{ $locale }}.valid }" id="replay_{{ $locale }}" name="replay_{{ $locale }}" placeholder="{{ trans('admin.reply.columns.replay') }}">
                    <div v-if="errors.has('replay_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('replay_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div v-show="data.pattern.stuff != 'Identify' &&  data.pattern.stuff != 'welcome' " class="form-group row align-items-center" :class="{'has-danger': errors.has('pattern_id'), 'has-success': fields.pattern_id && fields.pattern_id.valid }">
    <label for="pattern_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reply.columns.pattern_id') }}</label>
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


