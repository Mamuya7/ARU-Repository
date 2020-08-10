@extends('layouts.app')

@section('content')
<div class="card p-0 m-1">
    <div class="card-header">
        <h1 class="text-center p-0 m-0">{{$title}}</h1>
    </div>
</div>
<div>
    @if(Session::has('output'))
    <div class="bg-success p-1">
            <span class="text-white">{{Session::get('output')}}</span>
    </div>
    @endif
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
                @if(Auth::User()->hasBothRoles('head','dean'))
                <div class="pt-0 pr-3 pl-3 pb-3">
                    <label for="chairman">Chairman As</label>
                    <select name="chairman" id="chairman" class="form-control">
                        <option value="null" selected disabled></option>
                        <option value="1">Head</option>
                        <option value="2">Dean</option>
                    </select>
                </div>
                @endif
                @if(Auth::User()->hasRole('system administrator'))
                <div class="pt-0 pr-3 pl-3 pb-3">
                    <label for="chairman">Meeting type</label>
                    <select name="meeting_type" id="meeting_type" class="form-control">
                        <option value="null" selected disabled></option>
                        <option value="accademic_department">Accademic Departmental Meeting</option>
                        <option value="administrative_department">Administartive Departmental Meeting</option>
                        <option value="school">School Meeting</option>
                        <option value="directorate">Directorate Meeting</option>
                        <option value="committee">Committee Meeting</option>
                    </select>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group mb-0 pt-0 pr-3 pl-3 pb-3">
                            <label for="description">Date</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input id="date" name="date" class="form-control datepicker" placeholder="Select date" type="text" value="{{ date('Y/m/d')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="pt-0 pr-3 pl-3 pb-3">
                            <label for="time">Time</label>
                            <input type="time" id="time" name="time" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-label mb-3">Select Secretary</div>
                <div class="card pt-3 mt-0">
                    <div id="staffs" class="custom-switches-stacked">
                        @if(Auth::User()->hasRole('head'))
                            @foreach($staffs as $staff)
                            <label class="custom-switch">
                                <input type="radio" name="secretary" value="{{$staff->user_id}}" class="custom-switch-input">
                                <span class="custom-switch-indicator mr-3"></span>
                                <span class="custom-switch-description">{{$staff->first_name.' '.$staff->last_name}}</span>
                            </label>
                            @endforeach
                        @endif
                    </div>{{json_encode($heads)}}
                    <div id="heads" class="custom-switches-stacked {{$display}}">
                        @if(Auth::User()->hasRole('dean'))
                            @foreach($heads as $head)
                            <label class="custom-switch">
                                <input type="radio" name="secretary" value="{{$head->user_id}}" class="custom-switch-input">
                                <span class="custom-switch-indicator mr-3"></span>
                                <span class="custom-switch-description">{{$head->first_name.' '.$head->last_name}}</span>
                            </label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3 text-right">
            <input type="submit" value="Create" class="btn btn-warning">
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // var department_members = null;
    // var school_members = null;

    $(document).ready(function(){
        $('#chairman').change(function(event){
            let chair = event.target.value;

            // $('#members').empty();
            // members = "";
            if(chair == 1){
                $('#staffs').show();
                $('#heads').hide();
                // for (const dep of department_members) {
                //     members += member(dep.user_id,dep.first_name +" "+ dep.last_name);
                // }
            }else if(chair == 2){
                $('#staffs').hide();
                $('#heads').removeClass('d-none');
                $('#heads').show();
                // for (const sch of school_members) {
                //     members += member(sch.user_id,sch.department_name +" "+ sch.department_code);
                // }
            }
            // $('#members').append(members);
        });

        
		$('.datepicker').datepicker({
		 showOtherMonths: true,
		 selectOtherMonths: true,
        autoclose: true,
        format: "yyyy/mm/dd"
	   });
    });

    // const member = (id,name) => {
    //     let memb =   '<label class="custom-switch">';
    //             memb +=  '<input type="radio" name="secretary" value="'+id+'" class="custom-switch-input">';
    //             memb +=  '<span class="custom-switch-indicator mr-3"></span>';
    //             memb +=  '<span class="custom-switch-description">'+name+'</span>';
    //         memb +=  '</label>';
    //     return memb;
    // }
</script>
@endsection