<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $res = $this->client->submitSubscriber($validated['email']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($res['data'], $res['status'] ?? 200);
        }

        $msg = $res['data']['message'] ?? 'Thank you for subscribing to Funfillia newsletter!';
        return back()->with('newsletter_success', $msg);
    }
}
