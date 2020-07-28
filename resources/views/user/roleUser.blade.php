@extends('layouts.admin')

@section('content')

<div class="col-xl-8">
    <div class="card  shadow">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="mb-0">Roles</h2>
                </div>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table card-table text-nowrap">
                    <tr class="border-bottom">
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Department</th>
                        <!-- <th>Action</th>
                        <th>Action</th> -->
                    </tr>
                        <tr class="border-bottom">
                            <td>hnfdfjhfkfdkddfbdfbfffjdf</td>
                            <td>hnfdfjhfkfdkddfbdfbfffjdf</td>
                            <td>nmmcjjjsfbvjjvjvy</td>
                            <td>  
                             <button type="button" class="btn btn-sm btn-primary mt-1 mb-1" ></button> 
                            </td>
                            
                            <td>
            
                                <form action="" method="post" class="dis-inline">
                            
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-sm btn-primary mt-1 mb-1">UnAssigne</button>
                                </form>                                 
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</div>



<script>


</script>

@endsection