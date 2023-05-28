@extends('layouts.app')
@section('title')
   <h4 class="page-title">Users</h4>
@endsection

@section('content')
<div class="row align-items-center">
   <div class="col-md-6">
      <div class="mb-3">
         <h5 class="card-title">Daftar Users <span class="text-muted fw-normal ms-2">({{ $usersCount }})</span></h5>
      </div>
   </div>

   <div class="col-md-6">
      <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
         <div>
            <a href="{{ route('index') . '/api/users' }}" class="btn btn-danger"><i class="bx bx-detail me-1"></i> API </a>
            <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New</a>
         </div>
      </div>

   </div>
</div>
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-sm mb-0">

                     <thead class="table-light">
                        <tr>
                           <th>#</th>
                           <th>Name</th>
                           <th>Username</th>
                           <th>Email</th>
                           <th>Role</th>
                           <th>Data</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($users as $key => $user)
                           <tr>
                              @php
                                 $fullname = $user->name;
                                 $lastSpacePos = strrpos($fullname, ' ');
                                 if ($lastSpacePos === false) {
                                     // Jika tidak ditemukan spasi, berarti hanya ada 1 kata dalam $fullname
                                     $lastname = '';
                                 } else {
                                     $lastname = substr($fullname, $lastSpacePos + 1);
                                 }
                                 // Memotong kata terakhir dari $fullname
                                 $firstname = trim(substr($fullname, 0, $lastSpacePos));
                                 
                                 if (empty($firstname)) {
                                     $firstname = $fullname;
                                 }
                              @endphp
                              <th scope="row">{{ $key + 1 }}</th>
                              {{-- <td>{{ $firstname }}</td>
                              <td>{{ $lastname }}</td> --}}
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->username }}</td>
                              <td>{{ $user->email }}</td>
                              <td>{{ $user->role }}</td>
                              <td>
                                 <button class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target=".user-detail{{ $user->id }}">Detail</button>
                              </td>
                              {{-- <td>{{ $user->created_at->diffForHumans() }}</td> --}}
                              <td>
                                 <div class="d-flex align-items-center">
                                    {{-- <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> --}}
                                 <a class="badge rounded-pill badge-soft-primary" href="{{ route('users.show', $user) }}">
                                    <i class="bx bx bx-show font-size-16"></i>
                                    {{-- Show --}}
                                 </a>
                                 <a class="badge rounded-pill badge-soft-success" href="{{ route('users.edit', $user) }}">
                                    <i class="bx bx bx-edit font-size-16"></i>
                                 </a>
                                 <form action="{{ route('users.destroy', $user) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="badge rounded-pill badge-soft-danger border-0">
                                       <i class="bx bx bx-trash-alt font-size-16"></i>
                                    </button>
                                 </form>
                                 </div>
                              </td>
                              @push('modal')
                                 <!--  Extra Large modal example -->
                                 <div class="modal fade user-detail{{ $user->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myExtraLargeModalLabel">Post List</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- <ul>
                                                   @forelse($user->posts as $key => $post)
                                                   <li>
                                                      <a href="{{ route('posts.show', $post) }}">
                                                      {{ $post->id . ' - ' . $post->title }}
                                                      <ul>
                                                         @forelse($post->tags as $key => $tag)
                                                         <li>{{ $tag->name }}</li>
                                                         @empty
                                                         <li>'?'</li>
                                                         @endforelse
                                                      </ul>
                                                      </a>
                                                   </li>
                                                   @empty
                                                   <li>Data masih kosong!</li>
                                                   @endforelse
                                                </ul> --}}
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                              @endpush
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
