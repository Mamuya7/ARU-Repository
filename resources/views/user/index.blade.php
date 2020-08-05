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
                                    {{$users->id}}
                                <tr >
                                    <td>{{ $users->full_name }}</td>
                                    <td>{{ $users->gender }}</td>
                                    <td>{{ $users->email }} </td>
                                    <td class="text-nowrap" >{{ $users->department }}</td>
                                    <td>
                                        <button type="button" id="btn-view" class="btn btn-primary btn-sm btn-square mt-1 mb-1">View</button>
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


    <!-- <button type="button" class="btn btn-primary mt-1 mb-1" data-toggle="modal" data-target="#largeModal">
        Launch large modal
    </button> -->

    
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                   
                <div class="modal-body">
                    <!-- <p class="mb-0">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p> -->
                
                        <div class="card-header">
                            <!-- <h2 class="mb-0">Navigation Tabs</h2> -->
                            <div class="nav-wrapper">
                                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 active border" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fe fe-home mr-2"></i>UserDetails</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 border" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fe fe-user mr-2"></i>Profile</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 border" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="fe fe-message-circle mr-2"></i>User Role</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                           
                            
                                <div class="card-body ">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                            <p class="description">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
                                            <p class="description mb-0">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse.</p>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                            <p class="description mb-0">Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                            <p class="description mb-0">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
                                        </div>
                                    </div>
                                </div>
                        
                        </div>
                    
									
                </div>
               
            </div>
        </div>
    </div>
						


    

    <script>
            $('#btn-view').click(function(){
            //   var a =  $('#usr_id').val();
            //   alert(a);
            var a = $(this).val();
            // alert(a);
                $('#largeModal').modal('show');
            })
    </script>

@endsection
								