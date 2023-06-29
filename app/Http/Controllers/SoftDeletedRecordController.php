<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoftDeletedRecordController extends Controller
{
    public function index()
    {
        $deletedArticles = Article::when(request()->has('show') == "trash", fn ($query) => $query->onlyTrashed())
            ->latest("id")
            ->paginate(7)->withQueryString();

        // return $deletedArticles;

        return view('article.soft-delete-record', compact('deletedArticles'));
    }

    public function show($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        return  view('article.show', compact('article'));
    }


    public function restore($id)
    {

        if (request()->has("restore") == "true") {
            Article::withTrashed()->findOrFail($id)->restore();
        }

        return back();
    }

    public function restoreAll()
    {

        Article::onlyTrashed()->restore();

        return redirect()->route('article.index')->with('message', 'deleted articles is restored');
    }






    public function forceDelete($id)
    {

        $deleted_article = Article::withTrashed()->findOrFail($id);
        // return $deleted_article;

        $deleted_article->forceDelete();
        return redirect()->back();
    }
}
