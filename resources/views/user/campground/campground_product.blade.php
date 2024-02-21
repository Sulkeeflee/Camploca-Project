@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
<div class="card">
    <h5 class="card-header">Add Product To Campground Cart</h5>
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

<form method="POST" action="{{ route('campground.product.store') }}">
    @csrf

    <div class="form-group">
          <label for="campground">Campground <span class="text-danger">*</span></label>
          <select name="campground_id" id="campground" class="form-control">
              <option value="">--Select any campground--</option>
             
              @foreach($campgrounds as $campground)
              
                <option value="{{ $campground->id }}">{{ $campground->title }}</option>
                
            @endforeach
             
          </select>
        </div>
    
    <div class="form-group">
    <label for="products">Product <span class="text-danger">*</span></label>
    <select name="products[]" id="products" class="form-control selectpicker" multiple>
       
    @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->title }}</option>
            @endforeach
    </select>
</div>


    <button type="submit" class="btn btn-primary">Add Products to Campground</button>
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
