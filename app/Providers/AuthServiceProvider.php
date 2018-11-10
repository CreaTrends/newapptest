<?php

namespace App\Providers;

use App\Note;
use App\Policies\NotePolicy;

use App\Apoderado;
use App\Policies\ApoderadoPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        
        Note::class => NotePolicy::class,
        Apoderado::class => ApoderadoPolicy::class
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
    }
}
