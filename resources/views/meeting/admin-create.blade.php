@extends('layouts.admin')

@section('content')
<input type="text" value="{{url('').'/'}}" id="url" hidden>
<div class="card p-0 m-1">
    <div class="card-content">
        <form action="store_meeting" method="post">
            {{csrf_field()}}
            <div class="card-header">
                <h1 class="text-center p-0 m-0">{{$title}}</h1>
            </div>
            <div class="card-body">
                @if(Session::has('output'))
                <div class="{{Session::get('color')}} text-center p-1">
                        <span class="text-white text-capitalize">{{Session::get('output')}}</span>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-8">
                        <div class="pt-0 pr-3 pl-3 pb-3">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" value="{{old('title')}}" class="form-control">
                        </div>
                        <div class="pt-0 pr-3 pl-3 pb-3">
                            <label for="description">Description</label>
                            <textarea id="description" cols="30" rows="8" name="description" value="{{old('description')}}" class="form-control"></textarea>
                        </div>
                        <div class="pt-0 pr-3 pl-3 pb-3">
                            <label for="meeting_type">Meeting type</label>
                            <select name="meeting_type" id="meeting_type" class="form-control" required>
                                <option value="null" selected disabled></option>
                                <option value="accademic">Accademic Departmental Meeting</option>
                                <option value="administrative">Administartive Departmental Meeting</option>
                                <option value="school">School Meeting</option>
                                <option value="directorate">Directorate Meeting</option>
                                <option value="committee">Committee Meeting</option>
                            </select>
                        </div>
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
                                    <input type="time" id="time" name="time" class="form-control" value="09:00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card pt-3 mt-0">
                            <div class="card-header">
                                <span id="type-title" class="text-xl text-capitalize">Meeting</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="custom-switches-stacked" id="meeting-units">
                                    <span class="text-xl text-red text-center p-4">Meeting Type Not Selected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="p-3 text-right">
                    <input type="submit" value="Create" class="btn btn-warning">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        $("#meeting_type").change(function(event){
            let path = $("#url").val();

            $('#type-title').empty();

            if(event.target.value === "accademic"){
                path += "fetch_academic_departments";
                $('#type-title').text("Select Academic Departments for the Meeting");
            }else if(event.target.value === "administrative"){
                path += "fetch_administrative_departments";
                $('#type-title').text("Select Administrative Departments for the Meeting");
            }else if(event.target.value === "school"){
                path += "fetch_schools";
                $('#type-title').text("Select Schools for the Meeting");
            }else if(event.target.value === "directorate"){
                path += "fetch_directorates";
                $('#type-title').text("Select Directorates for the Meeting");
            }else if(event.target.value === "committee"){
                path += "fetch_committees";
                $('#type-title').text("Select Committees for the Meeting");
            }

            requestServerPost(path,null,function(response){
                let list = createCheckbox("all",null,"all-check");

                response.forEach(element => {
                    let name = element.name + " ("+element.code+")"
                    list += createCheckbox(name,element.id);
                });

                $('#meeting-units').empty();
                $('#meeting-units').append(list);

                $("#all-check").on("change",function(){
                    if($(this).is(':checked')){
                        $('.types').prop('checked',true);
                    }else{
                        $('.types').prop('checked',false);
                    }
                });

                $('.types').on("change",function(){
                    if($('.types').not(':checked').length > 0){
                        $('#all-check').prop('checked',false);
                    }
                    if($('input[name=typeid[]]:checked').length === $('input[name=typeid[]]').length){
                        $('#all-check').prop('checked',true);
                    }
                });

                // $('#all-check').trigger("click");
            });
        });

        $('.datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            format: "yyyy/mm/dd"
        });
    });

    
        const requestServerPost = (path,data,method) => {
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

        const createCheckbox = (name = " ",value = null, id = null) =>{
            let id_att = (id === null)? " ":'id="'+id+'"';
            let name_att = (id === null)? 'name="typeid[]"' : ' ';
            
            let list = '<label class="custom-switch m-1">';
                    list += '<input type="checkbox" '+name_att+' '+id_att+' value="'+value+'" class="types custom-switch-input">';
                    list += '<span class="custom-switch-indicator custom-switch-indicator-square mr-3"></span>';
                    list += '<span class="custom-switch-description text-capitalize text-lg">'+name+'</span>';
                list += '</label>';
            return list;
        }
</script>
@endsection