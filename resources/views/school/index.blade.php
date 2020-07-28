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

                        @foreach($schools as $school)
                            <tr class="border-bottom">
                                <td>{{$school->id}}</td>
                                <td>{{$school->school_name}}</td>
                                <td>{{$school->school_code}}</td>
                <td>
                <button type="button" class="btn btn-sm btn-primary mt-1 mb-1" onclick="editSchool({{ $school->id}})" data-toggle="modal" data-target="#updateSchool">update</button> 
                </td>
                
                <td>
                    <!-- <button type="button" class="btn btn-sm btn-primary mt-1 mb-1">Delete</button>  --> 
                    <form action="deleteSchool/{{$school->id}}" method="post" class="dis-inline">
                
                    {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <button type="submit" class="btn btn-sm btn-primary mt-1 mb-1">Delete</button>
                    </form>                                 
                </td>
                            </tr>
                        @endforeach

                    </table>
                    {{ $schools->links() }}
                </div>
            </div>
        </div>
    </div>

                         

    <div class="modal fade" id="updateSchool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class = "modal-dialog modal-md">
            <div class = "modal-content">
                <div class = "modal-header bg-gradient-cyan">      
                    <button type = "button" class="close" data-dismiss = "modal">×</button>
                    <!-- <h4 class = "modal-title">Warning</h4> -->
                </div>
                <div class = "modal-body">
                    <form action="" method="post">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">School Name</label>
                                    <input type="text" id="name" class="form-control" name="school_name">
                                </div>
                            </div>
                        

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">School Code</label>
                                    <input type="text" id="code" class="form-control" name="school_code">
                                </div>
                            </div>
                    </form>    
                </div>
                <div class = "modal-footer">
                    <button type="button" class="btn btn-md btn-primary mt-1 mb-1">update</button>
                    <button type = "button" class = "btn btn-md btn-danger mt-1 mb-1" data-dismiss = "modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function editSchool(id){
        
        $.ajax({
                url: '/editSchool/'+id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data:{school_id : id},
                dataType: 'json',
                success:function(response){
                    displayForm(response);
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });
    }
   


    function displayForm(data){

            $('#name').val(data.school_name);
            $('#code').val(data.school_code);
           
    }
</script>

@endsection