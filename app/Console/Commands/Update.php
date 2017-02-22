<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class Update extends Command
{
    protected $signature = 'data:update';
    protected $description = 'Update the data from the registry';

    public function handle()
    {
        $updater = App::make('UpdateService');
        return $updater->update();
    }
}