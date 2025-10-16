<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Throwable;

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
        $this->ensureDatabaseExists();
    }

    protected function ensureDatabaseExists(): void
    {
        try {
            $defaultConnection = config('database.default');
            if (! $defaultConnection) {
                return;
            }

            $connectionConfig = config("database.connections.{$defaultConnection}");
            if (! $connectionConfig || ($connectionConfig['driver'] ?? null) !== 'mysql') {
                return;
            }

            $database = $connectionConfig['database'] ?? null;
            if (! $database) {
                return;
            }

            $charset = $connectionConfig['charset'] ?? 'utf8mb4';
            $collation = $connectionConfig['collation'] ?? 'utf8mb4_unicode_ci';
            $temporaryConnectionName = "{$defaultConnection}_without_db";

            Config::set(
                "database.connections.{$temporaryConnectionName}",
                array_merge($connectionConfig, ['database' => null])
            );

            $statement = sprintf(
                'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET %s COLLATE %s',
                str_replace('`', '``', $database),
                $charset,
                $collation
            );

            DB::connection($temporaryConnectionName)->statement($statement);
            DB::purge($temporaryConnectionName);
            DB::purge($defaultConnection);
        } catch (Throwable $e) {
            report($e);
        }
    }
}
