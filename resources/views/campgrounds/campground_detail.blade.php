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
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="">Campground Details</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
				
		<!-- Shop Single -->
		<section class="shop single section">
					<div class="container">

   
  <div id="map"></div>

						<div class="row"> 
							<div class="col-12">
								<div class="row">
								<div class="col-lg-6 col-12">
										<!-- Product Slider -->
										<div class="product-gallery">
											<!-- Images slider -->
											<div class="flexslider-thumbnails">
												<ul class="slides">
													@php 
														$photo=explode(',',$campground_detail->photo);
													// dd($photo);
													@endphp
													@foreach($photo as $data)
														<li data-thumb="{{$data}}" rel="adjustX:10, adjustY:">
															<img src="{{$data}}" alt="{{$data}}">
														</li>
													@endforeach
												</ul>
											</div>										
											<!-- End Images slider -->
									
    <!-- Button trigger modal -->
	
	
	<a href="" data-toggle="modal" data-target="#myModal" class="single-icon">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-svg" fill="orange" width="30" height="30">
        <path d="M12 2c3.236 0 5.892 2.59 6 5.816V9h3c1.105 0 2 .895 2 2v9c0 1.105-.895 2-2 2H3c-1.105 0-2-.895-2-2v-9c0-1.105.895-2 2-2h3V7.816C6.108 4.59 8.764 2 12 2zm0 2c-2.757 0-5 2.243-5 5v1h10V9c0-2.757-2.243-5-5-5zm-7 7h14c.552 0 1 .448 1 1v9c0 .552-.448 1-1 1H5c-.552 0-1-.448-1-1v-9c0-.552.448-1 1-1zm9 3a2 2 0 0 1 0 4 2 2 0 0 1 0-4z"/>
    </svg><p class="description">สินค้า</p>
</a>

 
	
								
										</div>
										<!-- End Product slider -->
									</div>
									<div class="col-lg-6 col-12">
										<div class="product-des">
											<!-- Description -->
											<div class="short">
												
												<h4>{{$campground_detail->title}}</h4>
												<div class="rating-main">
													<ul class="rating">
														@php
															$rate=ceil($campground_detail->getReview->avg('rate'))
														@endphp
															@for($i=1; $i<=5; $i++)
																@if($rate>=$i)
																	<li><i class="fa fa-star"></i></li>
																@else 
																	<li><i class="fa fa-star-o"></i></li>
																@endif
															@endfor
													</ul>
													<a href="#" class="total-review">({{$campground_detail['getReview']->count()}}) Review</a>
                                                </div>
												<br>
												<span class="float">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                 {{$campground_detail->author_info->name ?? 'Anonymous'}}
                                            </span>
												
												<p class="date">{{$campground_detail->created_at->format('d M , Y. D')}}</p>
												<br>
												<p class="location"><i class="ti-location-pin"></i>{{ $campground_detail->location }}</p>
												
                                             
												<p class="description">{!!($campground_detail->summary)!!}</p>
												
											</div>
											<!--/ End Description -->
											
											
											
										</div>
									</div>
								</div>
								
 

                                <!-- <div class="mt-3">
								
                <div class="btn-group" role="group" aria-label="Button group with Edit and Delete buttons">
                    <a href="{{ route('campground-front.edit', $campground_detail->id) }}" class="btn btn-lg ws-btn wow fadeInUpBig ">Edit</a>

                    <form method="POST" action="{{ route('campground-front.destroy', [$campground_detail->id]) }}">
                        @csrf
                        @method('delete')
                        <button type="submit" onclick="return confirm('Are You Sure it Delete this')"
                            class="btn btn-lg ws-btn wow fadeInUpBig " data-id="{{ $campground_detail->id }}" data-toggle="tooltip"
                            data-placement="bottom" title="Delete">Delete</button>
                    </form>
                </div>
            </div> --> 

			 
                                
								<div class="row">
									<div class="col-12">
										<div class="product-info">
											<div class="nav-main">
												<!-- Tab Nav -->
												<ul class="nav nav-tabs" id="myTab" role="tablist">
													<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a></li>
													<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews</a></li>
												</ul>
												<!--/ End Tab Nav -->
											</div>
											<div class="tab-content" id="myTabContent">
												<!-- Description Tab -->
												<div class="tab-pane fade show active" id="description" role="tabpanel">
													<div class="tab-single">
							  							<div class="row">
															<div class="col-12">
																<div class="single-des">
																	<p>{!! ($campground_detail->description) !!}</p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--/ End Description Tab -->
												<!-- Reviews Tab -->
												<div class="tab-pane fade" id="reviews" role="tabpanel">
													<div class="tab-single review-panel">
														<div class="row">
															<div class="col-12">
																
																<!-- Review -->
																<div class="comment-review">
																	<div class="add-review">
																		<h5>Add A Review</h5>
																		<p>Your email address will not be published. Required fields are marked</p>
																	</div>
																	<h4>Your Rating <span class="text-danger">*</span></h4>
																	<div class="review-inner">
																			<!-- Form -->
																@auth
																<form class="form" method="post" action="{{route('campground-review.store',$campground_detail->slug)}}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="rating_box">
                                                                                  <div class="star-rating">
                                                                                    <div class="star-rating__wrap">
                                                                                      <input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1">
																					  <label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 out of 5 stars"></label>
																					  @error('rate')
																						<span class="text-danger">{{$message}}</span>
																					  @enderror
                                                                                    </div>
                                                                                  </div>
                                                                            </div>
                                                                        </div>
																		<div class="col-lg-12 col-12">
																			<div class="form-group">
																				<label>Write a review</label>
																				<textarea name="review" rows="6" placeholder="" ></textarea>
																			</div>
																		</div>
																		<div class="col-lg-12 col-12">
																			<div class="form-group button5">	
																				<button type="submit" class="btn">Submit</button>
																			</div>
																		</div>
																	</div>
																</form>
																@else 
																<p class="text-center p-5">
																	You need to <a href="{{route('login.form')}}" style="color:rgb(54, 54, 204)">Login</a> OR <a style="color:blue" href="{{route('register.form')}}">Register</a>

																</p>
																<!--/ End Form -->
																@endauth
																	</div>
																</div>
															
																<div class="ratting-main">
																	<div class="avg-ratting">
																		{{-- @php 
																			$rate=0;
																			foreach($campground_detail->rate as $key=>$rate){
																				$rate +=$rate
																			}
																		@endphp --}}
																		<h4>{{ceil($campground_detail->getReview->avg('rate'))}} <span>(Overall)</span></h4>
																		<span>Based on {{$campground_detail->getReview->count()}} Comments</span>
																	</div>
																	@foreach($campground_detail['getReview'] as $data)
																	<!-- Single Rating -->
																	<div class="single-rating">
																		<div class="rating-author">
																			@if($data->user_info['photo'])
																			<img src="{{$data->user_info['photo']}}" alt="{{$data->user_info['photo']}}">
																			@else 
																			<img src="{{asset('backend/img/avatar.png')}}" alt="Profile.jpg">
																			@endif
																		</div>
																		<div class="rating-des">
																			<h6>{{$data->user_info['name']}}</h6>
																			<div class="ratings">

																				<ul class="rating">
																					@for($i=1; $i<=5; $i++)
																						@if($data->rate>=$i)
																							<li><i class="fa fa-star"></i></li>
																						@else 
																							<li><i class="fa fa-star-o"></i></li>
																						@endif
																					@endfor
																				</ul>
																				<div class="rate-count">(<span>{{$data->rate}}</span>)</div>
																			</div>
																			<p>{{$data->review}}</p>
																		</div>
																	</div>
																	<!--/ End Single Rating -->
																	@endforeach
																</div>
																
																<!--/ End Review -->
																
															</div>
														</div>
													</div>
												</div>
												<!--/ End Reviews Tab -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</section>
		<!--/ End Shop Single -->


@endsection
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Link Products</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
    <div class="container">
        <div class="row">
            <table class="table shopping-summery">
                <thead>
                    <tr class="main-heading">
                        <th>PRODUCT</th>
                        <th>NAME</th>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campground_detail->products as $product)
                    <tr>
                        @php
                        $photo = explode(',', $product->photo);
                        @endphp
                        <td class="image" data-title="No">
                            <a href="{{ route('product-detail', $product->slug) }}">
                                <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}">
                            </a>
                        </td>
                        <td class="product-des" data-title="Description">
                            <p class="product-name">
                                <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                            </p>
                        </td>
                        <td class="total-amount" data-title="Total">
                            <span>
                                @php
                                $after_discount = ($product->price - (($product->price * $product->discount) / 100));
                                @endphp
                                <p class="price mb-3">
                                    <span class="discount me-2">฿{{ number_format($after_discount, 2) }}</span>
                                    <s class="text-muted">฿{{ number_format($product->price, 2) }}</s>
                                </p>
                            </span>
                        </td>
                        <td class="action" data-title="Remove">
						<a href="#" onclick="event.preventDefault(); document.getElementById('delete-product-form').submit();">
    <i class="ti-trash remove-icon"></i>
</a>
<form id="delete-product-form" action="{{ route('campground.product.delete', ['campground' => $campground_detail->id, 'product' => $product->id]) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue Shopping</button>
        <button type="button" class="btn btn-primary">Checkout</button>
      </div> -->
    </div>
  </div>
</div>



				

@push('styles')
    <style>
        /* Additional styles can be added here */
        /* Rating styles */
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
		/* Google Maps */
#map {
    height: 400px;
   
}
    </style>
@endpush

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- Additional scripts can be added here -->
	<script>
        // Paste the provided JavaScript code here
        function initMap() {
            var lat = {{ $campground_detail->lat }};
            var lng = {{ $campground_detail->lng }};
            var center = {
                lat: lat,
                lng: lng
            };
            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: center,
                scrollwheel: false
            });
            var title = "{{ $campground_detail->title }}";
            var contentString = "<h3>" + title + "</h3><p>{{ $campground_detail->location }}</p>";
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            var marker = new google.maps.Marker({
                position: center,
                map: map
            });
            marker.addListener("click", function() {
                infowindow.open(map, marker);
            });
        }
    </script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJGrSPlebBrnf1GTiZUkgD9pslRBgerq0&callback=initMap" 
    onError="handleMapError"></script>


@endpush
 