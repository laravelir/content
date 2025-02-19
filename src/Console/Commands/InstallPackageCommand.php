<?php

namespace Laravelir\Contentable\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallPackageCommand extends Command
{
    protected $signature = 'contentable:install';

    protected $description = 'Install the contentable Package';

    public function handle()
    {
        $this->line("\t... Welcome To Package Installer ...");

        if (File::exists(config_path('contentable.php'))) {
            $confirm = $this->confirm("contentable.php already exist. Do you want to overwrite?");
            if ($confirm) {
                $this->publishConfig();
                $this->info("config overwrite finished");
            } else {
                $this->info("skipped config publish");
            }
        } else {
            $this->publishConfig();
            $this->info("config published");
        }

        if (!empty(File::glob(database_path('migrations\*_create_contentable_table.php')))) {

            $list  = File::glob(database_path('migrations\*_create_contentable_table.php'));
            collect($list)->each(function ($item) {
                File::delete($item);
            });

            $this->publishMigration();
        } else {
            $this->publishMigration();
        }


        $this->info("Package Successfully Installed.\n");
        $this->info("\t\tGood Luck.");
    }

    private function publishConfig()
    {
        $this->call('vendor:publish', [
            '--provider' => "Laravelir\Contentable\\Providers\\ContentableServiceProvider",
            '--tag'      => 'contentable-config',
            '--force'    => true
        ]);
    }

    private function publishMigration()
    {
        $this->call('vendor:publish', [
            '--provider' => "Laravelir\Contentable\\Providers\\ContentableServiceProvider",
            '--tag'      => 'contentable-migrations',
            '--force'    => true
        ]);
    }
}
