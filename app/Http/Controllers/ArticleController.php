<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        // dd($category);
        $data = Article::where('category_id', $category->id)->get();

        return view('pages.article.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        // dd($category);
        return view('pages.article.create', ['item' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        // dd($request);
        $images = $request->file('image');
        if ($request->hasFile('image')) {
            $path = $images->store('public/image');

            Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $path,
                'user_id' => Auth::id(),
                'category_id' => $category->id
            ]);

            // dd($data);
        }

        return redirect()->route('category.article.index', $category->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Article $article)
    {
        // dd($article);
        return view('pages.article.edit', ['category' => $category, 'article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, Article $article)
    {
        $data = $request->all();
        // dd($data);
        $images = $request->file('image');
        if ($request->hasFile('image')) {
            $path = $images->store('public/image');

            $article->title = $request->title;
            $article->content = $request->content;
            $article->image = $path;
            $article->user_id = Auth::id();
            $article->category_id = $category->id;

            $article->save();
        }

        return redirect()->route('category.article.index', ['category' => $category->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Article $article)
    {
        $article->delete();

        return redirect()->route('category.article.index', ['category' => $category->id]);
    }
}
