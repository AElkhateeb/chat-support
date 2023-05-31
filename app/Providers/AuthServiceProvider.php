<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //

        Gate::define('admin.ceo-admin.index', function ($user) { return true; });
        Gate::define('admin.ceo-admin.create', function ($user) { return true; });
        Gate::define('admin.ceo-admin.edit', function ($user) { return true; });
        Gate::define('admin.ceo-admin.delete', function ($user) { return true; });
        Gate::define('admin.ceo-admin.impersonal-login', function ($user) { return true; });

        Gate::define('admin.team-leader-admin.index', function ($user) { return true; });
        Gate::define('admin.team-leader-admin.create', function ($user) { return true; });
        Gate::define('admin.team-leader-admin.edit', function ($user) { return true; });
        Gate::define('admin.team-leader-admin.delete', function ($user) { return true; });
        Gate::define('admin.team-leader-admin.impersonal-login', function ($user) { return true; });

        Gate::define('admin.supervisor-admin.index', function ($user) { return true; });
        Gate::define('admin.supervisor-admin.create', function ($user) { return true; });
        Gate::define('admin.supervisor-admin.edit', function ($user) { return true; });
        Gate::define('admin.supervisor-admin.delete', function ($user) { return true; });
        Gate::define('admin.supervisor-admin.impersonal-login', function ($user) { return true; });

        Gate::define('admin.support-admin.index', function ($user) { return true; });
        Gate::define('admin.support-admin.create', function ($user) { return true; });
        Gate::define('admin.support-admin.edit', function ($user) { return true; });
        Gate::define('admin.support-admin.delete', function ($user) { return true; });
        Gate::define('admin.support-admin.impersonal-login', function ($user) { return true; });

        Gate::define('ceo.support-admin.index', function ($user) { return true; });
        Gate::define('ceo.support-admin.show', function ($user) { return true; });
        Gate::define('ceo.support-admin.create', function ($user) { return true; });
        Gate::define('ceo.support-admin.edit', function ($user) { return true; });
        Gate::define('ceo.support-admin.delete', function ($user) { return true; });
        Gate::define('ceo.support-admin.impersonal-login', function ($user) { return true; });
        Gate::define('ceo.upload', function ($user) { return true; });
        
      /*
        Gate::define('ceo.translation.index', function ($user) { return true; });
        Gate::define('ceo.translation.edit', function ($user) { return true; });
        Gate::define('ceo.translation.rescan', function ($user) { return true; });

        Gate::define('ceo.team-leader-admin.index', function ($user) { return true; });
        Gate::define('ceo.team-leader-admin.show', function ($user) { return true; });
        Gate::define('ceo.team-leader-admin.create', function ($user) { return true; });
        Gate::define('ceo.team-leader-admin.edit', function ($user) { return true; });
        Gate::define('ceo.team-leader-admin.delete', function ($user) { return true; });
        Gate::define('ceo.team-leader-admin.impersonal-login', function ($user) { return true; });

       

        Gate::define('ceo.ceo-admin.index', function ($user) { return true; });
        Gate::define('ceo.ceo-admin.show', function ($user) { return true; });
        Gate::define('ceo.ceo-admin.create', function ($user) { return true; });
        Gate::define('ceo.ceo-admin.edit', function ($user) { return true; });
        Gate::define('ceo.ceo-admin.delete', function ($user) { return true; });
        Gate::define('ceo.ceo-admin.impersonal-login', function ($user) { return true; });

        Gate::define('ceo.chat', function ($user) { return true; });
        Gate::define('ceo.chat.index', function ($user) { return true; });
        Gate::define('ceo.chat.create', function ($user) { return true; });
        Gate::define('ceo.chat.show', function ($user) { return true; });
        Gate::define('ceo.chat.edit', function ($user) { return true; });
        Gate::define('ceo.chat.delete', function ($user) { return true; });
        Gate::define('ceo.chat.bulk-delete', function ($user) { return true; });

        Gate::define('ceo.message', function ($user) { return true; });
        Gate::define('ceo.message.index', function ($user) { return true; });
        Gate::define('ceo.message.create', function ($user) { return true; });
        Gate::define('ceo.message.show', function ($user) { return true; });
        Gate::define('ceo.message.edit', function ($user) { return true; });
        Gate::define('ceo.message.delete', function ($user) { return true; });
        Gate::define('ceo.message.bulk-delete', function ($user) { return true; });

        Gate::define('ceo.customer', function ($user) { return true; });
        Gate::define('ceo.customer.index', function ($user) { return true; });
        Gate::define('ceo.customer.create', function ($user) { return true; });
        Gate::define('ceo.customer.show', function ($user) { return true; });
        Gate::define('ceo.customer.edit', function ($user) { return true; });
        Gate::define('ceo.customer.delete', function ($user) { return true; });
        Gate::define('ceo.customer.bulk-delete', function ($user) { return true; });

        Gate::define('ceo.upload', function ($user) { return true; });*/
    }
}
