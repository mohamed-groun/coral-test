<?php

namespace App\Controller;

use App\Services\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class IndexController extends AbstractController
{


    #[Route('/', name: 'app_index_movies')]
    public function index(Request $request, CallApiService $callApiService): Response
    {

        $requestData = json_decode($request->getContent(), true);
        $checkedCheckboxes = [];

        if (isset($requestData['checkedCheckboxes']) && $requestData['checkedCheckboxes']) {
            $checkedCheckboxes = $requestData['checkedCheckboxes'];


            return new JsonResponse([
                'content' => $this->renderView('index/_movies.html.twig', [
                    'movies' => $callApiService->getMovies($checkedCheckboxes),
                ])]);
        }

        if (isset($requestData['searchValue']) && $requestData['searchValue']) {
            $searchText = $requestData['searchValue'];

            return new JsonResponse([
                'content' => $this->renderView('index/_movies.html.twig', [
                    'movies' => $callApiService->getMoviesBySearch($searchText),
                ])]);
        }


        return $this->render('index/index.html.twig', [
            'movies' => $callApiService->getMovies($checkedCheckboxes),
            'genres' => $callApiService->getMoviesGender()["genres"],
        ]);
    }


}
