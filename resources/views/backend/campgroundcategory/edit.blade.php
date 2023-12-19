@extends('backend.layouts.master')

@section('main-content')
 
<div class="card">
    <h5 class="card-header">Edit Campground Category</h5>
    <div class="card-body">
    <form method="post" action="{{route('campground-category.update',$campgroundCategory->id)}}">
            @csrf
            @method('PATCH')
            <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title</label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$campgroundCategory->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

            <div class="form-group">
          <label for="status" class="col-form-label">Status</label>
          <select name="status" class="form-control">
            <option value="active" {{(($campgroundCategory->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($campgroundCategory->status=='inactive') ? 'selected' : '')}}>Inactive</option>
          </select>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
