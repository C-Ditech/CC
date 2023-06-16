<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Article;
use App\Models\History;

class HomeController extends Controller
{
    public function signOut(Request $request): Response
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response([
            'message' => 'Anda telah logout'
        ], 200);
    }

    public function showArticles(Request $request): Response
    {
        $articles = Article::all();
        return response([
            'data' => $articles
        ], 200);
    }

    public function createArticle(Request $request): Response
    {
        $article = Article::create($request->all());
        return response($article, 201);
    }

    public function showHistory(Request $request): Response
    {
        $user = $request->user();

        return response($user->histories, 200);
    }

    public function checkDisease(Request $request): Response
    {
        return response(null, 200);
    }
}
