@extends('frontend.layouts.master')

@section('meta')
    <!-- Add your meta tags for campgrounds here -->
    <!-- Example: -->
     <meta name="keywords" content="campground, outdoor, nature">
     <meta name="description" content="{{ $campground_detail->summary }}">
    <!-- Add other meta tags as needed -->
@endsection

@section('title', 'Campground Detail')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <!-- Add your breadcrumb code here -->
    </div>
    <!-- End Breadcrumbs -->

    <!-- Campground Single -->
    <section class="campground single section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <!-- Campground Gallery -->
                            <div class="campground-gallery">
                                <!-- Images slider -->
                                <div class="flexslider-thumbnails">
                                    <ul class="slides">
                                        @php
                                            $photo = explode(',', $campground_detail->photo);
                                        @endphp
                                        @foreach ($photo as $data)
                                            <li data-thumb="{{ $data }}" rel="adjustX:10, adjustY:">
                                                <img src="{{ $data }}" alt="{{ $data }}">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- End Images slider -->
                            </div>
                            <!-- End Campground Gallery -->
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="campground-des">
                                <!-- Description -->
                                <div class="short">
                                    <h4>{{ $campground_detail->title }}</h4>
                                            
                                    <!-- Add your campground-specific details here -->
                                    <!-- Example: -->
                                    <p class="location"><i class="ti-location-pin"></i>{{ $campground_detail->location }}</p>
                                    <p class="description">{!! ($campground_detail->summary) !!}</p>
                                </div>
                                <!--/ End Description -->

                                <!-- Campground Info -->
                                <div class="campground-info">
                                    <p class="availability">Availability: @if ($campground_detail->available) <span
                                            class="badge badge-success">Available</span> @else <span
                                            class="badge badge-danger">Not Available</span> @endif</p>
                                    <!-- Add other campground-specific info here -->
                                    <!-- Example: -->
                                    <p class="facilities">Facilities: {{ $campground_detail->facilities }}</p>
                                </div>
                                <!--/ End Campground Info -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </section>
    <!--/ End Campground Single -->

    <!-- Start Related Campgrounds -->
    <!-- <div class="campground-area related-campgrounds section"> -->
        <!-- Add your related campgrounds section here -->
        <!-- Example: -->
        <!-- <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Related Campgrounds</h2>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- End Related Campgrounds -->

    <!-- Modal -->
    <!-- Add your campground modal code here if needed -->
    <!-- Example: -->
    <!-- <div class="modal fade" id="campgroundModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Add your modal content here -->
                <!-- Example: -->
                <!-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <!-- Add your modal body content here -->
                    <!-- Example: -->
                    <!-- <h2>1</h2>
                    <p>2</p>
                </div>
            </div>
        </div>
    </div> -->
    <!--/ End Modal -->

@endsection

@push('styles')
<style>
		/* Rating */
		.rating_box {
		display: inline-flex;
		}

		.star-rating {
		font-size: 0;
		padding-left: 10px;
		padding-right: 10px;
		}

		.star-rating__wrap {
		display: inline-block;
		font-size: 1rem;
		}

		.star-rating__wrap:after {
		content: "";
		display: table;
		clear: both;
		}

		.star-rating__ico {
		float: right;
		padding-left: 2px;
		cursor: pointer;
		color: #F7941D;
		font-size: 16px;
		margin-top: 5px;
		}

		.star-rating__ico:last-child {
		padding-left: 0;
		}

		.star-rating__input {
		display: none;
		}

		.star-rating__ico:hover:before,
		.star-rating__ico:hover ~ .star-rating__ico:before,
		.star-rating__input:checked ~ .star-rating__ico:before {
		content: "\F005";
		}

	</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

@endpush
