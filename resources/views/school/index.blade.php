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
                                @foreach($schools as $school)
                                    <!-- end col-6 -->
                                    <div class="col-md-12">
                                        <div class="card border shadow">
                                            <div class="media card-body media-xs overflow-visible">
                                                <!-- <div class="media-body valign-middle col-md-1">{{$school->id}}</div> -->
                                                <div class="media-body valign-middle col-md-7">
                                                    <h4 class="text-inverse"><b>{{$school->school_name}}</b></h4>
                                                </div>
                                                <div class="media-body valign-middle col-md-2"><b>{{$school->school_code}}</b></div>
                                                <div class="media-body valign-middle text-right overflow-visible">
                                                    <div class="btn-group">
                                                        <!-- <button class="btn btn-md btn-primary" type="button">update</button> -->
                                                    <form action="/deleteschool/{{$school->id}}" method="post" class="dis-inline">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                    <button type="submit" class="btn btn-sm btn-danger mt-1 mb-1">Delete</button>
                                                    </form>
                                                        <div class="col-md-2"></div> 
                                                
                                                            <!-- Button trigger modal -->
                                                    <button type="button" onclick="editSchool({{$school->id}})" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateSchool">update</button>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                </div><!-- end row -->
                                {{ $schools->links() }}
                            </div><!-- end #profile-friends tab -->
                        </div><!-- end tab-content -->
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