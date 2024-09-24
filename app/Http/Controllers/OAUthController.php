<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OAUthController extends Controller
{
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => config('services.oauth.server.client_id'),
            'redirect_url' => config('services.oauth.server.redirect_url'),
            'response_type' => 'code'
        ]);

        return redirect(config('services.oauth.server.base_url'). '/oauth/authorize?'. $query);
    }

    public function callback(Request $request){

        $code = $request->query('code');
        $response = Http::post(config('services.oauth_server.base_url') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.oauth_server.client_id'),
            'client_secret' => config('services.oauth_server.client_secret'),
            'redirect_uri' => config('services.oauth_server.redirect_url'),  
            'code' => $code,
        ]);
        
        $data = $response->json();


        session(['access_token' => $data['access_token']]);
        return redirect('/home');
    }
}
