@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a type="button" href="{{'category/create'}}" class="btn btn-primary">Add Category</a>
            <table class="table table-striped mt-4">
                {{-- @dd($data) --}}
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Add By</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            {{-- @dd($item->users) --}}
                        <td>{{$index+1}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->users->name}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->updated_at}}</td>
                        <td>
                            <div class="inline-block">
                                <a type="button" href="{{route('category.edit', $item->id)}}" class="btn btn-success">Edit</a>
                                <form action="{{route('category.destroy', $item->id)}}" class="d-inline" method="POST">
                                    {{ csrf_field() }}
                                    {{method_field('delete')}}
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                                <a type="button" href="{{route('category.article.index',$item->id)}}" class="btn btn-warning">Article</a>
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
