@extends('layouts.app')
@section('title')
   <h4 class="page-title">Post</h4>
@endsection

@section('content')
   {{-- @php
      dd($users);
   @endphp --}}
   <div id="app"></div>
   <div class="row align-items-center">
      <div class="col-md-6">
         <div class="mb-3">
            <h5 class="card-title">Daftar Post <span class="text-muted fw-normal ms-2">({{ $postsCount }})</span></h5>
         </div>
      </div>

      <div class="col-md-6">
         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
            <div>
               <a href="{{ route('index') . '/api/posts' }}" class="btn btn-danger"><i class="bx bx-detail me-1"></i> API </a>
               <a href="{{ route('posts.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New</a>
            </div>
         </div>

      </div>
   </div>
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-body">
               <select id='userid' class="form-control mb-3" style="width: 200px" name="user_id">
                  <option value="0" selected>--Select User--</option>
                  @foreach ($users as $user)
                     <option value="{{ $user->id }}">{{ $user->id . ' - ' . $user->name }}</option>
                  @endforeach
               </select>
               <div class="table-responsive">
                  <table class="table table-sm mb-0" id="posts-table">

                     <thead class="table-light">
                        <tr>
                           <th>#</th>
                           <th>Title</th>
                           <th>Slug</th>
                           {{-- <th>
                              UserID
                           </th> --}}
                           <th>Action</th>
                        </tr>
                     </thead>
                     {{-- <tbody>
                        @foreach ($posts as $key => $post)
                           <tr>
                              <th scope="row">{{ $key + 1 }}</th>
                              <td><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></td>
                              <td>{{ $post->slug }}</td>
                              <td>
                                 <a class="badge rounded-pill badge-soft-success" href="{{ route('posts.edit', $post) }}">
                                    <i class="bx bx bx-edit font-size-16"></i>
                                 </a>
                                 <form action="{{ route('posts.destroy', $post) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="badge rounded-pill badge-soft-danger border-0" onclick="return confirm('Are you sure?')">
                                       <i class="bx bx bx-trash-alt font-size-16"></i>
                                    </button>
                                 </form>
                              </td>
                           </tr>
                        @endforeach
                     </tbody> --}}
                     <tbody></tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@push('scripts')
   <script src="{{ asset('assets/libs/waves/waves.min.js') }}"></script>
   <script>
      $(function() {
         var table = $('#posts-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('posts.ajax') }}",
            stateSave: true,
            // data: function(d) {
            //    d.userid = $('#userid').val(),
            //       // d.search = $('input[type="search"]').val()
            // }
            columns: [{
                  data: 'DT_RowIndex',
                  name: 'DT_RowIndex'
               },
               {
                  data: 'title',
                  name: 'title'
               },
               {
                  data: 'slug',
                  name: 'slug'
               },
               // {
               //    data: 'userid',
               //    name: 'userid'
               // },
               {
                  data: 'action',
                  name: 'action',
                  orderable: true,
                  searchable: true
               },
            ]
         });
         // $('#userid').change(function() {
         //    table.draw();
         // });
      });
      $.fn.dataTable.ext.errMode = 'throw';
   </script>
@endpush
@push('head')
   <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.css" rel="stylesheet" />
   <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
@endpush
