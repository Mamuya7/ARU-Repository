@extends('layouts.app')

@section('content')
<div>
    <form id="search-form" action="{{$resources['urls']['search_path']}}" method="post">
        @csrf
        <div class="row p-3">
            <input type="search" name="search" id="search" class="form-control" value="{{old('search')}}" placeholder="search.....">
        </div>
        <div class="row pl-3 pr-3">
            <div class="col-lg-6 c0l-md-6 col-sm-6 col-xs-6">
                <div class="row d-flex justify-content-around">
                    <span>
                        <label class="custom-switch btn-pill btn-default p-3 mb-1">
                            <input type="radio" name="unit-filter" value="all" class="custom-switch-input" {{((old('unit-filter') === 'all') || ((old('unit-filter') === null)))? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">All</span>
                        </label>
                    </span>
                    <span>
                        <label class="custom-switch btn-pill btn-default p-3 mb-1">
                            <input type="radio" name="unit-filter" value="department" class="custom-switch-input" {{(old('unit-filter') === 'department')? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">Departmental</span>
                        </label>
                    </span>
                    @if(Auth::User()->hasRoleType('director') || (Auth::User()->hasRoleType('head') && Auth::User()->department()->belongsToDirectorate()))
                    <span>
                        <label class="custom-switch btn-pill btn-default p-3 mb-1">
                            <input type="radio" name="unit-filter" value="directorate" class="custom-switch-input" {{(old('unit-filter') === 'directorate')? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">Directorate</span>
                        </label>
                    </span>
                    @endif
                    @if(Auth::User()->hasRoleType('dean') || (Auth::User()->hasRoleType('head') && Auth::User()->department()->belongsToSchool()))
                    <span>
                        <label class="custom-switch btn-pill btn-default p-3 mb-1">
                            <input type="radio" name="unit-filter" value="school" class="custom-switch-input" {{(old('unit-filter') === 'school')? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">School</span>
                        </label>
                    </span>
                    @endif
                    @if(Auth::User()->isCommitteeMember())
                    <span>
                        <label class="custom-switch btn-pill btn-default p-3 mb-1">
                            <input type="radio" name="unit-filter" value="committee" class="custom-switch-input" {{(old('unit-filter') === 'committee')? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">Committee</span>
                        </label>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 c0l-md-6 col-sm-6 col-xs-6">
                <div class="row d-flex justify-content-around">
                    <span>
                        <label class="custom-switch btn-pill btn-secondary p-3 mb-1">
                            <input type="radio" name="time-filter" value="all" class="custom-switch-input" {{((old('time-filter') === 'all') || ((old('unit-filter') === null)))? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">All</span>
                        </label>
                    </span>
                    <span>
                        <label class="custom-switch btn-pill btn-secondary p-3 mb-1">
                            <input type="radio" name="time-filter" value="past" class="custom-switch-input" {{(old('time-filter') === 'past')? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">Past</span>
                        </label>
                    </span>
                    <span>
                        <label class="custom-switch btn-pill btn-secondary p-3 mb-1">
                            <input type="radio" name="time-filter" value="today" class="custom-switch-input" {{(old('time-filter') === 'today')? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">Today</span>
                        </label>
                    </span>
                    <span>
                        <label class="custom-switch btn-pill btn-secondary p-3 mb-1">
                            <input type="radio" name="time-filter" value="coming" class="custom-switch-input" {{(old('time-filter') === 'coming')? "checked":""}}>
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize text-white">Coming</span>
                        </label>
                    </span>
                </div>
            </div>
        </div>
    </form>
    <div>
        @if(Session::has('noresult'))
            <div class="card mt-5">
                <div class="card-header">
                    <div class="text-lg text-center">{{Session::get('noresult')}}</div>
                </div>
            </div>
        @endif

        @if($resources['meetings'])
            @foreach($resources['meetings'] as $meeting)
        <form action="show_meeting/{{$meeting->meeting_id}}" method="post" class="cursor-default meeting">
        @csrf
        <div class="card hover-text p-2 m-1">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <span class="text-lg text-uppercase border-bottom">{{$meeting->meeting_title}}</span>
                    <div>{{$meeting->meeting_description}}</div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                    <div class="d-flex justify-content-around">
                        <span class="text-lg">{{$meeting->meeting_date}}</span>
                        @if($meeting->meeting_type === 'department')
                        <span class="text-lg">DEP</span>
                        @elseif($meeting->meeting_type === 'school')
                        <span class="text-lg">SCH</span>
                        @elseif($meeting->meeting_type === 'directorate')
                        <span class="text-lg">DIR</span>
                        @elseif($meeting->meeting_type === 'committee')
                        <span class="text-lg">COM</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </form>
            @endforeach
        @endif
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.meeting').click(function(){
                $(this).trigger('submit');
            });

            $('#search').keyup(function(event){
                if(event.keyCode === 13){
                    $('#search-form').trigger('submit');
                }
            });
            $('input[name=unit-filter]').change(function(){
                $('#search-form').trigger('submit');
            });
            $('input[name=time-filter]').change(function(){
                $('#search-form').trigger('submit');
            });
        });


        const sendPostRequest = (path,data,method) => {
            $.ajax({
                url:path,
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data:{'data':data},
                dataType:'json',
                success:function(response){
                    method(response);
                },
                error:function(xhr,status,err){

                }
            });
        }
        const searchMeetings = (url) =>{
            if(event.keyCode === 13){
                sendPostRequest(url,event.target.value,function(result){
                    console.log(result);
                });
            }
        }
    </script>
@endsection