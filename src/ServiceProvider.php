<?php

declare(strict_types=1);

namespace PrusakTech\Laravel\Firebase;

use Illuminate\Contracts\Foundation\Application;
use Kreait\Firebase;

final class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/firebase.php' => $this->app->configPath('firebase.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/firebase.php', 'firebase');

        $this->registerComponents();
    }

    private function registerComponents()
    {
        $this->app->singleton(Firebase\Factory::class, static function (Application $app) {
            $factory = new Firebase\Factory();

            $config = $app->make('config')['firebase'];

            if ($credentialsFile = $config['credentials']['file'] ?? null) {
                $factory = $factory->withServiceAccount((string) $credentialsFile);
            }

            $enableAutoDiscovery = $config['credentials']['auto_discovery'] ?? true;
            if (!$enableAutoDiscovery) {
                $factory = $factory->withDisabledAutoDiscovery();
            }

            if ($databaseUrl = $config['database']['url'] ?? null) {
                $factory = $factory->withDatabaseUri($databaseUrl);
            }

            if ($defaultStorageBucket = $config['storage']['default_bucket'] ?? null) {
                $factory = $factory->withDefaultStorageBucket($defaultStorageBucket);
            }

            if ($cacheStore = $config['cache_store'] ?? null) {
                $factory = $factory->withVerifierCache(
                    $app->make('cache')->store($cacheStore)
                );
            }

            return $factory;
        });

        $this->app->singleton(Firebase\Auth::class, static function (Application $app) {
            return $app->make(Firebase\Factory::class)->createAuth();
        });
        $this->app->alias(Firebase\Auth::class, 'firebase.auth');

        $this->app->singleton(Firebase\Database::class, static function (Application $app) {
            return $app->make(Firebase\Factory::class)->createDatabase();
        });
        $this->app->alias(Firebase\Database::class, 'firebase.database');

        $this->app->singleton(Firebase\DynamicLinks::class, static function (Application $app) {
            $defaultDynamicLinksDomain = $app->make('config')['firebase']['dynamic_links']['default_domain'] ?? null;

            return $app->make(Firebase\Factory::class)->createDynamicLinksService($defaultDynamicLinksDomain);
        });
        $this->app->alias(Firebase\DynamicLinks::class, 'firebase.dynamic_links');

        $this->app->singleton(Firebase\Firestore::class, static function (Application $app) {
            return $app->make(Firebase\Factory::class)->createFirestore();
        });
        $this->app->alias(Firebase\Firestore::class, 'firebase.firestore');

        $this->app->singleton(Firebase\Messaging::class, static function (Application $app) {
            return $app->make(Firebase\Factory::class)->createMessaging();
        });
        $this->app->alias(Firebase\Messaging::class, 'firebase.messaging');

        $this->app->singleton(Firebase\RemoteConfig::class, static function (Application $app) {
            return $app->make(Firebase\Factory::class)->createRemoteConfig();
        });
        $this->app->alias(Firebase\RemoteConfig::class, 'firebase.remote_config');

        $this->app->singleton(Firebase\Storage::class, static function (Application $app) {
            return $app->make(Firebase\Factory::class)->createStorage();
        });
        $this->app->alias(Firebase\Storage::class, 'firebase.storage');
    }
}
