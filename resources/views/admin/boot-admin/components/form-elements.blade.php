<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pattern'), 'has-success': fields.pattern && fields.pattern.valid }">
    <label for="pattern" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.boot-admin.columns.pattern') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pattern" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pattern'), 'form-control-success': fields.pattern && fields.pattern.valid}" id="pattern" name="pattern" placeholder="{{ trans('admin.boot-admin.columns.pattern') }}">
        <div v-if="errors.has('pattern')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pattern') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('stuff'), 'has-success': fields.stuff && fields.stuff.valid }">
    <label for="stuff" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.boot-admin.columns.stuff') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.stuff" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('stuff'), 'form-control-success': fields.stuff && fields.stuff.valid}" id="stuff" name="stuff" placeholder="{{ trans('admin.boot-admin.columns.stuff') }}">
        <div v-if="errors.has('stuff')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('stuff') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('previous'), 'has-success': fields.previous && fields.previous.valid }">
    <label for="previous" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.boot-admin.columns.previous') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect
                v-model="form.previous"
                :options="patterns"
                :multiple="false"
                track-by="id"
                label="label"
                tag-placeholder="{{ __('Select Pattern') }}"
                placeholder="{{ __('pattern') }}">
            </multiselect>
        <div v-if="errors.has('previous')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('previous') }}</div>
    </div>
</div>

<div style="display:none;" class="form-check row" :class="{'has-danger': errors.has('checked'), 'has-success': fields.checked && fields.checked.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="checked" type="checkbox" v-model="form.checked" v-validate="''" data-vv-name="checked"  name="checked_fake_element">
        <label class="form-check-label" for="checked">
            {{ trans('admin.boot-admin.columns.checked') }}
        </label>
        <input type="hidden" name="checked" :value="form.checked">
        <div v-if="errors.has('checked')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('checked') }}</div>
    </div>
</div>


