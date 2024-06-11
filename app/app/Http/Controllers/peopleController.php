<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class peopleController extends Controller
{
    public function index()
    {
        //api requests for the main content
        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        // Construct the full URLs
        $popularPeopleUrl = "{$baseUrl}/person/popular?language=en-US&page=1";
        $trendingPeopleUrl = "{$baseUrl}/trending/person/week?language=en-US";

        // Create a new Guzzle client
        $client = new Client();

        try {

            $promises = [
                'popularPeople' => $client->requestAsync('GET', $popularPeopleUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'trendingPeople' => $client->requestAsync('GET', $trendingPeopleUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
            ];

            $responses = Utils::unwrap($promises);

            // Parse the responses
            $popularPeople = json_decode($responses['popularPeople']->getBody(), true);
            $trendingPeople = json_decode($responses['trendingPeople']->getBody(), true);

            //filter and get results only 
            $popularPeople = $popularPeople['results'];
            $trendingPeople = $trendingPeople['results'];

            //to get only actors 
            $filteredPopularPeople = array_filter($popularPeople, function ($people) {
                return $people['known_for_department'] == "Acting";
            });

            $filteredTrendingPeople = array_filter($trendingPeople, function ($people) {
                return $people['known_for_department'] == "Acting";
            });

            $popularPeople = $filteredPopularPeople;
            $trendingPeople = $filteredTrendingPeople;

            // Return the view with the movies data
            return view('people.index', [
                'popularPeople' => $popularPeople,
                'trendingPeople' => $trendingPeople,
            ]);
        } catch (RequestException $e) {
            // Check for a timeout
            if ($e->getCode() == 504 || $e->getHandlerContext()['errno'] == 28) {
                Log::error('TMDB API Request Timed Out', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
                abort(504, 'The request timed out. Please try again later.');
            }

            // Log the error and return a 500 error response for other exceptions
            Log::error('TMDB API Request Failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            abort(500, 'Failed to fetch People');
        } catch (\Exception $e) {
            // Log the error and return a 500 error response for any other exceptions
            Log::error('TMDB API Request Failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            abort(500, 'Failed to fetch People');
        }
    }


    public function showPerson($id)
    {
        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        // Construct the full URLs
        $personDetailsUrl = "{$baseUrl}/person/{$id}?append_to_response=images&language=en-US";
        $personExternalIdUrl = "{$baseUrl}/person/{$id}/external_ids";
        $personCreditsUrl = "{$baseUrl}/person/{$id}/combined_credits?language=en-US";
        $movieCredits = "{$baseUrl}/person/{$id}/movie_credits?language=en-US";

        // Create a new Guzzle client
        $client = new Client();

        try {
            $promises = [
                'personDetails' => $client->requestAsync('GET', $personDetailsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'personExternalId' => $client->requestAsync('GET', $personExternalIdUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'personCredits' => $client->requestAsync('GET', $personCreditsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'movieCredits' => $client->requestAsync('GET', $movieCredits, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
            ];

            $responses = Utils::unwrap($promises);
            // Parse the responses
            $personCredits = json_decode($responses['personCredits']->getBody(), true);
            $personDetails = json_decode($responses['personDetails']->getBody(), true);
            $personExternalId = json_decode($responses['personExternalId']->getBody(), true);
            $movieCredits = json_decode($responses['movieCredits']->getBody(), true);

            $personCredits = $personCredits['cast'];
            $movieCredits = $movieCredits['cast'];

            // Filter and sort the person credits
            $filteredCredits = array_filter($personCredits, function ($items) {
                return isset($items['order']) && $items['order'] === 0 && $items['poster_path'] !== null;
            });

            usort($filteredCredits, function ($a, $b) {
                // Sort by popularity in descending order
                return $b['popularity'] <=> $a['popularity'];
            });

            usort($movieCredits, function ($a, $b) {
                // Sort by popularity in descending order
                return $b['release_date'] <=> $a['release_date'];
            });

            // Output the sorted and filtered results
            return view('people.showPeople', [
                'person' => $personDetails,
                'personExternalIds' => $personExternalId,
                'credits' => $personCredits,
                'knownForArray' => $filteredCredits,
                'movies' => $movieCredits,
            ]);
        } catch (RequestException $e) {
            // Log the error and return an error response
            Log::error('TMDB API Request Failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            // Check if the exception has a response
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $errorBody = json_decode($response->getBody(), true);

                Log::error('TMDB API Error Response', [
                    'status_code' => $statusCode,
                    'error' => $errorBody,
                ]);
            }

            return response()->json(['error' => 'Failed to fetch TV show details'], 500);
        }
    }
}
