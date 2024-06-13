<x-app-web-layout>
    <x-slot:title>
   Users
</x-slot>

@include('role-permission.nav-links')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
              <div class="alert alert-success">{{session('status')}}</div>
            @endif
            <div class="card mt-3">
                <div class="card-header">
                    <h4>User
                        <a href="{{url('users/create')}}" class="btn btn-primary float-end">Add User</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $rolename)
                                            <label class="badge bg-primary">{{$rolename}}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @can('update user')
                                       <a class="btn btn-info btn-sm mx-2" href="{{url('users/'.$user->id.'/edit')}}">Edit</a>
                                    @endcan
                                    @can('delete user')
                                       <a class="btn btn-danger btn-sm mx-2"
                                       {{-- onclick="if (confirm('Are you sure you want to delete this item?')) { alert('Item deleted.'); } else { alert('Deletion canceled.'); }" --}}
                                       href="{{url('users/'.$user->id.'/delete')}}">Delete</a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


</x-app-web-layout>
