<?php

namespace App\Services;

use App\Models\ZohoApi;
use GuzzleHttp\Client;
use DateTime;
use DateInterval;

class ZohoApiService
{
    /**
     * @var string
     */
    private $accountApiUrl;

    /**
     * @var string
     */
    private $crmApiUrl;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $scope;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var ZohoApi
     */
    private $apiConfig;

    /**
     * Construct Zoho API service
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $config = config('zoho');

        $this->accountApiUrl = $config['accountApiUrl'];
        $this->crmApiUrl = $config['crmApiUrl'];
        $this->clientId = $config['clientId'];
        $this->clientSecret = $config['clientSecret'];
        $this->scope = $config['scope'];
        $this->redirectUri = $config['redirectUri'];

        $this->client = $client;
    }

    /**
     * Get code url
     *
     * @return string
     */
    public function getCodeUrl(): string
    {
        $params = [
            'client_id'     => $this->clientId,
            'scope'         => $this->scope,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'access_type'   => 'offline',
        ];

        return $this->getAccountApiUrl('auth', $params);
    }

    /**
     * Generate token
     *
     * @param string $code
     */
    public function generateToken(string $code): void
    {
        $params = [
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'grant_type'    => 'authorization_code',
        ];

        $tokenUrl = $this->getAccountApiUrl('token', $params);

        $response = $this->client->post($tokenUrl);
        $responseData = json_decode($response->getBody(), true);

        if ($message = $responseData['error'] ?? false) {
            dd('Error: ' . $message);
        }

        $expires = new DateTime();
        $expiresInterval = new DateInterval('PT' . $responseData['expires_in_sec'] . 'S');
        $expires->add($expiresInterval);

        ZohoApi::create([
            'access_token'  => $responseData['access_token'],
            'refresh_token' => $responseData['refresh_token'] ?? null,
            'expires'       => $expires->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Create deal
     *
     * @param array $dealData
     */
    public function dealCreate(array $dealData): void
    {
        $this->client->post($this->getApiUrl('Deals'), [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $this->getAccessToken(),
            ],
            'body' => json_encode([
                'data' => [
                    $dealData,
                ],
            ]),
        ]);
    }

    /**
     * Create task
     *
     * @param array $taskData
     */
    public function taskCreate(array $taskData): void
    {
        $taskData['$se_module'] = 'Deals';

        $this->client->post($this->getApiUrl('Tasks'), [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $this->getAccessToken(),
            ],
            'body' => json_encode([
                'data' => [
                    $taskData,
                ],
            ]),
        ]);
    }

    /**
     * Get url to account API
     *
     * @param  string $url
     * @param  array  $params
     * @return string
     */
    private function getAccountApiUrl(string $url, array $params = []): string
    {
        $uri = $this->accountApiUrl . $url;

        return $uri . '?' . http_build_query($params);
    }

    /**
     * Get url to API
     *
     * @param  string $url
     * @param  array  $params
     * @return string
     */
    private function getApiUrl(string $url, array $params = []): string
    {
        $uri = $this->crmApiUrl . $url;

        return $uri . '?' . http_build_query($params);
    }

    /**
     * Get access token
     *
     * @return string
     */
    private function getAccessToken(): string
    {
        if (null === $this->apiConfig) {
            $this->apiConfig = ZohoApi::first();
        }

        return $this->apiConfig->access_token;
    }
}
