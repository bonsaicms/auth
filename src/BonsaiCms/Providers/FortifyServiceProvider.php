<?php

namespace BonsaiCms\Providers;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;

use Illuminate\Support\ServiceProvider;

use App\Http\Responses\FetchUserResponse;
use App\Http\Responses\LoginResponse;
use App\Http\Responses\LogoutResponse;
use App\Http\Responses\SuccessfulPasswordResetLinkRequestResponse;
use App\Http\Responses\FailedPasswordResetLinkRequestResponse;
use App\Http\Responses\PasswordResetResponse;
use App\Http\Responses\FailedPasswordResetResponse;

use BonsaiCms\Auth\FetchUserResponseContract;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse as SuccessfulPasswordResetLinkRequestResponseContract;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse as FailedPasswordResetLinkRequestResponseContract;
use Laravel\Fortify\Contracts\PasswordResetResponse as PasswordResetResponseContract;
use Laravel\Fortify\Contracts\FailedPasswordResetResponse as FailedPasswordResetResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->checkSupportedFeatures();

        Fortify::ignoreRoutes();

        $this->bindCustomResponses();
    }

    protected function checkSupportedFeatures()
    {
        if (Features::enabled(Features::registration()))
            $this->throwUnsupportedFeatureException('Registration');

        if (Features::enabled(Features::emailVerification()))
            $this->throwUnsupportedFeatureException('E-mail verification');

        if (Features::enabled(Features::updateProfileInformation()))
            $this->throwUnsupportedFeatureException('Update profile information');

        if (Features::enabled(Features::updatePasswords()))
            $this->throwUnsupportedFeatureException('Update passwords');

        if (Features::enabled(Features::twoFactorAuthentication()))
            $this->throwUnsupportedFeatureException('Two factor authentication');
    }

    protected function throwUnsupportedFeatureException($featureName)
    {
        throw new \BadMethodCallException("$featureName feature is not implemented.");
    }

    protected function bindCustomResponses()
    {
        $this->app->singleton(FetchUserResponseContract::class, FetchUserResponse::class);
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        $this->app->singleton(LogoutResponseContract::class, LogoutResponse::class);
        $this->app->singleton(SuccessfulPasswordResetLinkRequestResponseContract::class, SuccessfulPasswordResetLinkRequestResponse::class);
        $this->app->singleton(FailedPasswordResetLinkRequestResponseContract::class, FailedPasswordResetLinkRequestResponse::class);
        $this->app->singleton(PasswordResetResponseContract::class, PasswordResetResponse::class);
        $this->app->singleton(FailedPasswordResetResponseContract::class, FailedPasswordResetResponse::class);
    }
}
