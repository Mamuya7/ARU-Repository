@extends('layouts.admin')

@section('content')

<div class="col-xl-12">
    <div class="card  shadow">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="mb-0">Roles</h2>
                </div>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table card-table text-nowrap">
                    <tr class="border-bottom">
                        <th>Number</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Action</th>
                        <th>Action</th>
                    </tr>

                    @foreach($roles as $role)
                        <tr class="border-bottom">
                            <td>{{$role->id}}</td>
                            <td>{{$role->role_name}}</td>
                            <td>{{$role->role_code}}</td>
                            <td><button type="button" class="btn btn-sm btn-primary mt-1 mb-1">update</button> </td>
                            <td>
                            <button type="button" class="btn btn-sm btn-primary mt-1 mb-1">Delete</button>                                 
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</div>

@endsection