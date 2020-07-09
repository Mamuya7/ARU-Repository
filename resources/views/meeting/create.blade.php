@extends('layouts.app')

@section('content')
    <div>
        <form action="store_meeting" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="pt-0 pr-3 pl-3 pb-3">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control">
                    </div>
                    <div class="pt-0 pr-3 pl-3 pb-3">
                        <label for="description">Description</label>
                        <textarea id="description" cols="30" rows="8" name="description" class="form-control"></textarea>
                    </div>
                    <div class="pt-0 pr-3 pl-3 pb-3">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="null" selected disabled></option>
                            <option value="1">Senate Meeting</option>
                            <option value="2">School Meeting</option>
                            <option value="3">Department Meeting</option>
                            <option value="4">Inter-Department Meeting</option>
                            <option value="5">Special Meeting</option>
                            <!-- @foreach(Auth::User()->roles as $role)
                            <option value="{{$role->pivot->id}}">{{$role->role_name}}</option>
                            @endforeach -->
                        </select>
                    </div>
                    <div class="pt-0 pr-3 pl-3 pb-3">
                        <label for="entity">Entity</label>
                        <select name="entity" id="entity" class="form-control">
                            <option value="null" selected disabled></option>
                            <!-- @foreach(Auth::User()->roles as $role)
                            <option value="{{$role->pivot->id}}">{{$role->role_name}}</option>
                            @endforeach -->
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="pt-0 pr-3 pl-3 pb-3">
                                <label for="description">Date</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="pt-0 pr-3 pl-3 pb-3">
                                <label for="description">Time</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-label mb-3">Qualifications</div>
                    <div class="card pt-3 mt-0">
                        <div class="custom-switches-stacked">
                        @foreach($roles as $role)
                            <label class="custom-switch">
                                <input type="checkbox" name="qualifications[]" value="{{$role->id}}" class="custom-switch-input">
                                <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                <span class="custom-switch-description">{{$role->role_name}}</span>
                            </label>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 text-right">
                <input type="submit" value="Create" class="btn btn-warning">
            </div>
        </form>
    </div>
    @if(Session::has('output'))
        @foreach(Session::get('output') as $rslt)
            
        @endforeach
    @endif
@endsection

@section('scripts')
<script>
    var departments = null;
    var schools = null;

    $(document).ready(function(){
        $('#category').change(function(event){
            let cat = event.target.value;

            $('#entity').empty();
            let options = "<option></option>";

            if(cat == 3){
                for (const dep of departments) {
                    options += "<option id='"+dep.id+"'>";
                    options += dep.department_name + "("+ dep.department_code +")";
                    options += "</option>";
                }
            }else if(cat == 2){
                for (const sch of schools) {
                    options += "<option id='"+sch.id+"'>";
                    options += sch.school_name + "("+ sch.school_code +")";
                    options += "</option>";
                }
            }
            $('#entity').append(options);
        });
        $.ajax({
            url: 'fetch_entities',
            type:'post',
            headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            dataType:'json',
            success: function(response){
                console.log(response);
                schools = response.schools;
                departments = response.departments;
            },
            error: function(xhr,status,error){

            }
        });
    });
</script>
@endsection