<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Services\MeasureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class BadgeController extends Controller
{
    public function __construct()
    {
        //
    }

    public function getBadge($extensionId, $method)
    {
        $extension = Extension::Find($extensionId);
        if (is_null($extension)) {
            //TODO return 'unknown' badge
        }

        $measurer = App::make('MeasureService');

        $text = '123';
        $widths = [
            MeasureService::DOWNLOADS_WIDTH + 10,
            $measurer->measureTextWidth($text) + 10
        ];

        //TODO compute width
        return response(view('badge')->with(['text' => $text, 'widths' => $widths]))->header('Content-Type', 'image/svg+xml;charset=utf-8');
    }

    public function getStats($extensionId)
    {
        $extension = Extension::Find($extensionId);
        if (is_null($extension)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Unknown extension: ' . $extensionId,
            ]);
        }
        return new JsonResponse([
            'name' => $extension->id,
            'total' => $extension->totalDownloads,
            'lastVersion' => $extension->lastVersionDownloads,
            'week' => $extension->weekDownloads,
        ]);
    }
    //
}
