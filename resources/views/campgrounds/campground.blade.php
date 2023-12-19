@extends('frontend.layouts.master')

@section('title','E-SHOP || PRODUCT PAGE')

@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">Shop Grid</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
 <!-- Product Style -->
 
   
        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                                <!-- Single Widget -->
                                <div class="single-widget category">
                                    <h3 class="title">Categories</h3>
                                    <ul class="categor-list">
										
										<li>
											
														<li><a href="">11</a>
															<ul>
																
																	<li><a href="">10</a></li>
																
															</ul>
														</li>
												
														<li><a href="">9</a></li>
													
										</li>
										
												<li><a href="">8</a></li>
											
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
                          <div class="col-12">
						    <div class="form-group button">
                                <a  href="{{route('campground.create-campground')}}"  class="btn">Add Campground</a>
												
											</div>
										</div>
       @foreach($campgrounds as $campgrounds)
     <div class="card mb-3">
           <div class="row g-0 bg-body-secondary position-relative">
           <a href="{{route('campground-detail',$campgrounds->slug)}}" class="stretched-link"></a>
               <div class="col-md-6 mb-md-0 p-md-4">
               
    
                                        @php
                                            $photo = explode(',', $campgrounds->photo);
                                        @endphp
                              <img src="{{ $photo[0] }}" class="w-100 rounded" alt="{{ $campgrounds->photo }}">
                                                   
                  
               </div>
               <div class="col-md-6 p-4 ps-md-0">
               <h5 class="card-title">
               {{ $campgrounds->title }}
                               </h5>
                               <p class="card-text">
                               {{ $campgrounds->description }}
                               </p>
                               <p class="card-text">
                                   <small class="text-muted">
                                   {{ $campgrounds->location }}
                                   </small>
                               </p>      
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
@endpush
