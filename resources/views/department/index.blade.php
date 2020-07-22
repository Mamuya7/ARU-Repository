@extends('layouts.admin')

@section('content')
    
    
    <div class="col-xl-12">
        <div class="card  shadow">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Schools</h2>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="table-responsive">
                    <table class="table card-table text-nowrap">
                        <tr class="border-bottom">
                            <th>Number</th>
                            <th>School Name</th>
                            <th>School Code</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>

                        @foreach($departments as $department)
                            <tr class="border-bottom">
                                <td>{{$department->id}}</td>
                                <td>{{$department->department_name}}</td>
                                <td>{{$department->department_code}}</td>
                                <td>   <button type="button" onclick="editDepartment({{$department->id}})" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateDepartment">update</button> </td>
                                <td>
                                    <form action="" method="post" class="dis-inline">
                                    <!-- /deletedepartment/{{$department->id}} -->
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-sm btn-danger mt-1 mb-1">Delete</button>
                                    </form>                                
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    {{ $departments->links() }}
                </div>
            </div>
        </div>
    </div>


                                            

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

<script>

    function editDepartment(did,sid){
    
        $.ajax({
                url: '/editDepartment/'+did,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    displayForm(response,sid);
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });
    }
   


    function displayForm(data,sid){

        $('#name').val(data.department.department_name);
        $('#code').val(data.department.department_code);
        let options = "";
        for (const school of data.schools) {
            if(school.id == sid){
                options += "<option id='"+school.id+"' selected>"+ school.school_name+"</option>"
            }else{
                options += "<option id='"+school.id+"'>"+ school.school_name+"</option>"
            }
        }
        $('#school').append(options);

           
    }
</script>

@endsection


