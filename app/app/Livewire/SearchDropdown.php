<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class SearchDropdown extends Component

{
    public $search = "";

    public function render()
    {

        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        $searchResults = [];
        $searchUrl = $baseUrl . '/search/multi';

        // Ensure search query is properly encoded
        $queryParams = [
            'query' => $this->search,
        ];

        $client = new \GuzzleHttp\Client();

        if (strlen($this->search)> 2) {
            try {
                // Send the request to the TMDb API
                $response = $client->request('GET', $searchUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                    'query' => $queryParams,
                ]);
    
                // Decode the response body
                $searchResults = json_decode($response->getBody(), true);
    
                //filter result and only retrieve results 
                $searchResults = $searchResults['results'];
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // Handle the error
                // You can log the error or handle it in a way that makes sense for your application
                Log::error('Error fetching TMDb search results: ' . $e->getMessage());
                $searchResults = [];
            }
        }



        return view(
            'livewire.search-dropdown',
            [
                'searchResults' => $searchResults,
            ]
        );
    }
}
