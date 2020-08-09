@extends('layouts.admin')

@section('content')

<div class="col-xl-12">
    <div class="card  shadow">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="mb-0">Committees</h2>
                </div>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table card-table text-nowrap">
                    <tr class="border-bottom">
                    
                        <th>Committee Name</th>
                        <th>Committeee Code</th>
                        <th>Action</th>
                    </tr>
                    
                    @foreach($committees as $committee)
                   
                    <tr class="border-bottom">
                        <!-- <td>{{ $committee->id }}</td> -->
                        <td>{{ $committee->committee_name }}</td>
                        <td>{{ $committee->committee_code }}</td>
                        <td>  
                             <button type="button" onclick="showCommitteeMembers({{$committee->id}})" class="btn btn-sm btn-square btn-primary mt-1 mb-1"  data-toggle="modal" data-target="#largeModal">Members</button>
                             <button type="button" onclick="editCommittee({{$committee->id}})" class="btn btn-sm btn-square btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateRole">update</button> 
                        </td>
                         <td>
                            <form action="/deleteCommitee/{{$committee->id}}" method="post" class="dis-inline">             
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-sm btn-square btn-primary mt-1 mb-1">Delete</button>
                            </form>                                 
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{ $committees->links() }}
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="largeModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-weight:bold;font-size:18px;align:center;">USERS FOUND IN THE COMMITTEE</h4>
                <button type="button btn-primary" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <div class="card shadow">
                <div class="card-header table-success border-0">
                    <h2 class=" mb-0"></h2>
                </div>
                <div class="">
                    <div class="grid-margin">
                        <div class="">
                            <div class="table-responsive">
                                <table class="table card-table  table-primary table-vcenter text-nowrap  align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Email </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showData">
                                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class = "modal-dialog modal-md">
        <div class = "modal-content">
            <div class = "modal-header bg-gradient-cyan">      
                <button type = "button" class="close" data-dismiss = "modal">×</button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Committee Name</label>
                                <input type="text" id="name" class="form-control" name="committee_name">
                            </div>
                        </div>
                    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Committee Code</label>
                                <input type="text" id="code" class="form-control" name="committee_code">
                            </div>
                        </div>

                        <input type="text" id="com_id" class="form-control" name="id" hidden>
                </form>    
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-submit" class="btn btn-md btn-primary mt-1 mb-1" data-dismiss="modal" >update</button>
                <button type = "button" class = "btn btn-md btn-danger mt-1 mb-1" data-dismiss = "modal">Close</button>
            </div>
        </div>
    </div>
</div>






<script>

    function editCommittee(id){

        $.ajax({
            url: '/editCommittee/'+id,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
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
        $('#com_id').val(data.id);
        $('#name').val(data.committee_name);
        $('#code').val(data.committee_code);

    }

    $('#btn-submit').click(function(){
        var name = $("#name").val();
        var code = $("#code").val();
        var id = $("#com_id").val();

        $.ajax({
            url: '/updateCommittee/'+id,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data:{
                committee_name:name,
                committee_code:code
             },
            dataType: 'json',
            success:function(response){

                    setTimeout(function(){
                        $('#bn-submit').trigger('click');
                    },1500);
                   

            },
            error:function(xhr,status,err){
                console.log(err);
            }
        });
        
    });


    function showCommitteeMembers(id){
        // console.log(id);
        $.ajax({
            url: '/CommitteeMembers/'+id,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            dataType: 'json',
            success:function(response){
                showCommitteUsers(response);
                
            },
            error:function(xhr,status,err){
                console.log(err);
            }
        });        
    }

    function showCommitteUsers(data){
        
        var list ="";
        data.forEach(users => {

               list+="<tr>";
               list+="<td>"+users.first_name+"</td>";
               list+="<td>"+users.last_name+"</td>";
               list+="<td>"+users.email+"</td>";
               list+="<td>"+users.email+"</td>";
               list+="<td>";
               list+="<button type='button' class='btn btn-primary'>remove</button>"
               list+="</td>";
               list+="</tr>";
            
            });
            $('#showData').empty();
            $('#showData').append(list);


    }



</script>

@endsection