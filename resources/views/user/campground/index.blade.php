@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
     <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Campground Lists</h6>
        <a href="{{ route('campground-front.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Campground"><i class="fas fa-plus"></i> Add Campground</a>
    </div>
    <div class="card-body"> 
        <div class="table-responsive">
            @if(count($campgrounds) > 0) 
                <table class="table table-bordered" id="campground-dataTable" width="100%" cellspacing="0">
                    <!-- Table headers and footers -->
                    <thead>
            <tr>
              <th>S.N.</th>
              <th>Title</th>
              <th>Summary</th>
              <th>Description</th>
              <th>Location</th>
              <th>Category</th>
              <th>Is Featured</th>
              <th>Condition</th>
              <th>Photo</th>
              <th>Status</th> 
              <th>Action</th>
            </tr>
          </thead>

                    <tbody>
                        @foreach($campgrounds as $campground)
                            <tr>
                                <td>{{ $campground->id }}</td>
                                <td>{{ $campground->title }}</td>
                                <td class="description">{!! ($campground->summary) !!}</td>
                                <td class="description">{!! ($campground->description) !!}</td>
                                <td>{{ $campground->location }}</td>
                                <td>{{ $campground->category->title ?? '' }}</td>
                                <td>{{ $campground->is_featured ? 'Yes' : 'No' }}</td>
                                <td>{{ $campground->condition }}</td>
                                <td>
                                    @if($campground->photo)
                                        @php
                                            $photo = explode(',', $campground->photo);
                                        @endphp
                                        <img src="{{ $photo[0] }}" class="img-fluid zoom" style="max-width: 80px" alt="{{ $campground->photo }}">
                                    @else
                                        <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid" style="max-width: 80px" alt="default-image.png">
                                    @endif
                                </td>
                                <td>
                                    @if($campground->status == 'active')
                                        <span class="badge badge-success">{{ $campground->status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $campground->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('campground-front.edit', $campground->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height: 30px; width: 30px; border-radius: 50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{route('user.campground.delete',[$campground->id])}}">
                                    @csrf
                                    @method('delete')
                                      <button class="btn btn-danger btn-sm dltBtn" data-id="{{$campground->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <span style="float:right">{{ $campgrounds->links() }}</span>
            @else
                <h6 class="text-center">No Campgrounds found!!! Please create Campground</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: none;
    }

    .zoom {
        transition: transform .2s; /* Animation */
    }

    .zoom:hover {
        transform: scale(5);
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    $('#campground-dataTable').DataTable({
        "scrollX": false,
        "columnDefs": [
            {
                "orderable": false,
                "targets": [11, 12]
            }
        ]
    });

    // Sweet alert

    function deleteData(id) {

    }

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function (e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
        })
    })
</script>
@endpush
