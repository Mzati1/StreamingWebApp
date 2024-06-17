<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Utils;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;
use Monolog\Handler\BrowserConsoleHandler;
use App\View\Components\movieImageSnapshot;

use Illuminate\Database\Console\DumpCommand;

class MovieController extends Controller
{
    public function index()
    {
        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        // Construct the full URLs
        $popularMoviesUrl = "{$baseUrl}/movie/popular";
        $nowPlayingMoviesUrl = "{$baseUrl}/movie/now_playing?language=en-US&page=1";
        $genreListUrl = "{$baseUrl}/genre/movie/list?language=en";

        // Create a new Guzzle client
        $client = new Client();

        try {
            // Send the GET requests concurrently
            $promises = [
                'popularMovies' => $client->requestAsync('GET', $popularMoviesUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'nowPlayingMovies' => $client->requestAsync('GET', $nowPlayingMoviesUrl, [
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

            // Wait for the requests to complete
            $responses = Utils::unwrap($promises);

            // Parse the responses
            $popularMoviesResponse = json_decode($responses['popularMovies']->getBody(), true);
            $nowPlayingMoviesResponse = json_decode($responses['nowPlayingMovies']->getBody(), true);
            $genreList = json_decode($responses['genreList']->getBody(), true);

            // Map genre IDs to their names
            $genreMap = [];
            foreach ($genreList['genres'] as $genre) {
                $genreMap[$genre['id']] = $genre['name'];
            }

            // Check if the 'results' key exists in the responses
            if (!isset($popularMoviesResponse['results']) || !isset($nowPlayingMoviesResponse['results'])) {
                throw new \Exception('API response does not contain "results" key');
            }

            // Extract the 'results' arrays
            $popularMovies = $popularMoviesResponse['results'];
            $nowPlayingMovies = $nowPlayingMoviesResponse['results'];


            // Return the view with the movies data and genre map
            return view('movies.welcome', [
                'movies' => $popularMovies,
                'nowPlayingMovies' => $nowPlayingMovies,
                'genreMap' => $genreMap,
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

            abort(500, 'Failed to fetch Movies');
        }
    }

    //end 


    public function movieDetails($id)
    {
        // Fetch the base URL and token from the config
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $token = config('services.tmdb.token');

        // Construct the full URLs
        $movieDetailsUrl = "{$baseUrl}/movie/{$id}?language=en-US&append_to_response=video";
        $movieCreditsUrl = "{$baseUrl}/movie/{$id}/credits?language=en-US";
        $movieImagesUrl = "{$baseUrl}/movie/{$id}/images";
        $movieVideosUrl = "{$baseUrl}/movie/{$id}/videos?language=en-US";
        $genreListUrl = "{$baseUrl}/genre/movie/list?language=en";
        $recommendationsUrl = "{$baseUrl}/movie/{$id}/recommendations?language=en-US&page=1";

        // Create a new Guzzle client
        $client = new Client();

        try {
            // Send the GET requests concurrently
            $promises = [
                'movieDetails' => $client->requestAsync('GET', $movieDetailsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'movieCredits' => $client->requestAsync('GET', $movieCreditsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'movieImages' => $client->requestAsync('GET', $movieImagesUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]),
                'movieVideos' => $client->requestAsync('GET', $movieVideosUrl, [
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
            ];

            // Wait for the requests to complete
            $responses = Utils::unwrap($promises);

            // Parse the responses
            $movieDetails = json_decode($responses['movieDetails']->getBody(), true);
            $movieCredits = json_decode($responses['movieCredits']->getBody(), true);
            $movieImages = json_decode($responses['movieImages']->getBody(), true);
            $movieVideos = json_decode($responses['movieVideos']->getBody(), true);

            $recommendations = json_decode($responses['recommendations']->getBody(), true);
            $genreList = json_decode($responses['genreList']->getBody(), true);

            // Map genre IDs to their names
            $genreMap = [];
            foreach ($genreList['genres'] as $genre) {
                $genreMap[$genre['id']] = $genre['name'];
            }

            // Extract necessary data
            $movieCredits = $movieCredits['cast'];
            $movieImages = $movieImages['backdrops'];
            $movieVideos = $movieVideos['results'];
            $recommendations = $recommendations['results'];

            // Filter movie credits and images
            $filteredMovieCredits = array_filter($movieCredits, function ($castMember) {
                return $castMember['known_for_department'] === 'Acting' && $castMember['profile_path'] !== null;
            });

            $filteredMovieImages = array_filter($movieImages, function ($bestImage) {
                return $bestImage['vote_count'] >= 1 || $bestImage['vote_average'] >= 5;
            });

            $filteredMovieVideos = array_filter($movieVideos, function ($trailers) {
                return $trailers['type'] == "Trailer" && $trailers['name'] == "Official Trailer";
            });


            //recommend based on popularity

            // Filter and sort the person credits
            $filteredRecommendations = array_filter($recommendations, function ($items) {
                return $items['media_type'] == "movie";
            });

            // Define the sorting function
            usort($filteredRecommendations, function ($a, $b) {
                // Sort by popularity in descending order
                return $b['popularity'] <=> $a['popularity'];
            });

            $movieCredits = $filteredMovieCredits;
            $movieImages = $filteredMovieImages;
            $recommendations = $filteredRecommendations;


            // Return the view with the movie details, credits, images, and videos
            return view('movies.showMovie', [
                'movie' => $movieDetails,
                'credits' => $movieCredits,
                'movieImages' => $movieImages,
                'movieVideos' => $filteredMovieVideos,
                'recommendations' => $recommendations,
                'genreMap' => $genreMap,
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

            abort(500, 'Failed to fetch Movies');
        }
    }
}
