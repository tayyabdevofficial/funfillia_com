<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    public function show(Request $request, string $slug)
    {
        $data = $this->client->getBlog($slug);

        if (empty($data['blog'])) {
            abort(404, 'Blog article not found.');
        }

        $blog = $data['blog'];

        // Generate Math Security Captcha
        $num1 = rand(3, 9);
        $num2 = rand(1, 8);
        session(['comment_captcha' => $num1 + $num2]);

        return view('blog-detail', [
            'blog' => $blog,
            'previousBlog' => $data['previousBlog'] ?? null,
            'nextBlog' => $data['nextBlog'] ?? null,
            'relatedBlogs' => $data['relatedBlogs'] ?? [],
            'recentBlogs' => $data['recentBlogs'] ?? [],
            'allCategories' => $data['allCategories'] ?? [],
            'seoData' => $data['seoData'] ?? ($blog['seo_data'] ?? []),
            'views' => $data['views'] ?? 0,
            'captchaQuestion' => "{$num1} + {$num2}",
        ]);
    }

    public function random(Request $request)
    {
        $homeData = $this->client->getHomeData();
        $candidates = [];

        foreach (['latestBlogs', 'featuredBlogs', 'trendingBlogs', 'todayTopBlogs'] as $key) {
            if (!empty($homeData[$key]) && is_array($homeData[$key])) {
                $candidates = array_merge($candidates, $homeData[$key]);
            }
        }

        $validSlugs = collect($candidates)->pluck('slug')->filter()->unique()->values();

        if ($validSlugs->isNotEmpty()) {
            return redirect()->route('blog.show', $validSlugs->random());
        }

        return redirect()->route('home');
    }

    public function comment(Request $request, string $slug)
    {
        $request->validate([
            'blog_id' => 'required',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'required|string|max:3000',
            'captcha' => 'required|numeric',
        ]);

        $expectedCaptcha = session('comment_captcha');
        if ((int)$request->input('captcha') !== (int)$expectedCaptcha) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect security captcha answer. Please calculate the math problem correctly.',
                ], 422);
            }
            return back()->withInput()->with('error', 'Incorrect security captcha answer.');
        }

        // Regenerate captcha for next attempt
        session()->forget('comment_captcha');

        $res = $this->client->submitComment($request->only(['blog_id', 'full_name', 'email', 'description']));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => $res['success'] ?? false,
                'message' => $res['data']['message'] ?? ($res['success'] ? 'Your comment has been submitted successfully!' : 'Failed to submit comment.'),
                'comment' => [
                    'full_name' => $request->input('full_name'),
                    'description' => $request->input('description'),
                    'created_at' => now()->toIso8601String(),
                ],
            ], $res['status'] ?? 200);
        }

        if ($res['success'] ?? false) {
            return back()->with('success', 'Your comment has been submitted successfully!');
        }

        return back()->withInput()->with('error', $res['data']['message'] ?? 'Failed to submit comment. Please try again.');
    }
}
