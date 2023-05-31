<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/chats') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.chat.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/messages') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.message.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/customers') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.customer.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/boot-admins') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.boot-admin.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/incomes') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.income.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/replies') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.reply.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/chat') }}"><i class="nav-icon icon-user"></i> {{ __('Manage chat') }}</a></li>

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Users access
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage Admin ') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/ceo-admin') }}"><i class="nav-icon icon-user"></i> {{ __('Manage Ceo ') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/team-leader-admin') }}"><i class="nav-icon icon-user"></i> {{ __('Manage Team Leader ') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/supervisor-admin') }}"><i class="nav-icon icon-user"></i> {{ __('Manage Supervisor ') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/support-admin') }}"><i class="nav-icon icon-user"></i> {{ __('Manage Support ') }}</a></li>
                </ul>
            </li> <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
