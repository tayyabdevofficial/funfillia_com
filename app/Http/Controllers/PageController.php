<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    protected function getStaticPageData(string $pageName): array
    {
        $home = $this->client->getHomeData();
        $meta = $this->client->getMetaTags($pageName);

        return [
            'allCategories' => $home['allCategories'] ?? [],
            'trendingTopics' => $home['trendingTopics'] ?? [],
            'metaTags' => $meta['metaTags'] ?? '',
        ];
    }

    public function about()
    {
        return view('pages.about', $this->getStaticPageData('about_us'));
    }

    public function contact()
    {
        $num1 = rand(3, 9);
        $num2 = rand(1, 8);
        session(['contact_captcha' => $num1 + $num2]);

        $data = $this->getStaticPageData('contact_us');
        $data['captchaQuestion'] = "{$num1} + {$num2}";

        return view('pages.contact', $data);
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'captcha' => 'required|numeric',
        ]);

        $expectedCaptcha = session('contact_captcha');
        if ((int)$request->input('captcha') !== (int)$expectedCaptcha) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect security captcha answer. Please calculate the problem correctly.',
                ], 422);
            }
            return back()->withErrors(['captcha' => 'Incorrect security answer.'])->withInput();
        }

        $res = $this->client->submitContactMessage([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        $isSuccess = ($res['success'] ?? false) || (($res['status'] ?? 500) === 200);
        $message = $res['data']['message'] ?? ($isSuccess
            ? 'Thank you for reaching out! Your message has been received and our team will get back to you shortly.'
            : 'Unable to deliver message at this time. Please try again later.');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => $isSuccess,
                'message' => $message,
            ], $isSuccess ? 200 : ($res['status'] ?? 500));
        }

        if ($isSuccess) {
            return back()->with('success', $message);
        }

        return back()->withErrors(['error' => $message])->withInput();
    }

    public function privacy()
    {
        return view('pages.privacy', $this->getStaticPageData('privacy_policy'));
    }

    public function terms()
    {
        return view('pages.terms', $this->getStaticPageData('terms_and_conditions'));
    }

    public function cookies()
    {
        return view('pages.cookies', $this->getStaticPageData('cookie_policy'));
    }
}
