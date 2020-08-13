@extends('layouts.admin')

@section('content')
<form action="assignUserCommittee" method="post">
@csrf
<div class="row" style="margin-top:40px"> 
 
    <div class="col-md-7 col-lg-7">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">AllCommittees</h4>

                <div class="table-responsive">
                        <table class="table card-table text-nowrap">   
                            @foreach($committee as $committees)
                                <tr class="border-bottom">
                                    <td><input type="radio" name="committee" value="{{$committees->id}}"></td>
                                    <td style="margin-left:-20px;">{{ $committees->committee_name}}</td>
                                </tr>           
                             @endforeach
                        </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5 col-lg-5">
        <div class="card  shadow">
            <div class="table-responsive table-primary">
                <table class="table card-table text-nowrap">
                    <tr class="border-bottom">
                        <th></th>
                        <th>ROLES</th>
                        <!-- <th>DEPARTMENT</th> -->
                    </tr>
                    @foreach($roles as $roles)
                    <tr class="border-bottom">
                        <td><input type="checkbox" name="role_id[]" value="{{ $roles->id }}"></td>
                        <td class="text-left" >{{ $roles->role_name }}</td>
                      
                    </tr>
                    @endforeach
                    
            
                </table>
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