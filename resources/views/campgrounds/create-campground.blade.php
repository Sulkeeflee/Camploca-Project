@extends('frontend.layouts.master')

@section('title','E-SHOP || PRODUCT PAGE')

@section('main-content')
<section class="product-area shop-sidebar shop section">
<div class="container mt-5">
    <h2>Create Campground</h2>
    <form>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter the location" required>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Choose Images</label>
            <input type="file" class="form-control" id="images" name="images" accept="image/*" multiple required>
            <small class="form-text text-muted">Select one or more images.</small>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Select Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="mountain">Mountain</option>
                <option value="beach">Beach</option>
                <option value="forest">Forest</option>
                <!-- Add more categories as needed -->
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter a brief description" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</section>

@endsection
@push('styles')
<style>
    .pagination{
        display:inline-flex;
    }
    .filter_button{
        /* height:20px; */
        text-align: center;
        background:#F7941D;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
   
@endpush
