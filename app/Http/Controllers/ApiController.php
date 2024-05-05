<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    private string $token;

    public function __construct()
    {
        $this->token = self::getToken();
    }

    public function getAlbums(Request $request)
    {
        $response = Http::withToken($this->token)
            ->get('https://api.spotify.com/v1/search?q=' . $request->q . '&type=album')
            ->json();
        $items = $response['albums']['items'];

        return ApiResource::collection($items);
    }

    private static function getToken(): string
    {
        if (Cache::has('token')) {
            return Cache::get('token');
        }

        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'client_id' => config('services.spotify.client_id'),
            'client_secret' => config('services.spotify.client_secret'),
            'grant_type' => 'client_credentials',
        ]);

        if (!$response->ok()) {
            throw new \Exception('Could not get credentials from api spotify.');
        }

        $body = $response->object();
        Cache::add('token', $body->access_token, $body->expires_in);

        return $body->access_token;
    }
}
