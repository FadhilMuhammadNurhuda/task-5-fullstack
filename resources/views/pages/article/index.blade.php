@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <a type="button" href="{{'article/create'}}" class="btn btn-primary">Add Article</a>
            <table class="table table-striped mt-4">
              {{-- @dd($data) --}}
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Upload by</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $index => $item)
                    <tr>
                      <td>{{$index + 1}}</td>
                      <td>{{$item->title}}</td>
                      <td>{{$item->categories->name}}</td>
                      <td>{{$item->users->name}}</td>
                      <td>{{$item->created_at}}</td>
                      <td>
                        <div class="inline-block">
                          <a type="button" href="{{route('category.article.edit', ['category'=>$item->categories->id ,'article' => $item->id])}}" class="btn btn-success">Edit</a>
                          <form action="{{route('category.article.destroy', ['category'=>$item->categories->id ,'article' => $item->id])}}" class="d-inline" method="POST">
                              {{ csrf_field() }}
                              {{method_field('delete')}}
                              <button class="btn btn-danger">Delete</button>
                          </form>
                      </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection
