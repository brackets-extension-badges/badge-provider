<?php

namespace App\Services;

use App\Extension;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UpdateService
{
    const URL = 'https://brackets-registry.aboutweb.com/registryList';

    public function update()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this::URL,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json'
            ]
        ));

        $results = json_decode(curl_exec($curl));
        if ($results === false) {
            abort(500, 'Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
        curl_close($curl);

        if (!isset($results->registry)) {
            abort(500, 'Invalid registry response');
        }

        $weekDays = $this->getWeekDays();
        $list = [];

        foreach ($results->registry as $result) {

            $extension = Extension::firstOrNew(['id' => $result->metadata->name]);

            if (isset($result->totalDownloads)) {
                $extension->totalDownloads = $result->totalDownloads;
                $list[$result->metadata->name] = $result->totalDownloads;
            }

            if (isset($result->versions) && sizeof($result->versions) > 0 && isset(array_last($result->versions)->downloads)) {
                $extension->lastVersionDownloads = array_last($result->versions)->downloads;
            }

            if (isset($result->recent)) {
                $extension->weekDownloads = $this->getWeekDownloads($result->recent, $weekDays);
            }

            $extension->save();
        }

        $ok = Storage::put('list.json', json_encode($list));
        if ($ok !== true) {
            abort(500, 'Cannot write extension list on disk');
        }

        return new JsonResponse(['status' => 'ok', 'extensions' => sizeof($results->registry)]);
    }

    private function getWeekDownloads($recent, $weekDays)
    {
        $count = 0;
        foreach ($weekDays as $index) {
            if (isset($recent->{$index})) {
                $count += $recent->{$index};
            }
        }
        return $count;
    }

    private function getWeekDays()
    {
        $date = new \DateTime();
        $weekDays = [];

        foreach (range(1, 7) as $x) {
            $weekDays[] = $date->format('Ymd');
            $date = $date->sub(new \DateInterval('P1D'));
        }

        return $weekDays;
    }
}