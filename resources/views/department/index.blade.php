@extends('layouts.admin')

@section('content')
            <!-- Page content -->   
      
<div class="row tab-pane">
    <div class="col-md-12">
        <div class="content content-full-width" id="content">
            <!-- begin profile-content -->
            <div class="profile-content">
                <!-- begin tab-content -->
                <div class="tab-content p-0">
                    <!-- begin #profile-friends tab -->
                    <div class="tab-pane fade in active show" id="profile-friends">
                        <!-- begin row -->
                        <div class="row">
                        @foreach($departments as $department)
                            <!-- end col-6 -->
                            <div class="col-md-12">
                                <div class="card border shadow">
                                    <div class="media card-body media-xs overflow-visible">
                                        <div class="media-body valign-middle col-md-1">{{$department->id}}</div>
                                        <div class="media-body valign-middle col-md-5">
                                            <h4 class="text-inverse">{{$department->department_name}}</h4>
                                        </div>
                                        <div class="media-body valign-middle col-md-1">{{$department->department_code}}</div>
                                        <div class="media-body valign-middle col-md-4"><h5>{{$department->school_name}} <span>(<b>{{$department->school_code}} </b>)</span></h5></div>
                                        <div class="media-body valign-middle text-right overflow-visible">
                                            <div class="btn-group">
                                            
                                                <form action="/deletedepartment/{{$department->id}}" method="post" class="dis-inline">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="btn btn-sm btn-danger mt-1 mb-1">Delete</button>
                                                </form>
                                                    <div class="col-md-1"></div> 
                                                        <!-- Button trigger modal -->
                                                    <button type="button" onclick="editDepartment({{$department->id}},{{$department->school_id}})" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateDepartment">update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div><!-- end row -->
                        {{ $departments->links() }}
    
                    </div><!-- end #profile-friends tab -->
                


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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">School Name</label>
                                <select class="form-control select2 w-100" id="school">
                                    <option value="null" selected disabled></option>
                                </select>
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


