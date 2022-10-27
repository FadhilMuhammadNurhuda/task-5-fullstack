@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="container mt-5">
                <form action="{{route('category.article.update', ['category'=>$category->id ,'article' => $article->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="formGroupExampleInput" class="mb-2">Title</label>
                      <input type="text" value="{{old('title') ?? $article->title}}" class="form-control" placeholder="Title" name="title">
                    </div>
                    <div class="form-group mt-3">
                        <label for="exampleFormControlTextarea1">Content</label>
                        <textarea class="form-control" name="content" rows="3">{{old('content') ?? $article->content}}</textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="formGroupExampleInput" class="mb-2">Image</label>
                        <input type="file" class="form-control" name="image">

                        <img src="{{Storage::url($article->image)}}" class="img-fluid mt-3" alt="Responsive image" height="400px">
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
