@extends('layouts.admin')

@section('content')


<div class="col-md-12 col-lg-12">
    <div class="card shadow">
        <div class="card-body">
        <h3 class="card-title">ASSIGN COMMITTEE ROLES</h3>
            <form action="assignUserCommittee" method="post">   
                @csrf
                <div class="row" style="margin-top:40px"> 
                
                    <div class="col-md-7 col-lg-7">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title">Committees</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                        <table class="table card-table text-nowrap">   
                                            @foreach($committees as $committee)
                                                <tr class="border-bottom">
                                                    <td><input type="radio" name="committee" value="{{$committee->id}}"></td>
                                                    <td style="margin-left:-20px;">{{ $committee->committee_name}}</td>
                                                </tr>           
                                            @endforeach
                                        </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                {{$committees->links()}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-lg-5">
                        <div class="card  shadow">
                            <div class="card-header">
                                <h3 class="card-title">Roles</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table card-table text-nowrap">
                                    @foreach($roles as $role)
                                    <tr class="border-bottom">
                                        <td><input type="checkbox" name="role_id[]" value="{{ $role->id }}"></td>
                                        <td class="text-left" >{{ $role->role_name }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-10 col-md-10"></div>
                    <div class="col-lg-2 col-md-2">
                        <button style="margin-left:80px" type="submit" class="btn btn-success">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
// $('#btn-submit').click(function(){
    // var userID = [];
    // var roleID = [];
    
    //     $('#check-user:checked').each(function() { 
    //         userID.push(this.value);
    //     });

    //     $('#check-commmitee:checked').each(function(){
    //         roleID.push(this.value);
    //     });

    //     console.log(userID,roleID);

        
        // $.ajax({
        //     url: 'assignCommitee',
        //     type: 'POST',
        //     headers: {
        //         'X-CSRF-TOKEN': '{{csrf_token()}}'
        //     },
        //     data:{

        //     },
        //     dataType: 'json',
        //     success:function(response){
        //        displayForm(response);
        //     },
        //     error:function(xhr,status,err){
        //         console.log(err);
        //     }
        // });
        
// });

</script>

@endsection