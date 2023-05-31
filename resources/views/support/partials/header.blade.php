<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
<?php 
use App\Models\Users\SupportAdmin;
$id=Auth::user()->id;
    SupportAdmin::where('id',$id)->update(['forbidden'=>1]);
?>
	@if(View::exists('support.layout.logo'))
        @include('support.layout.logo')
	@endif
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a role="button" class="dropdown-toggle nav-link">
                <span>
                    @if(Auth::check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-photo">
                    @elseif(Auth::check() && Auth::user()->first_name && Auth::user()->last_name)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->first_name, 0, 1) }}{{ mb_substr(Auth::user()->last_name, 0, 1) }}</span>
                    @elseif(Auth::check() && Auth::user()->name)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    @elseif(Auth::guard(config('support-auth.defaults.guard'))->check() && Auth::guard(config('support-auth.defaults.guard'))->user()->first_name && Auth::guard(config('support-auth.defaults.guard'))->user()->last_name)
                        <span class="avatar-initials">{{ mb_substr(Auth::guard(config('support-auth.defaults.guard'))->user()->first_name, 0, 1) }}{{ mb_substr(Auth::guard(config('support-auth.defaults.guard'))->user()->last_name, 0, 1) }}</span>
                    @else
                        <span class="avatar-initials"><i class="fa fa-user"></i></span>
                    @endif

                    @if(!is_null(config('support-auth.defaults.guard')))
                        <span class="hidden-md-down">{{ Auth::guard(config('support-auth.defaults.guard'))->check() ? Auth::guard(config('support-auth.defaults.guard'))->user()->full_name : 'Anonymous' }}</span>
                    @else
                        <span class="hidden-md-down">{{ Auth::check() ? Auth::user()->full_name : 'Anonymous' }}</span>
                    @endif

                </span>
                <span class="caret"></span>
            </a>
            @if(View::exists('support.layout.profile-dropdown'))
                @include('support.layout.profile-dropdown')
            @endif
        </li>
    </ul>
</header>
