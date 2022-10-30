<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostsResource;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $data = Article::where('category_id', $category->id)->paginate(5);

        return response()->json([
            'article' => PostsResource::collection($data),
            'message' => 'success'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'eror' => $validate->errors(), 'validation eror'
            ]);
        }

        $images = $request->file('image');
        if ($request->hasFile('image')) {
            $path = $images->store('public/image');

            $article = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $path,
                'user_id' => auth('api')->user()->id,
                'category_id' => $category->id
            ]);

            return response()->json([
                'data' => new PostsResource($article),
                'success' => 'success add article'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Article $post)
    {
        $query = Article::where('id', $post->id)->get();

        return response()->json([
            'data' => PostsResource::collection($query),
            'success' => 'success'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Category $category, Article $article)
    {
        $data = $request->all();
        // dd($data);
        $validate = Validator::make($data, [
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'eror' => $validate->errors(), 'validation eror'
            ]);
        }

        $images = $request->file('image');
        if ($request->hasFile('image')) {
            $path = $images->store('public/image');
        }
        // $article = Article::find($article->id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->image = $path;
        $article->user_id = auth('api')->user()->id;
        $article->category_id = $category->id;

        $article->save();

        return response()->json([
            'success' => 'article has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Article $post)
    {
        // $article = Article::find($article);

        $post->delete();

        return response()->json([
            'success' => 'article has been deleted'
        ]);
    }
}
