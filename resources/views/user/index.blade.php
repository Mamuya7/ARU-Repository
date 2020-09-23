
@extends('layouts.admin')
@section('content')

<a href="{{ route('register') }}">
        <button class="btn btn-sm btn-square btn-primary mt-1 mb-1">add User</button>
</a>
								
    <div class="card shadow">
   
        <div class="card-header border-0">
            <h2 class=" mb-0">All Staffs</h2>
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
                                    <th>Email</th>
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
                                    <td class="text-nowrap">{{ $users->department }}</td>
                                    <td>
                                        <button type="button" onclick="displayRole({{ $users->id }})"  class="btn btn-primary btn-sm btn-square mt-1 mb-1" data-toggle="modal" data-target="#largeModal">Roles</button>
                                       
                                        <button type="button" onclick="editUser({{ $users->id }})" class="btn btn-sm btn-square btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateUser">update</button> 
              
                                        <form action="deleteUser/{{$users->id }}" method="post" class="dis-inline" style="display:inline">
                
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-sm btn-square btn-primary mt-1 mb-1">Delete</button>
                                        </form> 
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
    {{ $user->links() }}

    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="largeModalLabel">ASSIGN USER ROLES</h2>
                        <button type = "button" class="close" data-dismiss = "modal">×</button>
                    </div>
             
                        <div class="modal-body">
                            
                                <div class="row" style="margin-top:40px">                          
                                    <div class="col-md-6 col-lg-6">
                                        <div class="card  shadow">
                                            <div class="table-responsive table-primary">
                                                <table class="table card-table text-nowrap">
                                                    <tr class="border-bottom">
                                                        <!-- <th></th> -->
                                                        <th>User Roles</th>
                                                    </tr>
                                                    <tbody id='tabe-data'>
                                                
                                                    </tbody>
                                            
                                                </table>
                                            </div>
                                            <div id="user-roles">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-lg-6">
                                        <form action="assignRole" method="post" id="assign-form">
                                            @csrf
                                            <div class="card shadow">                                  
                                                <div class="card-body">
                                                    <h4 class="card-title">All Roles</h4>
                                                    <div class="table-responsive">
                                                        <table class="table card-table text-nowrap" style="height: 250px;overflow: auto;">   
                                                        <input type="text" name="userId" id="user_details" value="$user->id" hidden>
                                                            @foreach($roles as $role)
                                                                <tr class="border-bottom">
                                                                    <td><input type="checkbox" name="roles[]" value="{{ $role->id}}" id="check-box"></td>
                                                                    <td id="check-click">{{ $role->role_name}}</td>    
                                                                </tr>
                                                            @endforeach 
                                                            
                                                        </table>
                                                    </div>
                                                    
                                                    <!-- <div class="row p-2 m-1 bg-secondary">
                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                                            <button class="btn btn-icon btn-success btn-sm pr-2 pl-2 pt-1 pb-1" type="button"
                                                             value="">
                                                                <span class="btn-inner--icon"><i class="fe fe-chevrons-left"></i></span>
                                                            </button> -->
                                                            <!-- <span class="fas fa-angle-double-left pr-2 pl-2 pt-1 pb-1 bg-green text-white"></span> -->
                                                        <!-- </div>
                                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">
                                                            <span></span>
                                                        </div>    
                                                    </div> -->
                                                    
                                                </div>
                                        
                                            </div>
                                        </form> 
                                    </div>
                                </div>
                                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="assign-btn">Assign Role</button>
                        </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class ="modal-dialog modal-xl">
            <div class = "modal-content">
    
                <form id="update-user" method="post">
                    {{csrf_field()}}
                        <div class = "modal-header bg-primary">  
                            <h3>Update Staff Records </h3>   
                            <button type = "button" class="close" data-dismiss = "modal">×</button> 
                        </div>
                    <div class = "modal-body">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input id="first_name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" value="{{ old('name') }}" required autocomplete="name" autofocus disabled> 
                            
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select id="gender" name="gender" class="form-control select2 w-100" disabled>
                                    <option value="none" selected="selected" disabled>Select Gender</option>
                                    <option value="male" class="text-md">Male</option>
                                    <option value="female" class="text-md">Female</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus disabled>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror          
                            </div>

                        

                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select id="department" name="department" class="form-control select2 w-100" >
                                    <option   selected="selected" disabled></option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" class="text-md">{{$department->department_name}}</option>
                                @endforeach
                                </select>
                            </div>

                        </div>
                            
                    </div>
                    <div class = "modal-footer">
                        
                        <button type="submit" class="btn btn-primary mt-1 mb-1">update</button>
                    
                        <button type = "button" class = "btn btn-md btn-danger mt-1 mb-1" data-dismiss = "modal">Close</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>

    

    <script>


        function editUser(id){

            $.ajax({
                url: '/editUser/'+id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(response){
                     console.log(response);
                    
                    

                        $('#first_name').val(response.first_name);
                        $('#email').val(response.email);
                        $('#last_name').val(response.last_name);
                        $('#gender').val(response.gender);
                        // $('#department').val(response.department_name);
                        $('#department').val(response.department_id);
                        // $(this).children("option:selected").val();


                        $('#update-user').attr('action',"updateUser/"+response.id);

                        
                        
              
                
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
        });
        }

    

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

                list+="<tr id='role"+role.id+"'>";
                // list+="<td id='user-role'><input type='checkbox' name='' value='"+role.id+"'></td>";
                list+="<td >"+role.role_name+"</td>";   
                list+="<td><button type='button' onclick='unAssignRole("+role.id+")' class='btn btn-rol btn-primary'>un Assign</button></td>";
                list+="</tr>";
                
            });
            $('#tabe-data').empty();
            $('#tabe-data').append(list);
      
        }

        function unAssignRole(id){
         var userId = $('#user_details').val();
            $("#role"+id).remove();
            $.ajax({
                url: '/removeRole/'+id,
                type: 'POST',
                data:{
                    userID : userId
                },
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(response){
                     console.log(response);
                                   
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });
        }

        $('#check-clck').click(function(){
            // $('#check-box').checked = true;
            $("#check-box").click(function(){
                $("#myCheck").prop("checked", true);
            });
        })
        

        $('#assign-btn').click(function(){
            $('#assign-form').trigger("submit");

            // var id = $('#user_details').val();
            // var selected = [];
            // $('#check-box:checked').each(function() {
            //     selected.push($(this).attr('value'));
            // });
        });
        const addRole = (role) =>{
            let list = createRoleList(role,"add");
            $('#user-roles').append(list);
        }
        const removeRole = (role) =>{
            console.log(role);
            let list = createRoleList(role,"remove");
        }
        const ajaxPost = (path,valuedata,method) =>{
            $.ajax({
                url: path,
                type: 'post',
                data:valuedata,
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(response){
                    method(response);
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });
        }
        const createRoleList = (role,type) =>{
            let list = '<div class="row p-2 m-1 bg-secondary">';

            let listname = '<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">';
                listname += '<span>' + role.role_name + '</span>';
                listname += '</div>';

            let listbtn = createRoleButton(role,type);

            if(type == "add"){
                list += listname;
                list += listbtn;
            }else if(type == "remove"){
                list += listbtn;
                list += listname;
            }
                list += '</div>';

            return list;
        }

        const createRoleButton = (role,type) =>{
            let listbtn = '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">';
                listbtn += '<button class="btn btn-icon';
                if (type == "add") {
                    listbtn += ' btn-danger btn-sm pr-2 pl-2 pt-1 pb-1" type="button" value="'+role.id+'"';
                    listbtn += ' onclick="removeRole({{json_encode('+role)+')}})">';
                    listbtn += '<span class="btn-inner--icon"><i class="fe fe-x"></i></span>';
                }else if(type == "remove"){
                    listbtn += ' btn-success btn-sm pr-2 pl-2 pt-1 pb-1" type="button" value="'+role.id+'"';
                    listbtn += ' onclick="addRole({{json_encode('+role)+')}})">';
                    listbtn += '<span class="btn-inner--icon"><i class="fe fe-chevrons-left"></i></span>';
                }
                listbtn += '</button>';
                listbtn += '</div>';
             return listbtn; 
        }
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