@extends('layouts.admin')

@section('content')


<div class="card  shadow">
            <div class="card-body ">               
                <div class="card-header bg-transparent border-bottom-0">
                    <h2>DIRECTORATES</h2>
                </div>
                <div class="emp-tab">
                    <div class="table-responsive">
                        <table class="table  table-hover table-striped text-nowrap">
                            <thead class="text-default">
                                <tr>
                                    
                                    <th>Department Name</th>
                                    <th>Department Code</th>
                                    <th>Action</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($directorates as $directorate)
                            <tr>
                                
                                <td>{{$directorate->directorate_name}}</td>
                                <td>{{$directorate->directorate_code}}</td>
                                <td>   <button type="button" onclick="editDirectorate({{$directorate->id}})" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="modal" data-target="#updateDepartment">update</button> </td>
                                <td>
                                    
                                    <form action="" method="post" class="dis-inline">
                
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-sm btn-primary mt-1 mb-1">Delete</button>
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

@endsection