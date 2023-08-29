<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SearchController extends Controller
{
    public function albums(Request $request, Response $response)
    {
        //json will be returned as asociated array (flag true)
        $albums = json_decode(file_get_contents(__DIR__ . '/../../data/albums.json'), true);

        return $this->render($response, 'albums.html', ['albums' => $albums]);
    }

    //uses GET request 
    public function search(Request $request, Response $response)
    {
        $albums = json_decode(file_get_contents(__DIR__ . '/../../data/albums.json'), true);

        $query = $request->getQueryParam('q');

        if ($query) {
            $albums = array_values(array_filter($albums, function ($album) use ($query) {
                return strpos($album['title'], $query) !== false || strpos($album['artist'], $query) !== false;
            }));
        }

        return $this->render($response, 'search.html', ['albums' => $albums, 'query' => $query]);
    }

    //uses POST request
    public function form(Request $request, Response $response)
    {
        $albums = json_decode(file_get_contents(__DIR__ . '/../../data/albums.json'), true);

        //different method for POST request, PSR standard
        $query = $request->getParam('q');

        if ($query) {
            $albums = array_values(array_filter($albums, function ($album) use ($query) {
                return strpos($album['title'], $query) !== false || strpos($album['artist'], $query) !== false;
            }));
        }

        return $this->render($response, 'form.html', ['albums' => $albums, 'query' => $query]);
    }
}
