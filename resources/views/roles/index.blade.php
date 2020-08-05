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
                            <td>  
                             <button type="button" onclick="editRole({{$role->id}})" class="btn btn-sm btn-square btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateRole">update</button> 
                            </td>
                                
                            <td>
                                <!-- <button type="button" class="btn btn-sm btn-primary mt-1 mb-1">Delete</button>  --> 
                                <form action="/deleteRole/{{$role->id}}" method="post" class="dis-inline">
                            
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-sm btn-square btn-primary mt-1 mb-1">Delete</button>
                                </form>                                 
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class = "modal-dialog modal-md">
        <div class = "modal-content">
            <div class = "modal-header bg-primary">      
                <button type = "button" class="close" data-dismiss = "modal">×</button>
                <!-- <h4 class = "modal-title">Warning</h4> -->
            </div>
            <div class = "modal-body">
                <form action="" method="post">
                    {{csrf_field()}}
                    <input type="text" id="r_id" class="form-control" name="role_id" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Role Name</label>
                                <input type="text" id="name" class="form-control" name="school_name">
                            </div>
                        </div>
                    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Role Code</label>
                                <input type="text" id="code" class="form-control" name="school_code">
                            </div>
                        </div>
                </form>    
            </div>
            <div class = "modal-footer">
                <button type="button" id="update-role" class="btn btn-md btn-primary mt-1 mb-1">update</button>
                <button type = "button" class = "btn btn-md btn-danger mt-1 mb-1" data-dismiss = "modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    function editRole(id){
        $.ajax({
            url: '/editRole/'+id,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            dataType: 'json',
            success:function(response){
                // console.log(response);
                displayForm(response);
            },
            error:function(xhr,status,err){
                console.log(err);
            }
        });
    }

    function displayForm(data){
        $('#r_id').val(data.id);
        $('#name').val(data.role_name);
        $('#code').val(data.role_code);
    }

    function updateRoles(){
       var name = $('#name').val();
       var code = $('#code').val();
        $.ajax({
            url: '/updateRole',
            type: 'POST',
            // data:{
            //     role_name:name,role_code:code
            // },
            // headers: {
            //     'X-CSRF-TOKEN': '{{csrf_token()}}'
            // },
            success:function(response){
               
            },
            error:function(xhr,status,err){
                console.log(err);
            }
        });
        
    }

    $('#update-role').click(function(){
        updateRoles();
    })

           
</script>

@endsection