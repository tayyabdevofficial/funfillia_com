<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        $term = trim((string) ($request->get('q') ?? $request->get('search') ?? ''));
        $page = (int) $request->get('page', 1);

        $data = !empty($term)
            ? $this->client->searchBlogs($term, $page)
            : $this->client->getHomeData();

        $blogs = $data['blogs']['data'] ?? ($data['blogs'] ?? ($data['recentBlogs'] ?? []));

        return view('search', [
            'searchTerm' => $term,
            'blogs' => $blogs,
            'pagination' => $data['blogs'] ?? [],
            'recentBlogs' => $data['recentBlogs'] ?? [],
            'allCategories' => $data['allCategories'] ?? [],
        ]);
    }
}
