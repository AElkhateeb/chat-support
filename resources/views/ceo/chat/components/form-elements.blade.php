<div class="form-group row align-items-center" :class="{'has-danger': errors.has('customer_type'), 'has-success': fields.customer_type && fields.customer_type.valid }">
    <label for="customer_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chat.columns.customer_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.customer_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('customer_type'), 'form-control-success': fields.customer_type && fields.customer_type.valid}" id="customer_type" name="customer_type" placeholder="{{ trans('admin.chat.columns.customer_type') }}">
        <div v-if="errors.has('customer_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('customer_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('customer_id'), 'has-success': fields.customer_id && fields.customer_id.valid }">
    <label for="customer_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chat.columns.customer_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.customer_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('customer_id'), 'form-control-success': fields.customer_id && fields.customer_id.valid}" id="customer_id" name="customer_id" placeholder="{{ trans('admin.chat.columns.customer_id') }}">
        <div v-if="errors.has('customer_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('customer_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sender_type'), 'has-success': fields.sender_type && fields.sender_type.valid }">
    <label for="sender_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chat.columns.sender_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sender_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sender_type'), 'form-control-success': fields.sender_type && fields.sender_type.valid}" id="sender_type" name="sender_type" placeholder="{{ trans('admin.chat.columns.sender_type') }}">
        <div v-if="errors.has('sender_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sender_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sender_id'), 'has-success': fields.sender_id && fields.sender_id.valid }">
    <label for="sender_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chat.columns.sender_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sender_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sender_id'), 'form-control-success': fields.sender_id && fields.sender_id.valid}" id="sender_id" name="sender_id" placeholder="{{ trans('admin.chat.columns.sender_id') }}">
        <div v-if="errors.has('sender_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sender_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('body'), 'has-success': fields.body && fields.body.valid }">
    <label for="body" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chat.columns.body') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.body" v-validate="'required'" id="body" name="body" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('body')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('body') }}</div>
    </div>
</div>


