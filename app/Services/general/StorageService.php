<?php

namespace App\Services\general;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StorageService
{
    protected String $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.storage.base_url');
    }

    public function storeFile($file,$folder='general')
    {
        Log::info("base url");
        Log::info($this->baseUrl);
        $response = $this->getHttpInstance()
            ->attach('file', file_get_contents($file), $file->getClientOriginalName())
            ->post($this->baseUrl.'/store', [
                'name' => 'file',
                'service' => config('service_setting.service_name'),
                'path' => config('service_setting.service_name') . '/'.$folder,
                'filename' => pathinfo($file)['basename'],
            ]);

        Log::info("storage response");
        Log::info($response);
        if ($response->status() == 200)
        {
            Log::info($response->body());
            return (json_decode($response->body())->data->path);
        }
        return null;

    }

    public function getFileUrl($path)
    {
        $response = $this->getHttpInstance()
            ->get($this->baseUrl.'/get?path='.$path);
        if ($response->status() == 200)
            return (json_decode($response->body())->data->path);
        return null;
    }

    public function deleteFile($path)
    {
        $response = $this->getHttpInstance()
            ->get($this->baseUrl.'/get?path='.$path);
        if ($response->status() == 200)
            return true;
        return null;
    }

    protected function getHttpInstance()
    {
        $headers = [
            'Auth-User-Id' => app('auth_id'),
            'Service-Secret' => config('services.storage.secret'),
            'Accept-Language' => 'en',
            'Accept' => 'application/json',
        ];

        Log::info("headers is", $headers);

        return Http::withHeaders($headers);
    }
}


