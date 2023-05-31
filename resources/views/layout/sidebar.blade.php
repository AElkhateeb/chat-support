<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('seo/sliders') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.slider.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/identities') }}"><i class="nav-icon icon-plane"></i> {{ trans('admin.identity.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/pros') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.pro.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/services') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.service.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/jobs') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.job.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/applications') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.application.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/testimonials') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.testimonial.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/socials') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.social.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/pages') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.page.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/contacts') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.contact.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('seo/clients') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.client.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('seo/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('seo/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
