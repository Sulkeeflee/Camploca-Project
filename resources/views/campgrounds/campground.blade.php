@extends('frontend.layouts.master')

@section('title','CAMPLOCA || PRODUCT PAGE')

@section('main-content')
	<!-- Breadcrumbs -->
         <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">Campground Grid</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
   
 <!-- Product Style -->
 
   
        <section class="product-area shop-sidebar shop section">
             <!-- Map -->
    
    <div class="container">

<div id="map" class="mb-4" style="width: 100%; height: 400px;"></div>

<h1 class="display-6 text-center mb-4">Search and View Our Campgrounds</h1>

<div class="header shop">
                <div class="search-bar-top">
                    <div class="search-bar">
                       
                        <form method="POST" action="{{route('campground.search')}}">
                            @csrf
                            <input name="search" placeholder="Search Campgrounds Here....." type="search">
                            <button class="btnn" type="submit"><i class="ti-search"></i></button>
                        </form>
                    </div>
                </div>
</div>
</div>

<!-- End Map -->
<br><br>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                                <!-- Single Widget -->
                                <div class="single-widget category">
                                    <h3 class="title">Add New Campground</h3>
                                    <div class="form-group button">
                                <a  href="{{route('campground-front.create')}}"  class="btn">Add Campground</a>
												
					 						</div>
                                </div>
                                <!--/ End Single Widget -->
                             <!-- Single Widget -->
                             <div class="single-widget category">
                                    <h3 class="title">Categories</h3>
                                    <ul class="categor-list">
										@php
											// $CampgroundCategory = new Category();
											$menu=App\Models\CampgroundCategory::getAllParentWithChild();
										@endphp
										@if($menu)
										<li>
											@foreach($menu as $cat_info)
													@if($cat_info->child_cat->count()>0)
														<li><a href="{{route('campground-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
															<ul>
																@foreach($cat_info->child_cat as $sub_menu)
																	<li><a href="{{route('campground-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
																@endforeach
															</ul>
														</li>
													@else
														<li><a href="{{route('campground-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
													@endif
											@endforeach
										</li>
										@endif
                                        {{-- @foreach(Helper::campgroundtCategoryList('campgrounds') as $cat)
                                            @if($cat->is_parent==1)
												<li><a href="{{route('campground-cat',$cat->slug)}}">{{$cat->title}}</a></li>
											@endif
                                        @endforeach --}}
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                             
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12"> 
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
                                                <option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
                                                <option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
                                                <option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sort By :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>Name</option>
                                                <option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Price</option>
                                                <option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category') selected @endif>Category</option>
                                                <option value="brand" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand') selected @endif>Brand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href=""><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                    
                                </div>
                                
                                <!--/ End Shop Top -->
                            </div>
                        </div>

                        
                        
                        <div class="row">
                        <div class="single-product">
                          

                                        @foreach($campgrounds as $campgrounds)                              
   <div class="card mb-3" >
  <div class="row g-0">
  <a href="{{route('campground-detail',$campgrounds->slug)}}" class="stretched-link"></a>
    <div class="col-md-6 mb-md-0 p-md-4">
    @php
                                            $photo = explode(',', $campgrounds->photo);
                                        @endphp
                              <img src="{{ $photo[0] }}" class="w-100 rounded" alt="{{ $campgrounds->photo }}">
    </div>
    <div class="col-md-6 p-4 ps-md-0">
      <div class="card-body">
        <h5 class="card-title">{{ $campgrounds->title }}</h5>
        
       
    <p class="location"><i class="ti-location-pin"></i>{{ $campgrounds->location }}</p>
        
        <br>
        <p class="card-text">{!! ($campgrounds->summary) !!}</p>
        <br>
        <p class="card-text">
                                           <span class="text-muted">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                 {{$campgrounds->author_info->name ?? 'Anonymous'}}
                                            </span>
            <small class="float-right">{{$campgrounds->created_at->format('d M , Y. D')}}</small>
        
    </p>
      </div>
    </div>
    </a>
  </div>
</div>
@endforeach 
             
                          </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    <!--/ End Product Style 1  -->


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
                    else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }

            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

     
      
       
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9,
            center: {lat: 6.389836, lng: 101.369304},
            scrollwheel: false
        });

        <!-- Assuming you have already initialized your Google Map instance -->
<!-- For example: -->
<!-- var map = new google.maps.Map(document.getElementById('map'), { options }); -->

@foreach($campground as $campgrounds)
    @if(isset($campgrounds->lat) && isset($campgrounds->lng))
        var lat = {{ $campgrounds->lat }};
        var lng = {{ $campgrounds->lng }};
        var center = { lat: lat, lng: lng };
        var contentString = `
            <strong>{{ $campgrounds->title }}<br />
            {{ $campgrounds->location }}</strong>
        `;

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: center,
            map: map,  // Assuming you already have a Google Map instance named 'map'
            title: "{{ $campgrounds->title }}"
        });

        // Attach click event listener to show info window when marker is clicked
        attachClickEvent(marker, infowindow);
    @endif
@endforeach

// Function to attach click event listener
function attachClickEvent(marker, infowindow) {
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
}

    }
</script>
                 
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJGrSPlebBrnf1GTiZUkgD9pslRBgerq0&callback=initMap"></script>


@endpush
