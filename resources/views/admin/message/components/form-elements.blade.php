<div class="form-check row" :class="{'has-danger': errors.has('dir'), 'has-success': fields.dir && fields.dir.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="dir" type="checkbox" v-model="form.dir" v-validate="''" data-vv-name="dir"  name="dir_fake_element">
        <label class="form-check-label" for="dir">
            {{ trans('admin.message.columns.dir') }}
        </label>
        <input type="hidden" name="dir" :value="form.dir">
        <div v-if="errors.has('dir')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('dir') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('from'), 'has-success': fields.from && fields.from.valid }">
    <label for="from" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.from') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.from" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('from'), 'form-control-success': fields.from && fields.from.valid}" id="from" name="from" placeholder="{{ trans('admin.message.columns.from') }}">
        <div v-if="errors.has('from')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('from') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('to'), 'has-success': fields.to && fields.to.valid }">
    <label for="to" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.to') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.to" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('to'), 'form-control-success': fields.to && fields.to.valid}" id="to" name="to" placeholder="{{ trans('admin.message.columns.to') }}">
        <div v-if="errors.has('to')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('to') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('segments'), 'has-success': fields.segments && fields.segments.valid }">
    <label for="segments" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.segments') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.segments" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('segments'), 'form-control-success': fields.segments && fields.segments.valid}" id="segments" name="segments" placeholder="{{ trans('admin.message.columns.segments') }}">
        <div v-if="errors.has('segments')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('segments') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.message.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('body'), 'has-success': fields.body && fields.body.valid }">
    <label for="body" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.body') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.body" v-validate="'required'" id="body" name="body" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('body')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('body') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('media'), 'has-success': fields.media && fields.media.valid }">
    <label for="media" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.media') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.media" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('media'), 'form-control-success': fields.media && fields.media.valid}" id="media" name="media" placeholder="{{ trans('admin.message.columns.media') }}">
        <div v-if="errors.has('media')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('media') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sender_type'), 'has-success': fields.sender_type && fields.sender_type.valid }">
    <label for="sender_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.sender_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sender_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sender_type'), 'form-control-success': fields.sender_type && fields.sender_type.valid}" id="sender_type" name="sender_type" placeholder="{{ trans('admin.message.columns.sender_type') }}">
        <div v-if="errors.has('sender_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sender_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sender_id'), 'has-success': fields.sender_id && fields.sender_id.valid }">
    <label for="sender_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.sender_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sender_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sender_id'), 'form-control-success': fields.sender_id && fields.sender_id.valid}" id="sender_id" name="sender_id" placeholder="{{ trans('admin.message.columns.sender_id') }}">
        <div v-if="errors.has('sender_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sender_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('customer_type'), 'has-success': fields.customer_type && fields.customer_type.valid }">
    <label for="customer_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.customer_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.customer_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('customer_type'), 'form-control-success': fields.customer_type && fields.customer_type.valid}" id="customer_type" name="customer_type" placeholder="{{ trans('admin.message.columns.customer_type') }}">
        <div v-if="errors.has('customer_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('customer_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('customer_id'), 'has-success': fields.customer_id && fields.customer_id.valid }">
    <label for="customer_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.customer_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.customer_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('customer_id'), 'form-control-success': fields.customer_id && fields.customer_id.valid}" id="customer_id" name="customer_id" placeholder="{{ trans('admin.message.columns.customer_id') }}">
        <div v-if="errors.has('customer_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('customer_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('chat_id'), 'has-success': fields.chat_id && fields.chat_id.valid }">
    <label for="chat_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.message.columns.chat_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.chat_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('chat_id'), 'form-control-success': fields.chat_id && fields.chat_id.valid}" id="chat_id" name="chat_id" placeholder="{{ trans('admin.message.columns.chat_id') }}">
        <div v-if="errors.has('chat_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('chat_id') }}</div>
    </div>
</div>


