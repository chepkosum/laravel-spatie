<x-app-web-layout>
    <x-slot:title>
   Permissions
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
                    <h4>Permission
                        <a href="{{url('permissions/create')}}" class="btn btn-primary float-end">Add Permission</a>
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
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
                                <td>
                                    @can('update permission')
                                       <a class="btn btn-info btn-sm" href="{{url('permissions/'.$permission->id.'/edit')}}">Edit</a>
                                    @endcan
                                    @can('delete permission')
                                    <a class="btn btn-danger btn-sm mx-2"
                                         {{-- onclick="if (confirm('Are you sure you want to delete this item?')) { alert('Item deleted.'); } else { alert('Deletion canceled.'); }" --}}
                                         href="{{url('permissions/'.$permission->id.'/delete')}}">Delete</a>
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
