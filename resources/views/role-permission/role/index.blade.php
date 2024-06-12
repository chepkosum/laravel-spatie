<x-app-web-layout>
    <x-slot:title>
   Roles
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
                    <h4>Role
                        <a href="{{url('roles/create')}}" class="btn btn-primary float-end">Add Role</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{url('roles/'.$role->id.'/give-permissions')}}">
                                        Add / Edit Role Permission</a>

                                    <a class="btn btn-info btn-sm" href="{{url('roles/'.$role->id.'/edit')}}">Edit</a>
                                    <a class="btn btn-danger btn-sm mx-2"
                                    {{-- onclick="if (confirm('Are you sure you want to delete this item?')) { alert('Item deleted.'); } else { alert('Deletion canceled.'); }" --}}
                                    href="{{url('roles/'.$role->id.'/delete')}}">Delete</a>
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
