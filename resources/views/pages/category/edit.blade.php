@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="container mt-5">
                <form action="{{route('category.update', $item->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="formGroupExampleInput" class="mb-2">Category Name</label>
                      <input type="text" value="{{old('name') ?? $item->name}}" class="form-control" placeholder="input category name" name="name">
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
