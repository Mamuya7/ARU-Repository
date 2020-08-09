@extends('layouts.admin')

@section('content')
								
    <div class="card shadow">
        <div class="card-header table-primary border-0">
            <h2 class=" mb-0">Primary Table</h2>
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
										<button type="button" class="btn btn-primary btn-sm btn-square mt-1 mb-1">Update</button>
                                        
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
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                   
                <div class="modal-body">
                    <!-- <p class="mb-0">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p> -->
                
                        <div class="card-header">

                            <div class="nav-wrapper">
                                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 active border" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fe fe-home mr-2"></i>UserDetails</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 border" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="fe fe-message-circle mr-2"></i>User Role</a>
                                    </li>
                                </ul>
                                
                              </div>
                        </div>
                        <div class="card-body">
                           
                            
                                <div class="card-body ">
                                    <div class="tab-content" id="myTabContent">
                                    <button type="button btn-primary" class="close" data-dismiss="modal" aria-label="Close">                    
                            
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                            
                                        <div class="table-responsive border ">
                                            <table class="table row table-borderless w-100 m-0 ">
                                                <tbody class="col-lg-6 p-0">
                                                    <tr>
                                                        <td><strong>Full Name :</strong> Cori Stover</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Location :</strong> USA</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Languages :</strong> English, German, Spanish.</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>DOB :</strong> 18/02/1992</td>
                                                    </tr>
                                                </tbody>
                                                <tbody class="col-lg-6 p-0">
                                                    <tr>
                                                        <td><strong>Occupation :</strong> Administrator</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Website :</strong> ansta.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email :</strong> coristover@ansta.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Phone :</strong> +222-6652-6325</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
													 
                                      
                                            
                                        </div>
                                       
                                        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                            <div class="row">
                                                <P><h2>USER ROLES</h2></P>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                <ul id="sortable1" class="list-group connectedSortable">
                                                        
                                                    </ul>
                                                </div>

                                                <div class="col-md-5">
                                                @foreach($roles as $role)
                                                    <ul id="sortable2" class="list-group connectedSortable">
                                                        <li class="list-group-item">{{$role->role_name}}</li>
                                                        <!-- <li class="list-group-item">Bird</li>
                                                        <li class="list-group-item">Falcon</li>
                                                        <li class="list-group-item">Mouse</li> -->
                                                    </ul>
                                                @endforeach    
                                                            
                                                </div>
                    
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                        
                        </div>
    							
                </div>
               
            </div>
        </div>
    </div>





    

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
                    displayUserRoles(response);
                    
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });

        }

        function displayUserRoles(data){
            
            var list ="";
            data.forEach(role => {
                list +="<li class='list-group-item'>";
                list+=role.role_name;
                list +="</li>";
            });
            $('#sortable1').empty();
            $('#sortable1').append(list);

            // data.forEach(school => {
            //         list += '<option data-tokens="'+school.school_name +" "+ school.school_code;
            //         list += '" value="'+school.id+'">'+school.school_name+ " (" +school.school_code +")"+'</option>'; 
            //     });
            // $('#sortable1').append(list);
           
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