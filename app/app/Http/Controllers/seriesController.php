<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class seriesController extends Controller
{
    //the index

    public function index()
    {
        //api requests for the main content
        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        // Construct the full URLs
        $popularTvshowsUrl = "{$baseUrl}/tv/popular?language=en-US&page=1";
        $nowPlayingTvshowsUrl = "{$baseUrl}/tv/on_the_air?language=en-US&page=1";
        $genreListUrl = "{$baseUrl}/genre/tv/list?language=en";

        // Create a new Guzzle client
        $client = new Client();

        try {
            $promises = [
                'popularTvshows' => $client->requestAsync('GET', $popularTvshowsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'nowPlayingShows' => $client->requestAsync('GET', $nowPlayingTvshowsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'genreList' => $client->requestAsync('GET', $genreListUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
            ];

            $responses = Utils::unwrap($promises);

            // Parse the responses
            $popularTvshows = json_decode($responses['popularTvshows']->getBody(), true);
            $nowPlayingTvshows = json_decode($responses['nowPlayingShows']->getBody(), true);
            $genreList = json_decode($responses['genreList']->getBody(), true);

            // Map genre IDs to their names
            $genreMap = [];
            foreach ($genreList['genres'] as $genre) {
                $genreMap[$genre['id']] = $genre['name'];
            }

            //check if results exist in json response
            if (!isset($popularTvshows['results']) || !isset($nowPlayingTvshows['results'])) {
                throw new \Exception('API response does not contain "results" key');
            }

            // Extract the 'results' arrays
            $popularTvshows = $popularTvshows['results'];
            $nowPlayingTvshows = $nowPlayingTvshows['results'];

            // Return the view with the movies data
            return view('TVshows.index', [
                'tvshows' => $popularTvshows,
                'nowPlayingShows' => $nowPlayingTvshows,
                'genreMap' => $genreMap,
            ]);
        } catch (\Exception $e) {
            // Log the error and return an error response
            Log::error('TMDB API Request Failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            return response()->json(['error' => 'Failed to fetch tvshows'], 500);
        }
    }

    public function serieDetails($id)
    {
        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        // Construct the full URLs
        $tvShowDetailsUrl = "{$baseUrl}/tv/{$id}?language=en-US";
        $tvShowCreditsUrl = "{$baseUrl}/tv/{$id}/credits?language=en-US";
        $tvShowImagesUrl = "{$baseUrl}/tv/{$id}/images";
        $tvShowVideoUrl = "{$baseUrl}/tv/{$id}/videos";
        $genreListUrl = "{$baseUrl}/genre/tv/list?language=en";
        $recommendationsUrl = "{$baseUrl}/tv/{$id}/recommendations?language=en-US&page=1";


        // Create a new Guzzle client
        $client = new Client();

        try {
            // Send the GET requests concurrently
            $promises = [
                'tvShowDetails' => $client->requestAsync('GET', $tvShowDetailsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'tvShowCredits' => $client->requestAsync('GET', $tvShowCreditsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'tvShowImages' => $client->requestAsync('GET', $tvShowImagesUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'recommendations' => $client->requestAsync('GET', $recommendationsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'genreList' => $client->requestAsync('GET', $genreListUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'tvShowVideos' => $client->requestAsync('GET', $tvShowVideoUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
            ];

            // Wait for the requests to complete
            $responses = Utils::unwrap($promises);

            // Parse the responses
            $tvShowDetails = json_decode($responses['tvShowDetails']->getBody(), true);
            $tvShowCredits = json_decode($responses['tvShowCredits']->getBody(), true);
            $tvShowImages = json_decode($responses['tvShowImages']->getBody(), true);
            $tvShowVideos = json_decode($responses['tvShowVideos']->getBody(), true);

            $recommendations = json_decode($responses['recommendations']->getBody(), true);
            $genreList = json_decode($responses['genreList']->getBody(), true);

            // Map genre IDs to their names
            $genreMap = [];
            foreach ($genreList['genres'] as $genre) {
                $genreMap[$genre['id']] = $genre['name'];
            }

            $tvShowImages = $tvShowImages['backdrops'];
            $tvShowVideos = $tvShowVideos['results'];
            $recommendations = $recommendations['results'];

            // Filter cast to only include cast that has acting role
            $filteredTvShowCredits = array_filter($tvShowCredits['cast'], function ($castMember) {
                return $castMember['known_for_department'] === 'Acting' && $castMember['profile_path'] !== null;
            });

            $filteredTvShowImages = array_filter($tvShowImages, function ($bestImage) {
                return $bestImage['vote_count'] >= 7 || $bestImage['vote_average'] >= 5;
            });

            //recommend based on popularity

            // Filter and sort the person credits
            $filteredRecommendations = array_filter($recommendations, function ($items) {
                return $items['media_type'] == "tv";
            });

            // Define the sorting function
            usort($filteredRecommendations, function ($a, $b) {
                // Sort by popularity in descending order
                return $b['popularity'] <=> $a['popularity'];
            });

            $tvShowCredits = $filteredTvShowCredits;
            $tvShowImages = $filteredTvShowImages;
            $recommendations = $filteredRecommendations;

            // Return the view with the TV show details and credits
            return view('tvshows.showTvShow', [
                'tvShow' => $tvShowDetails,
                'credits' => $tvShowCredits,
                'tvShowImages' => $tvShowImages,
                'tvShowVideo' => $tvShowVideos,
                'recommendations' => $recommendations,
                'genreMap' => $genreMap,
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

    //watch series

    public function watchSeries($id)
    {
        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        // Construct the full URLs
        $tvShowDetailsUrl = "{$baseUrl}/tv/{$id}?append_to_response=seasons,external_ids&language=en-US";
        $genreListUrl = "{$baseUrl}/genre/tv/list?language=en";
        $tvShowExternalsUrl = "{$baseUrl}/tv/{$id}/external_ids";
        $recommendationsUrl = "{$baseUrl}/tv/{$id}/recommendations?language=en-US&page=1";

        // Create a new Guzzle client
        $client = new Client();

        try {
            // Send the GET requests concurrently
            $promises = [
                'tvShowDetails' => $client->requestAsync('GET', $tvShowDetailsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'recommendations' => $client->requestAsync('GET', $recommendationsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'genreList' => $client->requestAsync('GET', $genreListUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'tvShowExternals' => $client->requestAsync('GET', $tvShowExternalsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
            ];

            // Wait for the requests to complete
            $responses = Utils::unwrap($promises);

            // Parse the responses
            $tvShowDetails = json_decode($responses['tvShowDetails']->getBody(), true);
            $tvShowExternals = json_decode($responses['tvShowExternals']->getBody(), true);
            $recommendations = json_decode($responses['recommendations']->getBody(), true);
            $genreList = json_decode($responses['genreList']->getBody(), true);

            // Map genre IDs to their names
            $genreMap = [];
            foreach ($genreList['genres'] as $genre) {
                $genreMap[$genre['id']] = $genre['name'];
            }

            $recommendations = $recommendations['results'];

            // Sort recommendations by popularity
            usort($recommendations, function ($a, $b) {
                return $b['popularity'] <=> $a['popularity'];
            });

            // Fetch episodes for each season
            foreach ($tvShowDetails['seasons'] as &$season) {
                $seasonNumber = $season['season_number'];
                $episodesUrl = "{$baseUrl}/tv/{$id}/season/{$seasonNumber}?language=en-US";
                $seasonResponse = $client->get($episodesUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]);
                $seasonDetails = json_decode($seasonResponse->getBody(), true);
                $season['episodes'] = $seasonDetails['episodes'];
            }

            // Return the view with the TV show details and credits
            return view('tvshows.watchShow', [
                'tvShow' => $tvShowDetails,
                'externals' => $tvShowExternals,
                'recommendations' => $recommendations,
                'genreMap' => $genreMap,
            ]);

        } catch (RequestException $e) {
            // Log the error and return an error response
            Log::error('TMDB API Request Failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

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
