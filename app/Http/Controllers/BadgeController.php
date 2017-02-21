<?php

namespace App\Http\Controllers;

use App\Extension;
use Illuminate\Http\JsonResponse;

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

        //TODO compute width
        return response(view('badge')->with(['text' => $extensionId, 'width' => 1]))->header('Content-Type', 'image/svg+xml;charset=utf-8');
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
