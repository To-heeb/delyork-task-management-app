<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach (config('permission.permissions') as $key => $permissions) {
            Gate::define($key, function (User $user) use ($key) {
                return $user->checkPermissionTo($key);
            });
        }

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        VerifyEmail::createUrlUsing(function (object $notifiable) {

            $id = $notifiable->getKey();
            $hash = sha1($notifiable->getEmailForVerification());

            $signedRoute = URL::temporarySignedRoute(
                'api.verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $id,
                    'hash' => $hash,
                ]
            );

            // Parse the URL to extract the query string
            $queryString = parse_url($signedRoute, PHP_URL_QUERY);

            // Parse the query string to extract the parameters
            parse_str($queryString, $params);

            // Extract expires and signature parameters
            $expires = $params['expires'] ?? null;
            $signature = $params['signature'] ?? null;

            return config('app.frontend_url') . "/verify-email/$id/$hash?expires=$expires&signature=$signature";
        });
    }
}
