<div class="form-group row align-items-center" :class="{'has-danger': errors.has('fullname'), 'has-success': fields.fullname && fields.fullname.valid }">
    <label for="fullname" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.fullname') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.fullname" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('fullname'), 'form-control-success': fields.fullname && fields.fullname.valid}" id="fullname" name="fullname" placeholder="{{ trans('admin.application.columns.fullname') }}">
        <div v-if="errors.has('fullname')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('fullname') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('job_id'), 'has-success': this.fields.job_id && this.fields.job_id.valid }">
    <label for="job_id"
           class="col-form-label text-center col-md-2 col-lg-2">{{ trans('admin.application.columns.job_id') }}</label>
    <div class="col-md-7 col-lg-8">

        <multiselect
            v-model="form.job"
            :options="jobs"
            :multiple="false"
            track-by="id"
            label="title"
            tag-placeholder="{{ __('Select job') }}"
            placeholder="{{ __('Job') }}">
        </multiselect>

        <div v-if="errors.has('job_id')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('job_id') }}
        </div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bday'), 'has-success': fields.bday && fields.bday.valid }">
    <label for="bday" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.bday') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.bday" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('bday'), 'form-control-success': fields.bday && fields.bday.valid}" id="bday" name="bday" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('bday')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bday') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('male'), 'has-success': fields.male && fields.male.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="male" type="checkbox" v-model="form.male" v-validate="''" data-vv-name="male"  name="male_fake_element">
        <label class="form-check-label" for="male">
            {{ trans('admin.application.columns.male') }}
        </label>
        <input type="hidden" name="male" :value="form.male">
        <div v-if="errors.has('male')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('male') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('military'), 'has-success': fields.military && fields.military.valid }">
    <label for="military" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.military') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.military" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('military'), 'form-control-success': fields.military && fields.military.valid}" id="military" name="military" placeholder="{{ trans('admin.application.columns.military') }}">
        <div v-if="errors.has('military')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('military') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.email') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.email" v-validate="'email'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.application.columns.email') }}">
        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.phone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ trans('admin.application.columns.phone') }}">
        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone_2'), 'has-success': fields.phone_2 && fields.phone_2.valid }">
    <label for="phone_2" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.phone_2') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone_2" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone_2'), 'form-control-success': fields.phone_2 && fields.phone_2.valid}" id="phone_2" name="phone_2" placeholder="{{ trans('admin.application.columns.phone_2') }}">
        <div v-if="errors.has('phone_2')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone_2') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city'), 'has-success': fields.city && fields.city.valid }">
    <label for="city" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.city') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city'), 'form-control-success': fields.city && fields.city.valid}" id="city" name="city" placeholder="{{ trans('admin.application.columns.city') }}">
        <div v-if="errors.has('city')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('area'), 'has-success': fields.area && fields.area.valid }">
    <label for="area" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.area') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.area" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('area'), 'form-control-success': fields.area && fields.area.valid}" id="area" name="area" placeholder="{{ trans('admin.application.columns.area') }}">
        <div v-if="errors.has('area')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('area') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('education'), 'has-success': fields.education && fields.education.valid }">
    <label for="education" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.education') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.education" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('education'), 'form-control-success': fields.education && fields.education.valid}" id="education" name="education" placeholder="{{ trans('admin.application.columns.education') }}">
        <div v-if="errors.has('education')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('education') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('experience'), 'has-success': fields.experience && fields.experience.valid }">
    <label for="experience" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.application.columns.experience') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.experience" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('experience'), 'form-control-success': fields.experience && fields.experience.valid}" id="experience" name="experience" placeholder="{{ trans('admin.application.columns.experience') }}">
        <div v-if="errors.has('experience')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('experience') }}</div>
    </div>
</div>


