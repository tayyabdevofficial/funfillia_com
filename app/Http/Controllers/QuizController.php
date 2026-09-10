<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    protected function getCommonData(): array
    {
        $home = $this->client->getHomeData();
        return [
            'allCategories' => $home['allCategories'] ?? [],
            'trendingTopics' => $home['trendingTopics'] ?? [],
        ];
    }

    /**
     * Display all active quizzes.
     */
    public function index()
    {
        $data = $this->client->getQuizzes();

        if (isset($data['quizzes_enabled']) && !$data['quizzes_enabled']) {
            $common = $this->getCommonData();
            return response()->view('quizzes.disabled', array_merge($common, [
                'quizTitle' => 'Entertainment Quizzes',
                'message' => 'The quiz entertainment hub is currently undergoing scheduled maintenance. Please check back soon!',
                'otherQuizzes' => [],
                'siteTitle' => 'Quizzes Under Maintenance - Funfillia',
            ]), 200);
        }

        $common = $this->getCommonData();

        return view('quizzes.index', array_merge($common, [
            'quizzes' => $data['quizzes'] ?? [],
            'myCreatedDares' => array_values(session('my_created_dares', [])),
            'siteTitle' => 'Viral Fun Quizzes & Friendship Challenges - Funfillia',
            'siteDescription' => 'Create hilarious personal friendship dares, share with your besties, and discover who knows you best!',
        ]));
    }

    /**
     * Creator step: Answer quiz questions to create a personal challenge.
     */
    public function createChallenge(string $slug)
    {
        $data = $this->client->getQuizDetail($slug);

        if (!empty($data['disabled']) || (isset($data['quiz']['status']) && !$data['quiz']['status'])) {
            $common = $this->getCommonData();
            $quizzesData = $this->client->getQuizzes();
            return response()->view('quizzes.disabled', array_merge($common, [
                'quizTitle' => $data['quiz']['title'] ?? ucwords(str_replace('-', ' ', $slug)),
                'message' => 'This quiz has been paused by the admin. Don\'t worry, there are plenty of other exciting challenges to play!',
                'otherQuizzes' => $quizzesData['quizzes'] ?? [],
                'siteTitle' => 'Quiz Inactive - Funfillia',
            ]), 200);
        }

        $quiz = $data['quiz'] ?? null;

        if (!$quiz) {
            abort(404, 'Quiz not found or currently unavailable.');
        }

        $common = $this->getCommonData();

        return view('quizzes.create-challenge', array_merge($common, [
            'quiz' => $quiz,
            'siteTitle' => 'Create Challenge: ' . ($quiz['title'] ?? 'Quiz') . ' - Funfillia',
            'siteDescription' => 'Answer questions honestly, generate your unique link, and challenge your friends!',
        ]));
    }

    /**
     * Store personal challenge created by user.
     */
    public function storeChallenge(Request $request, string $slug)
    {
        $request->validate([
            'creator_name' => 'required|string|max:50',
            'creator_avatar' => 'nullable|string|max:50',
            'answers' => 'required|array|min:1',
        ]);

        $res = $this->client->createQuizChallenge($slug, [
            'creator_name' => $request->input('creator_name'),
            'creator_avatar' => $request->input('creator_avatar') ?: '😎',
            'answers' => $request->input('answers'),
        ]);

        if (empty($res['success']) || empty($res['data']['challenge']['share_token'])) {
            return back()->withInput()->with('error', $res['data']['message'] ?? 'Unable to create challenge. Please try again.');
        }

        $token = $res['data']['challenge']['share_token'];
        session(['my_challenge_' . $token => true]);

        // Keep track of all challenges created by this user in session
        $createdDares = session('my_created_dares', []);
        $createdDares[$token] = [
            'token' => $token,
            'quiz_title' => $res['data']['challenge']['quiz_title'] ?? ucwords(str_replace('-', ' ', $slug)),
            'creator_name' => $request->input('creator_name'),
            'creator_avatar' => $request->input('creator_avatar') ?: '😎',
            'created_at' => now()->format('M d, Y • g:i A'),
        ];
        session(['my_created_dares' => $createdDares]);

        return redirect()->route('quizzes.challenge.share', $token)->with('success', 'Your challenge is live! Share it with your friends below.');
    }

    /**
     * Creator share dashboard with copy link, 1-click WhatsApp share, and friend scores.
     */
    public function shareDashboard(string $token)
    {
        $res = $this->client->getQuizChallenge($token, true);

        if (!empty($res['disabled'])) {
            $common = $this->getCommonData();
            $quizzesData = $this->client->getQuizzes();
            return response()->view('quizzes.disabled', array_merge($common, [
                'quizTitle' => $res['quiz']['title'] ?? 'Friendship Challenge',
                'message' => 'This challenge is currently unavailable because the underlying quiz is paused.',
                'otherQuizzes' => $quizzesData['quizzes'] ?? [],
                'siteTitle' => 'Challenge Inactive - Funfillia',
            ]), 200);
        }

        if (empty($res['success'])) {
            abort(404, 'Quiz challenge not found.');
        }

        $common = $this->getCommonData();

        return view('quizzes.challenge-share', array_merge($common, [
            'challenge' => $res['challenge'],
            'quiz' => $res['quiz'],
            'leaderboard' => $res['leaderboard'] ?? [],
            'siteTitle' => ($res['challenge']['creator_name'] ?? 'Friend') . "'s Dare Challenge - Share & Scoreboard",
        ]));
    }

    /**
     * Friend take challenge page: Guess creator answers.
     */
    public function takeChallenge(Request $request, string $token)
    {
        // If the creator visits their own link and already has a session token, redirect to share view
        if ($request->has('share') || session('my_challenge_' . $token)) {
            return redirect()->route('quizzes.challenge.share', $token);
        }

        // If the user already submitted answers for this dare, redirect to score page
        if (session()->has('quiz_attempt_' . $token) || $request->hasCookie('quiz_attempt_' . $token)) {
            return redirect()->route('quizzes.challenge.score', $token);
        }

        $res = $this->client->getQuizChallenge($token);

        if (!empty($res['disabled'])) {
            $common = $this->getCommonData();
            $quizzesData = $this->client->getQuizzes();
            return response()->view('quizzes.disabled', array_merge($common, [
                'quizTitle' => $res['quiz']['title'] ?? 'Friendship Challenge',
                'message' => ($res['creator_name'] ?? 'Your friend') . "'s challenge is temporarily paused because this quiz has been deactivated by the admin.",
                'otherQuizzes' => $quizzesData['quizzes'] ?? [],
                'siteTitle' => 'Challenge Inactive - Funfillia',
            ]), 200);
        }

        if (empty($res['success'])) {
            abort(404, 'Quiz challenge not found.');
        }

        $common = $this->getCommonData();

        return view('quizzes.take-challenge', array_merge($common, [
            'challenge' => $res['challenge'],
            'quiz' => $res['quiz'],
            'leaderboard' => $res['leaderboard'] ?? [],
            'siteTitle' => 'How Well Do You Know ' . ($res['challenge']['creator_name'] ?? 'Your Friend') . '? - Funfillia Dare',
            'siteDescription' => 'Accept the friendship dare! Guess their answers and see how high you score.',
        ]));
    }

    /**
     * Friend submit attempt and redirect to instant match score & comparison.
     */
    public function submitAttempt(Request $request, string $token)
    {
        // Prevent re-submitting if already submitted
        if (session()->has('quiz_attempt_' . $token) || $request->hasCookie('quiz_attempt_' . $token)) {
            return redirect()->route('quizzes.challenge.score', $token)->with('info', 'You have already submitted your answers for this dare!');
        }

        $request->validate([
            'friend_name' => 'required|string|max:50',
            'answers' => 'required|array|min:1',
        ]);

        $res = $this->client->submitQuizChallengeAttempt($token, [
            'friend_name' => $request->input('friend_name'),
            'answers' => $request->input('answers'),
        ]);

        if (empty($res['success']) || empty($res['data']['result'])) {
            return back()->withInput()->with('error', $res['data']['message'] ?? 'Could not submit your answers. Please try again.');
        }

        $result = $res['data']['result'];
        session(['quiz_attempt_' . $token => $result]);

        // Queue cookie to remember submission across sessions
        cookie()->queue('quiz_attempt_' . $token, json_encode([
            'attempt_id' => $result['attempt_id'] ?? null,
            'friend_name' => $result['friend_name'] ?? '',
            'score' => $result['score'] ?? 0,
            'total_questions' => $result['total_questions'] ?? 0,
            'percentage' => $result['percentage'] ?? 0,
            'creator_name' => $result['creator_name'] ?? 'Friend',
            'creator_avatar' => $result['creator_avatar'] ?? '😎',
            'verdict' => $result['verdict'] ?? 'Dare Complete',
            'verdict_desc' => $result['verdict_desc'] ?? '',
        ]), 60 * 24 * 30);

        return redirect()->route('quizzes.challenge.score', $token);
    }

    /**
     * Display the score page for an attempt.
     */
    public function showScore(Request $request, string $token)
    {
        $result = session('quiz_attempt_' . $token);

        if (!$result && $request->hasCookie('quiz_attempt_' . $token)) {
            $cookieVal = $request->cookie('quiz_attempt_' . $token);
            $parsed = json_decode($cookieVal, true);
            if (is_array($parsed) && !empty($parsed['attempt_id'])) {
                $attemptRes = $this->client->getQuizChallengeAttempt($token, (int) $parsed['attempt_id']);
                if (!empty($attemptRes['success']) && !empty($attemptRes['result'])) {
                    $result = $attemptRes['result'];
                    session(['quiz_attempt_' . $token => $result]);
                } else {
                    $result = $parsed;
                }
            } elseif (is_array($parsed)) {
                $result = $parsed;
            }
        }

        if (!$result) {
            return redirect()->route('quizzes.challenge.take', $token);
        }

        $common = $this->getCommonData();

        return view('quizzes.challenge-result', array_merge($common, [
            'result' => $result,
            'token' => $token,
            'siteTitle' => ($result['friend_name'] ?? 'You') . ' scored ' . ($result['percentage'] ?? 0) . '% on ' . ($result['creator_name'] ?? 'Friend') . "'s Dare!",
        ]));
    }
}
