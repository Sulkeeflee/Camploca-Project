@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Campground</h5>
    <div class="card-body">
        <form method="post" action="{{ route('campground.update', $campground->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ $campground->title }}" class="form-control">
              
            </div>

            <div class="form-group">
                <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
                <textarea class="form-control" id="summary" name="summary">{{ $campground->summary }}</textarea>
               
            </div>

            <div class="form-group">
                <label for="description" class="col-form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ $campground->description }}</textarea>
              
            </div>

            <div class="form-group">
                <label for="location" class="col-form-label">Location <span class="text-danger">*</span></label>
                <input id="location" type="text" name="location" placeholder="Enter location" value="{{ $campground->location }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="lat" class="col-form-label">Latitude (lat) <span class="text-danger">*</span></label>
                <input id="lat" type="text" name="lat" placeholder="Enter latitude" value="{{ $campground->lat }}" class="form-control">
                @error('lat')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="lng" class="col-form-label">Longitude (lng) <span class="text-danger">*</span></label>
                <input id="lng" type="text" name="lng" placeholder="Enter longitude" value="{{ $campground->lng }}" class="form-control">
                @error('lng')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="is_featured">Is Featured</label><br>
                <input type="checkbox" name='is_featured' id='is_featured' value='1' {{ $campground->is_featured ? 'checked' : '' }}> Yes
            </div>

            <div class="form-group">
                <label for="cat_id">Category <span class="text-danger">*</span></label>
                <select name="cat_id" id="cat_id" class="form-control">
                    <option value="">--Select any category--</option>
                    @foreach($categories as $category)
                    <option value='{{ $category->id }}' {{ $campground->cat_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group d-none" id="child_cat_div">
                <label for="child_cat_id">Sub Category</label>
                <select name="child_cat_id" id="child_cat_id" class="form-control">
                    <option value="">--Select any sub category--</option>
                </select>
            </div>


         <div class="form-group">
          <label for="condition">Condition</label>
          <select name="condition" class="form-control">
              <option value="">--Select Condition--</option>
              <option value="default" {{(($campground->condition=='default')? 'selected':'')}}>Default</option>
              <option value="new" {{(($campground->condition=='new')? 'selected':'')}}>New</option>
              <option value="hot" {{(($campground->condition=='hot')? 'selected':'')}}>Hot</option>
          </select>
        </div>
            <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                  <i class="fas fa-image"></i> Choose
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$campground->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
         
        </div>
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($campground->status=='active')? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($campground->status=='inactive')? 'selected' : '')}}>Inactive</option>
        </select>
        
        </div>

            <div class="form-group mb-3">
                <button class="btn btn-success" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
        $('#summary').summernote({
            placeholder: "Write short description.....",
            tabsize: 2,
            height: 150
        });
    });

    $(document).ready(function() {
        $('#description').summernote({
            placeholder: "Write detail Description.....",
            tabsize: 2,
            height: 150
        });
    });

    var child_cat_id = '{{ $campground->child_cat_id }}';

    $('#cat_id').change(function() {
        var cat_id = $(this).val();

        if (cat_id != null) {
            $.ajax({
                url: "/admin/category/" + cat_id + "/child",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (typeof(response) != 'object') {
                        response = $.parseJSON(response);
                    }

                    var html_option = "<option value=''>--Select any one--</option>";

                    if (response.status) {
                        var data = response.data;

                        if (response.data) {
                            $('#child_cat_div').removeClass('d-none');
                            $.each(data, function(id, title) {
                                html_option += "<option value='" + id + "' " + (child_cat_id == id ? 'selected ' : '') + ">" + title + "</option>";
                            });
                        } else {
                            console.log('no response data');
                        }
                    } else {
                        $('#child_cat_div').addClass('d-none');
                    }

                    $('#child_cat_id').html(html_option);
                }
            });
        } else {

        }
    });

    if (child_cat_id != null) {
        $('#cat_id').change();
    }
</script>
@endpush
