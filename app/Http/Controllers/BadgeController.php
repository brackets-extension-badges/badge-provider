<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Services\BadgeUtils;
use Illuminate\Http\JsonResponse;

class BadgeController extends Controller
{
    public function getBadge($extensionId, $method)
    {
        $extension = Extension::Find($extensionId);
        $availableMethods = [BadgeUtils::TOTAL, BadgeUtils::LAST_VERSION, BadgeUtils::WEEK, BadgeUtils::DAY];

        if (is_null($extension) || !in_array($method, $availableMethods)) {
            return $this->getUnknownBadge();
        }

        switch ($method) {
            case BadgeUtils::TOTAL:
                $downloads = $extension->totalDownloads;
                break;
            case BadgeUtils::LAST_VERSION:
                $downloads = $extension->lastVersionDownloads;
                break;
            case BadgeUtils::WEEK:
                $downloads = $extension->weekDownloads;
                break;
            case BadgeUtils::DAY:
                $downloads = $extension->weekDownloads / 7;
                break;
            default:
                $downloads = 0;
        }

        $text = BadgeUtils::formatNumber($downloads);

        $widths = [
            BadgeUtils::DOWNLOADS_WIDTH + 10,
            BadgeUtils::measureTextWidth($text) + 10 + BadgeUtils::getSuffixWidth($method)
        ];

        $text .= BadgeUtils::getSuffix($method);

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

    private function getUnknownBadge()
    {
        return response(view('unknownBadge'))->header('Content-Type', 'image/svg+xml;charset=utf-8');
    }
}
