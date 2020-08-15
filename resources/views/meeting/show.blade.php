@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="nav-wrapper p-0">
            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active mb-sm-3 mb-md-0 mt-md-2 mt-0 mt-lg-0" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="false">
                        <i class="fas fa-home mr-2"></i>About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 mt-md-2 mt-0 mt-lg-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                        <i class="fas fa-user mr-2"></i>Members & Attendence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 show mt-md-2 mt-0 mt-lg-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="true">
                        <i class="far fa-images mr-2"></i>History</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 mt-md-2 mt-0 mt-lg-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false"><i class="fas fa-newspaper mr-2"></i>Timeline</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-0 mb-md-0 mt-md-2 mt-0 mt-lg-0" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false"><i class="fas fa-cog mr-2"></i>More</a>
                </li> -->
            </ul>
        </div>
    </div>
    <div class="card-body">
        @if(Session::has('response'))
        <div id="response" class="bg-success p-1 text-center">
                <span class="text-white text-capitalize">{{Session::get('response')}}</span>
        </div>
        @endif
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <form action="{{url('update_general_meeting/'.$specificMeeting->meeting->id)}}" method="post">
                            @csrf
                            <div class="row p-2">
                                <div class="col-lg-3">
                                    <span class="text-lg">Meeting Title:</span>
                                </div>
                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-start">
                                        <input type="text" id="title" name="title" class="form-control text-left text-uppercase text-xl" value="{{$specificMeeting->meeting->meeting_title}}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    @if((!$specificMeeting->meeting->wasHeld()) && (Auth::User()->id == $specificMeeting->meeting->user_id))
                                    <div class="text-right p-2">
                                        <span id="edit-icon" class="text-right fab">
                                            <span class="fas fa-edit text-xl round-p5-ardhi color-ardhi hover-ardhi shadow"></span>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-3">
                                    <span class="text-lg">Meeting Date:</span>
                                </div>
                                <div class="col-lg-8">
                                    <input id="date" name="date" class="form-control datepicker text-lg" type="text" value="{{$specificMeeting->meeting->meeting_date}}" disabled>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-3">
                                    <span class="text-lg">Meeting Description:</span>
                                </div>
                                <div class="col-lg-8">
                                    <div>
                                        <textarea id="description" name="description" cols="30" rows="3" class="form-control text-left text-lg" disabled>
                                            {{$specificMeeting->meeting->meeting_description}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-3">
                                    <span class="text-lg">Meeting Type:</span>
                                </div>
                                <div class="col-lg-7">
                                    <span class="text-lg text-capitalize">{{$specificMeeting->meeting->meeting_type}} meeting</span>
                                </div>
                                <div class="col-lg-2">
                                    @if((!$specificMeeting->meeting->wasHeld()) && (Auth::User()->id == $specificMeeting->meeting->user_id))
                                    <div class="text-right">
                                        <input id="update-meeting" type="submit" value="update" class="btn btn-primary" hidden>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <div class="row p-2">
                            <div class="col-lg-3">
                                <label class="text-lg" for="chairman">Chairman</label>
                            </div>
                            <div class="col-lg-7">
                                <input type="text" id="chairman" value="{{($chair === null)? 'Not Selected': $chair->last_name.' '.$chair->first_name}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-lg-3">
                                <label class="text-lg" for="secretary">Secretary</label>
                            </div>
                            <div class="col-lg-7">
                                <input type="text" id="secretary" value="{{($secr === null)? 'Not Selected': $secr->last_name.' '.$secr->first_name}}" class="form-control" disabled>
                            </div>
                            <div class="col-lg-2">
                                @if((!$specificMeeting->meeting->wasHeld()) && (Auth::User()->id == $chair->id))
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Change</button>
                                @endif
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-lg-3"><span class="text-lg">Attachments:</span></div>
                            <div class="col-lg-9">
                                <div class="row">
                                    @if(sizeof($documents) !== 0)
                                        @foreach($documents as $document)
                                        <div class="col-lg-3">
                                            <div class="card shadow">
                                                <div class="document card-body">
                                                    <img src="{{ $document->icon($document->document_extension)}}" alt="document" />
                                                    <span onclick="downloadfile({{json_encode($document)}},{{json_encode(url('downloadfile'))}})">
                                                        <i class="fe fe-download"></i>
                                                    </span>
                                                </div>
                                                <div class="card-footer p-1">
                                                    <h3 class="text-capitalize text-center">{{$document->document_type}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    <div class="col-lg-9">
                                        <span class="text-lg text-red">No document found for this meeting.</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(($secr !== null) && ($secr->id == Auth::User()->id))
                        <div class="row p-2">
                            <div class="col-lg-12">
                                <div class="d-flex flex-column">
                                    <div class="h2">Add Attachments</div>
                                    <div id="attachments"  data-toggle="modal" data-target="#attachment-modal">
                                        <div id="create-attachment" class="hover-ardhi box-md border-ardhi">
                                            <span class="fas fa-plus"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Start of attendence tab content -->
            <div aria-labelledby="tabs-icons-text-2-tab" class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="d-flex flex-column h-100vh">
                            <!-- attendence list headings row-->
                            <div class="row">
                                <div class="col-lg-7">
                                    @if((!$specificMeeting->meeting->wasHeld()) && (Auth::User()->id == $chair->id))
                                    <div class="border-ardhi box-fit hover-ardhi cursor-default mb-3" data-toggle="modal" data-target="#largeModal">
                                        <span class="fas fa-plus-square text-xl text-black pl-1 pt-1"></span>
                                        <span class="p-2 font-weight-800">Invite Member</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-5">
                                    @if(($secr !== null) && ($secr->id == Auth::User()->id))
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-lg">Attendence</span>
                                                <input type="button" value="Submit All" class="btn btn-success" 
                                                onclick="submitAttendence({{json_encode($members)}},{{json_encode(url('create_attendence/'.$specificMeeting->meeting->id))}})">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="custom-switches-stacked">
                                                <label class="custom-switch">
                                                    <input type="radio" id="all-present" name="all-status" value="1" class="custom-switch-input">
                                                    <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                                    <span class="custom-switch-description row">All Present</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="custom-switches-stacked">
                                                <label class="custom-switch">
                                                    <input type="radio" id="all-abscent" name="all-status" value="2" class="custom-switch-input">
                                                    <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                                    <span class="custom-switch-description">All Abscent</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="custom-switches-stacked">
                                                <label class="custom-switch">
                                                    <input type="radio" id="all-missed" name="all-status" value="3" class="custom-switch-input">
                                                    <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                                    <span class="custom-switch-description">All Missed</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                    @else
                                    <div class="row text-center">
                                        <span class="text-lg text-center">Attendence</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!-- end of attendence list headings row-->

                            <!-- start of list of members -->
                            @foreach($members as $member)
                            <div class="border-bottom hover-normal p-2 cursor-default row">
                                <!-- column for member names and membership type -->
                                <div class="col-lg-7">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-capitalize">{{$member['profile']->last_name}}, {{$member['profile']->first_name}}
                                            @if($member['profile']->id == Auth::User()->id)
                                            <span class="text-uppercase bg-green text-white ml-2 p-1">you</span>
                                            @endif
                                        </span>
                                        @if(($chair !== null) && ($chair->id == $member['profile']->id))
                                        <span class="text-capitalize text-red">Chairman</span>
                                        @elseif(($secr !== null) && ($secr->id == $member['profile']->id))
                                        <span class="text-capitalize text-green">Secretary</span>
                                        @else
                                        <span class="text-capitalize">Member</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- end column form member name and membership type -->

                                <!-- column for member attendence status and attendence form -->
                                <div class="col-lg-5">
                                    <!-- start of attendence form seen by secretary alone -->
                                    @if(($secr !== null) && ($secr->id == Auth::User()->id))
                                    <form action="{{url('update_attendence/'.$specificMeeting->meeting->id)}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <span class="text-green">Present</span>
                                                <div class="custom-switches-stacked">
                                                    <label class="custom-switch">
                                                        @if(($member['attendence'] !== null) && ($member['attendence'] === 'attended'))
                                                        <input type="radio" name="{{$member['profile']->id}}" value="attended" class="custom-switch-input present" checked="" required>
                                                        @else
                                                        <input type="radio" name="{{$member['profile']->id}}" value="attended" class="custom-switch-input present" required>
                                                        @endif
                                                        <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <span class="text-purple">Abscent</span>
                                                <div class="custom-switches-stacked">
                                                    <label class="custom-switch">
                                                        @if(($member['attendence'] !== null) && ($member['attendence'] === 'missed'))
                                                        <input type="radio" name="{{$member['profile']->id}}" value="missed" class="custom-switch-input abscent" checked="" required>
                                                        @else
                                                        <input type="radio" name="{{$member['profile']->id}}" value="missed" class="custom-switch-input abscent" required>
                                                        @endif
                                                        <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <span class="text-red">Missed</span>
                                                <div class="custom-switches-stacked">
                                                    <label class="custom-switch">
                                                        @if(($member['attendence'] !== null) && ($member['attendence'] === 'noreport'))
                                                        <input type="radio" name="{{$member['profile']->id}}" value="noreport" class="custom-switch-input missed" checked="" required>
                                                        @else
                                                        <input type="radio" name="{{$member['profile']->id}}" value="noreport" class="custom-switch-input missed" required>
                                                        @endif
                                                        <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                @if($member['attendence'] == null)
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-red">Not Set</span>
                                                    <span>
                                                        <input type="submit" value="set" class="btn btn-default">
                                                    </span>
                                                </div>
                                                @else
                                                <input type="submit" value="update" class="btn btn-primary">
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <!-- end of attendence form seen by secretary -->

                                    <!-- attendence status as seen by all members -->
                                    <div class="text-center">
                                        @if(($member['attendence'] !== null) && ($member['attendence'] === 'attended'))
                                        <span class="text-green text-lg">Present</span>
                                        @elseif(($member['attendence'] !== null) && ($member['attendence'] === 'missed'))
                                        <span class="text-purple text-lg">Abscent</span>
                                        @elseif(($member['attendence'] !== null) && ($member['attendence'] === 'noreport'))
                                        <span class="text-red text-lg">Missed</span>
                                        @else
                                        <span class="text-lg">Not Set</span>
                                        @endif
                                    </div>
                                    <!-- end of attendence status as seen by all members -->
                                    @endif
                                </div>
                                <!-- end of column for attendence status and attendence form -->
                            </div>
                            @endforeach
                            <!-- end of list of members -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of attendence tab content -->
            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
               								
            </div>
            <!-- <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                
            </div>
            <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">

            </div> -->
        </div>
        <!-- end tab-content -->

    </div>
</div>

<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url($resources['urls']['change_secretary'].$specificMeeting->id)}}" method="post">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="modal-title-default">Select Secretary</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($members as $member)
                    <div class="border-bottom hover-normal p-2 cursor-default">
                        <p class="font-weight-700"></p>
                        <div class="d-flex justify-content-between">
                            @if(($chair !== null) && ($chair->id == $member['profile']->id))
                            <span class="text-capitalize text-red">{{$member['profile']->first_name}}, {{$member['profile']->last_name}}</span>
                            <span class="text-capitalize text-red">Chairman</span>
                            @else
                            <label class="custom-switch">
                                <input type="radio" name="secretary" value="{{$member['profile']->id}}" class="custom-switch-input">
                                <span class="custom-switch-indicator mr-3"></span>
                                <span class="custom-switch-description text-capitalize">{{$member['profile']->first_name}}, {{$member['profile']->last_name}}</span>
                            </label>
                            <span class="text-capitalize">Member</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" id="close-change-secretary" class="btn btn-default  ml-auto" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="largeModalLabel">Select Members</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">A small river named Duden flows by their place and supplies it with the necessary regelialiaxx.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add Members</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="attachment-modal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="attachment-modal-label">Upload File</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('store_meeting_documents').'/'.$specificMeeting->meeting->id}}" method="post" id="upload-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow">
                                <div class="card-body">
                                    <input type="file" id="file-upload" name="file-upload" class="dropify" data-height="300" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card h-75">
                                <div class="card-header">
                                    <h2>Select File Type</h2>
                                    <input type="text" name="meeting_id" value="{{$specificMeeting->meeting->id}}" hidden>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column justify-content-center h-100">
                                        <input type="radio" name="file-type" value="none" class="d-none" checked>
                                        <label class="custom-switch">
                                            <input type="radio" name="file-type" value="agenda" class="custom-switch-input">
                                            <span class="custom-switch-indicator mr-3"></span>
                                            <span class="custom-switch-description text-capitalize">Agenda</span>
                                        </label>
                                        <label class="custom-switch">
                                            <input type="radio" name="file-type" value="minutes" class="custom-switch-input">
                                            <span class="custom-switch-indicator mr-3"></span>
                                            <span class="custom-switch-description text-capitalize">Minutes</span>
                                        </label>
                                        <label class="custom-switch">
                                            <input type="radio" name="file-type" value="matter_arising" class="custom-switch-input">
                                            <span class="custom-switch-indicator mr-3"></span>
                                            <span class="custom-switch-description text-capitalize">Matter Arising</span>
                                        </label>
                                        <label class="custom-switch">
                                            <input type="radio" name="file-type" value="other" class="custom-switch-input">
                                            <span class="custom-switch-indicator mr-3"></span>
                                            <span class="custom-switch-description text-capitalize">Other</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="close-upload" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="upload" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</div>
<input type="button" value="" id="alert-type" hidden>
<input type="button" value="" id="alert-title" hidden>
<input type="button" value="" id="alert-timer" hidden>
@endsection

@section('scripts')
    <script>
		$('.dropify').dropify({
			messages: {
				'default': 'Drag and drop a file here or click',
				'replace': 'Drag and drop or click to replace',
				'remove': 'Remove',
				'error': 'Ooops, something wrong appended.'
			},
			error: {
				'fileSize': 'The file size is too big (2M max).'
			}
		});

        $(document).ready(function(){
        
            $('.datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                autoclose: true,
                format: "yyyy/mm/dd"
            });

            $('#upload').click(function(){
                let file = filetype();
                if(file.isSet){
                    $("#upload-form").trigger("submit");
                    $("#file-upload").val("");
                    $("#close-upload").trigger('click');
                    clearAlert();
                }
            });

            $('input:radio[name=all-status]').change(function(){
                if($('#all-present').is(':checked')){
                    $('.present').prop('checked',true);
                }
                if($('#all-abscent').is(':checked')){
                    $('.abscent').prop('checked',true);
                }
                if($('#all-missed').is(':checked')){
                    $('.missed').prop('checked',true);
                }
            });

            $('#edit-icon').click(function(){
                enableform();
            });
        });
        
        const enableform = () =>{
            $('#title').removeAttr('disabled');
            $('#date').removeAttr('disabled');
            $('#description').removeAttr('disabled');
            $('#update-meeting').removeAttr('hidden');
        }

        const disableform = () =>{
            $('#title').addAttr('disabled');
            $('#date').addAttr('disabled');
            $('#description').addAttr('disabled');

        }

        const submitAttendence = (members,path) => {
            let data = {
                "attended": Array(), "missed":Array(), "noreport":Array()
            }
            for (const member of members) {
                let attendence = $('input[name=' + member.id + ']:checked').val();

                if(attendence == 'attended'){
                    data.attended.push(member.id); 
                }else if(attendence == 'missed'){
                    data.missed.push(member.id);
                }else if(attendence == 'noreport'){
                    data.noreport.push(member.id);
                }
            }

            postdata(data,path);
        }
        const postdata = (data,path) => {
            $.ajax({
                url: path,
                type:'post',
                headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: {'data':data},
                dataType:'json',
                success: function(response){
                    showSuccess('Recorded Successfully!!');
                    $('#but4').trigger('click');
                    $('#close-attendence').trigger('click');
                },
                error: function(xhr,status,error){

                }
            });
        }

        const downloadfile = (document,path) => {
            $.ajax({
                url: path,
                type:'post',
                headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: {'document':document},
                dataType:'json',
                success: function(response){
                    console.log(response);
                },
                error: function(xhr,status,error){

                }
            });
        }

        const filetype = () => {
            let file = $("input[name=file-type]:checked").val();
            if(file === 'none'){
                setAlert({title:"File Type Not Selected",
                            type: "warning",
                            timer: 2000});
                $('#but4').trigger('click');

                return {isSet:false};
            }else{
                return {isSet:true};
            }

        }
        const createAttachment = () =>{
            let att = '<div class="col-lg-3">';
                    att += '<div class="card">';
                        att  +=  '<div class="card-body">';
                            att  +=  '<input type="file" class="dropify" data-height="150" />';
                        att  +=  '</div>';
                    att += '</div>';    
            att  +=  '</div>';
            return att;
        }
	</script>
@endsection