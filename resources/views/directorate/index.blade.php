@extends('layouts.admin')

@section('content')

<a href="{{ route('registerDirectorateForm') }}">
    <button class="btn btn-sm btn-square btn-primary mt-1 mb-1">add Directorate</button>
</a>
<div class="card  shadow">
    <div class="card-body ">               
        <div class="card-header bg-transparent border-bottom-0">
            <h2>ADMINISTRATION DIRECTORATES</h2>
            {{$directorates}}
        </div>
        <div class="emp-tab">
            <div class="table-responsive">
                <table class="table  table-hover table-striped text-nowrap">
                    <thead class="text-default">
                        <tr>
                            
                            <th>Directorate Name</th>
                            <th>Directorate Code</th>
                            <th>Departments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($directorates as $directorate)
                    <tr>
                        
                        <td>{{$directorate->directorate_name}}</td>
                        <td>{{$directorate->directorate_code}}</td>
                        <td>{{$directorate->departments_count}}</td>
                        <td>   
                            <button type="button" onclick="editDirectorate({{$directorate->id}})" class="btn btn-sm btn-square btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateDirectorate">update</button> 
                            <form action="/deletedirectorate/{{$directorate->id}}" method="post" class="dis-inline" style="display:inline">
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



<div class="modal fade" id="updateDirectorate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class = "modal-dialog modal-md">
        <div class = "modal-content">
        <form id="update-directorate" method="post">
            {{csrf_field()}}
            <div class = "modal-header bg-primary">      
                <button type = "button" class="close" data-dismiss = "modal">×</button>
            </div>
            <div class = "modal-body">
                

                    <input type="text" id="r_id" class="form-control" name="role_id" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Directorate Name</label>
                                <input type="text" id="name" class="form-control" name="directorate_name">
                            </div>
                        </div>
                    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Directorate Code</label>
                                <input type="text" id="code" class="form-control" name="directorate_code">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Diretorate Head</label>
                                <select name="directorate_head" id="head" class="form-control">
                                    <option value="null" selected disabled></option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->role_name ." (". $role->role_code.")"}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </form>    
            </div>
            <div class = "modal-footer">
                <button type="submit" class="btn btn-md btn-primary mt-1 mb-1">update</button>
                <button type = "button" class = "btn btn-md btn-danger mt-1 mb-1" data-dismiss = "modal">Close</button>
            </div>
        </form>
        </div>
    </div>
    </form>
</div>




<script>
    function editDirectorate(id){
        $.ajax({
                url: '/editDirectorate/'+id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data:{directorate_id : id},
                dataType: 'json',
                success:function(response){
                     displayForm(response);
                    // console.log(response);
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
        });
    }

    function displayForm(data){
        // console.log (data.id);
        $('#name').val(data.directorate_name);
        $('#code').val(data.directorate_code);
        $('#head').val(data.directorate_head);

        $('#update-directorate').attr('action',"updateDirectorate/"+data.id);
    }
</script>
@endsection