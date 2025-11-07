<?php

namespace App\Services;

use App\Contracts\Services\AuthInterface;
use Illuminate\Support\Facades\Http;

class GoogleAuthService
{
    const AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';

    const TOKEN_URL = 'https://oauth2.googleapis.com/token';

    const USER_INFO_URL = 'https://www.googleapis.com/oauth2/v3/userinfo';

    /**
     * Factory method redirect to Auth URL
     *
     * @return string URL auth
     */
    public function getOAuthUrl(string $state)
    {
        return self::AUTH_URL .
            '?client_id=' . env('GOOGLE_CLIENT_ID') .
            '&redirect_uri=' . env('GOOGLE_REDIRECT_URI') .
            '&response_type=code' .
            '&prompt=select_account consent' .
            '&scope=openid email profile' .
            '&access_type=offline' .
            '&state=' . $state;
    }

    /**
     * Factory method used to get authentication token in Google.
     *
     * @param string $code is obtained by parsing the parameters returned from Google Service.
     * @return string response access_token
     */
    public function getAccessToken(string $code)
    {
        $response = Http::asForm()->post(self::TOKEN_URL, [
            'code' => $code,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'grant_type' => 'authorization_code',
        ]);

        return $response['access_token'];
    }

    /**
     * Factory method gets user information from Google Service's GraphQL.
     *
     * @param string $accessToken Get from the function above.
     * @return string json user infor
     */
    public function getUserInfo(string $accessToken)
    {
        return Http::withToken($accessToken)
            ->get(self::USER_INFO_URL)
            ->json();
    }
}
