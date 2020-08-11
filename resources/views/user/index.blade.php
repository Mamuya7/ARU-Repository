@extends('layouts.admin')

@section('content')
								
    <div class="card shadow">
        <div class="card-header table-primary border-0">
            <h2 class=" mb-0">All Users</h2>
        </div>
        <div class="">
            <div class="grid-margin">
                <div class="">
                    <div class="table-responsive">
                        <table class="table card-table  table-primary table-vcenter text-nowrap  align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Email </th>
                                    <th>Department</th>
                                     <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($user as $users)
                                    
                                <tr >
                                    <td>{{ $users->full_name }}</td>
                                    <td>{{ $users->gender }}</td>
                                    <td>{{ $users->email }} </td>
                                    <td class="text-nowrap" >{{ $users->department }}</td>
                                    <td>
                                        <button type="button" onclick="displayRole({{ $users->id }})"  class="btn btn-primary btn-sm btn-square mt-1 mb-1" data-toggle="modal" data-target="#largeModal">View</button>
                                       
                                        <button type="button" onclick="editUser({{ $users->id }})" class="btn btn-sm btn-square btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateDirectorate">update</button> 
                                    
										<!-- <button type="button" class="btn btn-primary btn-sm btn-square mt-1 mb-1">Update</button> -->
                                        
										<button type="button" class="btn btn-primary btn-sm btn-square mt-1 mb-1">delete</button>
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


    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="largeModalLabel">Modal title</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="assignRole" method="post">
                        <div class="modal-body">
                            
                                <div class="row" style="margin-top:40px"> 
                            
                                    <div class="col-md-6 col-lg-6">
                                        <div class="card  shadow">
                                            <div class="table-responsive table-primary">
                                                <table class="table card-table text-nowrap">
                                                    <tr class="border-bottom">
                                                        <th></th>
                                                        <th>User Roles</th>
                                                    </tr>
                                                    <tbody id='tabe-data'>
                                                
                                                    </tbody>
                                            
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-lg-6">
                                        <div class="card shadow">
                                    
                                            <div class="card-body">
                                                <h4 class="card-title">All Roles</h4>

                                                <div class="table-responsive">
                                                        <table class="table card-table text-nowrap">   
                                                        <input type="text" name="user_id" id="user_details" hidden>
                                                            @foreach($roles as $role)
                                                                <tr class="border-bottom">
                                                                    <td><input type="checkbox" name="role_id" value="{{$role->id}}" id="check-box"></td>
                                                                    <td style="margin-left:-20px;" id="check-click">{{ $role->role_name}}</td>
                                                                </tr>
                                                            @endforeach 
                                                            <!-- <tr class="border-bottom">

                                                            </tr> -->

                                                        </table>
                                                </div>
                                            </div>
                                    
                                        </div>
                                    </div>
                                </div>
                                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Assign Role</button>
                        </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>


    

    <script>

        function displayRole(id){

            $.ajax({
                url: '/getUserRole/'+id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(response){
                    // console.log(response);
                    displayUserRoles(response);
                    
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });

        }

        function displayUserRoles(data){
            $('#user_details').val(data.users);
            var list ="";
            data.roles.forEach(role => {
                list+="<tr>";
                list+="<td><input type='checkbox' name='' value=''></td>";
                list+="<td>"+role.role_name+"</td>";   
                list+="<td><button type='button' class='btn btn-primary'>remove</button></td>";
                list+="</tr>";
            });
            $('#tabe-data').empty();
            $('#tabe-data').append(list);
      
        }

        $('#check-clck').click(function(){
            // $('#check-box').checked = true;
            $("#check-box").click(function(){
                $("#myCheck").prop("checked", true);
            });
        })
        

    </script>

@endsection
								













<!--                                 
    <script>
            
            $(document).ready(function(){
                $("#sortable1, #sortable2").sortable({
                    connectWith: ".connectedSortable"
                });
            });
    
            function displayRole(id){
    
                $.ajax({
                    url: '/getUserRole/'+id,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success:function(response){
                        DisplayUserRoles(response);
                        
                    },
                    error:function(xhr,status,err){
                        console.log(err);
                    }
                });
    
            }
    
            
    
    </script> -->