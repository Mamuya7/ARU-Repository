@extends('layouts.admin')

@section('content')

<div class="modal fade" id="updateDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="largeModalLabel">Modal title</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                        {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Department Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Department Name">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Department Code</label>
                                <input type="text" class="form-control" id="code" placeholder="Department Name">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 active border" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fe fe-home mr-2"></i>Academic departments</a>
        </li>

        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 border" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="fe fe-message-circle mr-2"></i>Administration departments</a>
        </li>
    </ul>
</div>

									
									
				


<div class="col-md-12" id="tabs-icons-text-2">
    <div class="card  shadow">
            <div class="card-body ">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card-header bg-transparent border-bottom-0">
                            <h2>ACADEMIC DEPARTMENTS</h2>
                        </div>
                        <div class="emp-tab">
                            <div class="table-responsive">
                                <table class="table  table-hover table-striped text-nowrap">
                                    <thead class="text-default">
                                        <tr>                                            
                                            <th>Department Name</th>
                                            <th>Department Code</th>
                                            <th>Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($departments as $department)
                                    <tr>
                                        
                                        <td>{{$department->department_name}}</td>
                                        <td>{{$department->department_code}}</td>
                                        <td>   <button type="button" onclick="editDepartment({{$department->id}})" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateDepartment">update</button> </td>
                                        <td>
                                            <!-- /deletedepartment/{{$department->id}} -->
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="btn btn-sm btn-danger mt-1 mb-1">Delete</button>
                                            </form>                                
                                        </td>
                                    </tr>
                                        @endforeach
                

                                    </tbody>
                                </table>
                            </div>
                        </div>          
                     
                    </div>
                    <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                        <div class="card-header bg-transparent border-bottom-0">
                            <h2>ADMINISTRATION DEPARTMENTS</h2>
                        </div>
                        <div class="emp-tab">
                            <div class="table-responsive">
                                <table class="table  table-hover table-striped text-nowrap">
                                    <thead class="text-default">
                                        <tr>
                                            
                                            <th>Department Name</th>
                                            <th>Department Code</th>
                                            <th>Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($directorates as $department)
                                    <tr>
                                        
                                        <td>{{$department->department_name}}</td>
                                        <td>{{$department->department_code}}</td>
                                        <td>   <button type="button" onclick="editDepartment({{$department->id}})" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateDepartment">update</button> </td>
                                        <td>
                                            <!-- /deletedepartment/{{$department->id}} -->
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="btn btn-sm btn-danger mt-1 mb-1">Delete</button>
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
    </div>
</div>

<script>

   
function editDepartment(did){
    
    $.ajax({
        url: '/editDepartment/'+did,
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

    $('#name').val(data.department_name);
    $('#code').val(data.department_code);
            
}
</script>

@endsection


