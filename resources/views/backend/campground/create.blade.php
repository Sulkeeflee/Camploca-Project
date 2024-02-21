@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Campground</h5>
    <div class="card-body">
          @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form method="post" action="{{ route('campground.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ old('title') }}" class="form-control">
                @error('title')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
                <textarea class="form-control" id="summary" name="summary">{{ old('summary') }}</textarea>
                @error('summary')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="col-form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            
            <div class="form-group">
                <label for="location" class="col-form-label">Location <span class="text-danger">*</span></label>
                <input id="location" type="text" name="location" placeholder="Enter location" value="{{ old('location') }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="lat" class="col-form-label">Latitude (lat) <span class="text-danger">*</span></label>
                <input id="lat" type="text" name="lat" placeholder="Enter latitude"  class="form-control" pattern="\d+(\.\d{6})?" title="Must have 10-6 decimal places">
                @error('lat')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="lng" class="col-form-label">Longitude (lng) <span class="text-danger">*</span></label>
                <input id="lng" type="text" name="lng" placeholder="Enter longitude"  class="form-control" pattern="\d+(\.\d{6})?" title="Must have 10-6 decimal places">
                @error('lng')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_featured">Is Featured</label><br>
                <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
            </div>

            <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group d-none" id="child_cat_div">
          <label for="child_cat_id">Sub Category</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Select any category--</option>
              {{-- @foreach($parent_cats as $key=>$parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
              @endforeach --}}
          </select>
        </div>

       

            <div class="form-group">
                <label for="condition">Condition</label>
                <select name="condition" class="form-control">
                    <option value="">--Select Condition--</option>
                    <option value="default">Default</option>
                    <option value="new">New</option>
                    <option value="hot">Hot</option>
                </select>
            </div>

          

            <div class="form-group">
                <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ old('photo') }}">
                </div>
                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                @error('photo')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
        $('#summary').summernote({
            placeholder: "Write short description.....",
            tabsize: 2,
            height: 100
        });
    });

    $(document).ready(function() {
        $('#description').summernote({
            placeholder: "Write detail description.....",
            tabsize: 2,
            height: 150
        });
    });
    // $('select').selectpicker();

</script>


<script>
$('#cat_id').change(function() {
    var cat_id = $(this).val();
    if (cat_id != '') {
        $.ajax({
            url: "/admin/category/" + cat_id + "/child",
            data: {
                _token: "{{ csrf_token() }}",
                id: cat_id
            },
            type: "POST",
            success: function(response) {
                try {
                    response = JSON.parse(response); // Parse the response as JSON
                    var html_option = "<option value=''>----Select sub category----</option>";
                    if (response.status) {
                        var data = response.data;
                        if (data) {
                            $('#child_cat_div').removeClass('d-none');
                            $.each(data, function(id, title) {
                                html_option += "<option value='" + id + "'>" + title + "</option>";
                            });
                        }
                    } else {
                        $('#child_cat_div').addClass('d-none');
                    }
                    $('#child_cat_id').html(html_option);
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
            }
        });
    } else {
        // Handle the case when no category is selected
        $('#child_cat_div').addClass('d-none');
        $('#child_cat_id').html("<option value=''>----Select sub category----</option>");
    }
});

</script>
@endpush
