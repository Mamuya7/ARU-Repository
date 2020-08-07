@extends('layouts.admin')

@section('content')
<form action="assignUserCommittee" method="post">
@csrf
<div class="row" style="margin-top:40px"> 
    <div class="col-md-7 col-lg-7">
        <div class="card  shadow">
            <!-- <div class="card-header bg-transparent">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                             <h2 class="mb-0">Staffs</h2>   
                        </div>
                        <div class="col-md-7">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div><input class="form-control" placeholder="Search" type="text">
                            </div>  
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="table-responsive table-primary">
                <table class="table card-table text-nowrap">
                    <tr class="border-bottom">
                        <th></th>
                        <th>FULL NAME</th>
                        <th>DEPARTMENT</th>
                    </tr>
                    @foreach($user as $users)
                    <tr class="border-bottom">
                        <td><input type="checkbox" name="user_id[]" value="{{ $users->user_id }}"></td>
                        <td class="text-left" >{{ $users->full_name }}</td>
                        <!-- <td>kilango12345@gmail.com</td> -->
                        <td class="text-left">{{ $users->department }}</td>
                    </tr>
                    @endforeach
                    
            
                </table>
            </div>
        </div>
    </div>


    <div class="col-md-5 col-lg-5">
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
</div>
<div class="row">
    <div class="col-lg-10 col-md-10"></div>
    <div class="col-lg-2 col-md-2">
        <button style="margin-left:80px" type="submit" class="btn btn-success">Assign</button>
    </div>
</div>
</form>

<script>

$('#btn-submit').click(function(){
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
        
});

</script>

@endsection