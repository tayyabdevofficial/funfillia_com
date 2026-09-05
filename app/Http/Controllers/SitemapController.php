<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    public function index(): Response
    {
        $data = $this->client->getSitemap();
        $blogs = $data['blogs'] ?? [];
        $categories = $data['allCategories'] ?? [];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Home
        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // Categories & Subcategories
        foreach ($categories as $cat) {
            if (!empty($cat['slug'])) {
                $xml .= '<url>';
                $xml .= '<loc>' . route('category.show', $cat['slug']) . '</loc>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.8</priority>';
                $xml .= '</url>';
            }

            if (!empty($cat['sub_categories']) && is_array($cat['sub_categories'])) {
                foreach ($cat['sub_categories'] as $sub) {
                    if (!empty($sub['slug'])) {
                        $xml .= '<url>';
                        $xml .= '<loc>' . route('subcategory.show', $sub['slug']) . '</loc>';
                        $xml .= '<changefreq>weekly</changefreq>';
                        $xml .= '<priority>0.7</priority>';
                        $xml .= '</url>';
                    }
                }
            }
        }

        // Blogs
        foreach ($blogs as $blog) {
            if (!empty($blog['slug'])) {
                $lastmod = !empty($blog['updated_at']) ? date('c', strtotime($blog['updated_at'])) : date('c');
                $xml .= '<url>';
                $xml .= '<loc>' . route('blog.show', $blog['slug']) . '</loc>';
                $xml .= '<lastmod>' . $lastmod . '</lastmod>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.9</priority>';
                $xml .= '</url>';
            }
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
