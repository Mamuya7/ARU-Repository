@extends('layouts.admin')

@section('content')

<div class="row" style="margin-top:40px"> 
    <div class="col-md-8 col-lg-8">
        <div class="card  shadow">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">UN signed staff</h2>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="table-responsive">
                    <table class="table card-table text-nowrap">
                        <tr class="border-bottom">
                            <th></th>
                            <th>FULL NAME</th>
                            <th>EMAIL</th>
                            <th>DEPARTMENT</th>
                            
                        </tr>
                    @foreach($user as $users)
                        <tr class="border-bottom">
                            <td><input type="checkbox" name=""></td>
                            <td class="text-left">{{ $users->full_name }}</td>
                            <td>{{ $users->email }}</td>
                            <td class="text-left">{{ $users->department }}</td>
                        </tr>
                    @endforeach
                        
                
                    </table>
                </div>
            </div>
        </div>
    </div>




    <div class="col-md-4 col-lg-4">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">User Roles</h4>

                <div class="table-responsive">
                        <table class="table card-table text-nowrap">
                        @foreach($role as $roles)
                            <tr class="border-bottom">
                                <td><input type="checkbox" name=""></td>
                                <td class="text-left">{{ $roles->role_name }}</td>   
                            </tr>
                        @endforeach
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-10 col-md-10"></div>
    <div class="col-lg-2 col-md-2">
        <button style="margin-left:80px" class="btn btn-success">Assign</button>
    </div>
</div>


<script>


</script>

@endsection