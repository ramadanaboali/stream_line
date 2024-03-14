<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GatewayController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function handleRequest(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
//        $request->request->add(['auth_id' => Auth::id()]);

        $path = $request->path();
        $method = $request->method();
        $url=explode('/',$path);
        Log::info('url => '.$path.' method => '.$method);
        if(count($url) > 2 && array_key_exists($url[2],config('microservices'))) {
            $base_url=config('microservices.'.$url[2].'.base_uri');
            $service_secret=config('microservices.'.$url[2].'.secret');
            Log::info($base_url  . $request->getRequestUri());
            Log::info('request payload is' ,$request->all());
            $request->header('Service-Secret',$service_secret);
            $headers=[
                'Service-Secret' => $service_secret,
                'Accept-Language' => $request->header('Accept-Language','en'),
                'Accept' => $request->header('Accept','application/json'),
                'Auth-User-Id' =>Auth::id()
            ];
            $request_service = Http::withHeaders($headers);
             foreach($request->allFiles() as $key=>$value){
                 $file = $request->file($key);
                 $filename = $file->getClientOriginalName();
                 $request_service =$request_service->attach($key, file_get_contents($file->getRealPath()),$filename);
                 $request->request->remove($key);
             }
//             dd($request->all());
               $response = $request_service->$method($base_url  . $request->getRequestUri(), $request->all());
            return response($response->body(), $response->status());
        }


        // Handle other requests or return an error response
        return $this->errorResponse('Invalid endpoint', 404);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
