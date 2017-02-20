<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Laravel\Lumen\Routing\Controller as BaseController;

class DataController extends BaseController
{
    const URL = 'https://brackets-registry.aboutweb.com/registryList';

    public function update($secret)
    {
        if ($secret != env('UPDATE_SECRET')) {
            abort(403);
        }

        $updater = App::make('UpdateService');
        return $updater->update();
    }
}
