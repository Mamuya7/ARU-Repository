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
                        <th>Number</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Action</th>
                        <th>Action</th>
                    </tr>

                    @foreach($committees as $committee)
                    <tr class="border-bottom">
                        <td>{{ $committee->id }}</td>
                        <td>{{ $committee->committee_name }}</td>
                        <td>{{ $committee->committee_name }}</td>
                        <td>  
                             <button type="button" onclick="editCommittee({{$committee->id}})" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateRole">update</button> 
                        </td>
                        <td>       
                            <form action="/deleteCommitee/{{$committee->id}}" method="post" class="dis-inline">
                                
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-sm btn-primary mt-1 mb-1">Delete</button>
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


<div class="modal fade" id="updateRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class = "modal-dialog modal-md">
            <div class = "modal-content">
                <div class = "modal-header bg-gradient-cyan">      
                    <button type = "button" class="close" data-dismiss = "modal">×</button>
                </div>
                <div class = "modal-body">
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

    function editCommittee(id){

        $.ajax({
            url: '/editCommittee/'+id,
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

        $('#name').val(data.committee_name);
        $('#code').val(data.committee_code);
    }


</script>

@endsection