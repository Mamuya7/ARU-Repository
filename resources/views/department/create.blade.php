@extends('layouts.admin')




@section('content')
 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mb-0">REGISTER NEW DEPARTMENT</h2>
                </div>
            <div class="card-body">
            <form action="storeDepartment" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Department Name</label>
                            <input type="text" class="form-control" name="department_name" placeholder="Department Name">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Department Code</label>
                            <input type="text" class="form-control" name="department_code" placeholder="Department Name">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">School Name</label>
                            <select id="school_id" name="school_id" class="form-control select2 w-100">
                                <option value="none" selected="selected" disabled>Select School</option>
                                @foreach($schools_name as $school)
                                    <option value="{{$school->id}}">{{$school->id}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn_sbmt">
                                        {{ __('Register') }}
                            </button>
                        </div>
                </div>                
            </form>
            </div>
        </div>
    <div>
</div>
@endsection

<!-- 
@section('scripts')
    <script>
    
    $(document).ready(function(){
      $('#btn_sbmt').click(function(){
        var selectedCountry = $("#school_id").children("option:selected").val();
        alert("You have selected the country - " + selectedCountry); 
      })
    });
      
    </script>
@endsection -->
 
   