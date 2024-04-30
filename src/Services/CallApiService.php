<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Helper\MovieHelper;

class CallApiService
{
    private $client;
    private $apiKey;
    private $movieHelper;

    public function __construct(HttpClientInterface $client, MovieHelper $movieHelper)
    {
        $this->client = $client;
        $this->apiKey = $_ENV['API_KEY_TMDB'];
        $this->movieHelper = $movieHelper;
    }


    public function getMovies($checkedCheckboxes): array
    {

        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/discover/movie',
            [
                'query' => [
                    'include_adult' => true,
                    'include_video' => true,
                    'language' => 'en-US',
                    'page' => 1,
                    'sort_by' => 'popularity.desc',
                    'with_genres' => $this->movieHelper->formatEntiers($checkedCheckboxes),
                    'api_key' => $this->apiKey
                ]
            ]
        );

        return $this->addYoutubeKeyToMovies($response->toArray()["results"]);
    }

    public function getMovie($id): ?string
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/' . $id . '/videos',
            [
                'query' => [
                    'api_key' => $this->apiKey
                ]
            ]
        );

        $data = $response->toArray();

        if (isset($data['results'][0]['key'])) {
            return $data['results'][0]['key'];
        } else {
            return null;
        }
    }

    public function getMoviesGender(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/genre/movie/list',
            [
                'query' => [
                    'api_key' => $this->apiKey
                ]
            ]
        );

        return $response->toArray();
    }

    public function getMoviesBySearch($searchText): array
    {

        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/search/movie',
            [
                'query' => [
                    'api_key' => $this->apiKey,
                    'query' => $searchText,
                ]
            ]
        );

        return $this->addYoutubeKeyToMovies($response->toArray()["results"]);
    }

    private function addYoutubeKeyToMovies(array $movies): array
    {
        $result = [];

        foreach ($movies as &$movie) {
            $movie['trailer_youtube_key'] = $this->getMovie($movie['id']);
            $result[] = $movie;
        }

        return $result;
    }
}