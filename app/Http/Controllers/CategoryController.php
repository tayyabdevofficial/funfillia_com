<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    public function category(Request $request, string $slug)
    {
        $page = (int) $request->get('page', 1);
        $data = $this->client->getCategoryBlogs($slug, $page);

        if (empty($data['record'])) {
            abort(404, 'Category not found.');
        }

        $meta = $this->client->getMetaTags("category_{$slug}");

        return view('category', [
            'category' => $data['record'],
            'blogs' => $data['blogs']['data'] ?? ($data['blogs'] ?? []),
            'pagination' => $data['blogs'] ?? [],
            'recentBlogs' => $data['recentBlogs'] ?? [],
            'allCategories' => $data['allCategories'] ?? [],
            'metaTags' => $meta['metaTags'] ?? '',
            'isSubCategory' => false,
        ]);
    }

    public function subCategory(Request $request, string $slug)
    {
        $page = (int) $request->get('page', 1);
        $data = $this->client->getSubCategoryBlogs($slug, $page);

        if (empty($data['record'])) {
            abort(404, 'Subcategory not found.');
        }

        $meta = $this->client->getMetaTags("subcategory_{$slug}");

        return view('category', [
            'category' => $data['record'],
            'blogs' => $data['blogs']['data'] ?? ($data['blogs'] ?? []),
            'pagination' => $data['blogs'] ?? [],
            'recentBlogs' => $data['recentBlogs'] ?? [],
            'allCategories' => $data['allCategories'] ?? [],
            'metaTags' => $meta['metaTags'] ?? '',
            'isSubCategory' => true,
        ]);
    }
}
