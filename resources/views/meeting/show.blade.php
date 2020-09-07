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
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                @if(Session::has('response'))
                <div id="response" class="bg-success p-1 text-center">
                        <span class="text-white text-capitalize">{{Session::get('response')}}</span>
                </div>
                @endif
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <form action="{{url('update_general_meeting/'.$resources['specificMeeting']->meeting_id)}}" method="post">
                            @csrf
                            <div class="row p-2">
                                <div class="col-lg-3">
                                    <span class="text-lg">Meeting Title:</span>
                                </div>
                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-start">
                                        <input type="text" id="title" name="title" class="form-control text-left text-uppercase text-xl" value="{{$resources['specificMeeting']->meeting->meeting_title}}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    @if((!$resources['specificMeeting']->meeting->wasHeld()) && (Auth::User()->id == $resources['specificMeeting']->meeting->user_id))
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
                                    <input id="date" name="date" class="form-control datepicker text-lg" type="text" value="{{$resources['specificMeeting']->meeting->meeting_date}}" disabled>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-3">
                                    <span class="text-lg">Meeting Description:</span>
                                </div>
                                <div class="col-lg-8">
                                    <div>
                                        <textarea id="description" name="description" cols="30" rows="3" class="form-control text-left text-lg" disabled>{{
                                            $resources['specificMeeting']->meeting->meeting_description
                                        }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-3">
                                    <span class="text-lg">Meeting Type:</span>
                                </div>
                                <div class="col-lg-7">
                                    <span class="text-lg text-capitalize">{{$resources['specificMeeting']->meeting->meeting_type}} meeting</span>
                                </div>
                                <div class="col-lg-2">
                                    @if((!$resources['specificMeeting']->meeting->wasHeld()) && (Auth::User()->id == $resources['specificMeeting']->meeting->user_id))
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
                                <input type="text" id="chairman" value="{{($resources['chairman'] === null)? 'Not Selected': $resources['chairman']->last_name.' '.$resources['chairman']->first_name}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-lg-3">
                                <label class="text-lg" for="secretary">Secretary</label>
                            </div>
                            <div class="col-lg-7">
                                <input type="text" id="secretary" value="{{($resources['secretary'] === null)? 'Not Selected': $resources['secretary']->last_name.' '.$resources['secretary']->first_name}}" class="form-control" disabled>
                            </div>
                            <div class="col-lg-2">
                                @if((!$resources['specificMeeting']->meeting->wasHeld()) && ($resources['chairman'] !== null) && (Auth::User()->id == $resources['chairman']->id))
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Change</button>
                                @endif
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-lg-3"><span class="text-lg">Attachments:</span></div>
                            <div class="col-lg-9">
                                <div class="row">
                                    @if(sizeof($resources['documents']) !== 0)
                                        @foreach($resources['documents'] as $document)
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
                        @if(($resources['secretary'] !== null) && ($resources['secretary']->id == Auth::User()->id))
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
                                    @if((!$resources['specificMeeting']->meeting->wasHeld()) && ($resources['chairman'] !== null) && (Auth::User()->id == $resources['chairman']->id))
                                    <div id="invite" onclick="inviteMembers({{json_encode(url('invitation_details'))}})" class="border-ardhi box-fit hover-ardhi cursor-default mb-3" data-toggle="modal" data-target="#largeModal">
                                        <span class="fas fa-plus-square text-xl text-black pl-1 pt-1"></span>
                                        <span class="p-2 font-weight-800">Invite Member</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-5">
                                    @if(($resources['secretary'] !== null) && ($resources['secretary']->id == Auth::User()->id))
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-lg">Attendence</span>
                                                <input type="button" value="Submit All" class="btn btn-success" onclick="submitAttendence({{$resources['urls']['set_attendence']}},{{json_encode($resources['members'])}})">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="custom-switches-stacked">
                                                <label class="custom-switch">
                                                    <input type="radio" id="all-present" name="all-status" value="1" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description row">All Present</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="custom-switches-stacked">
                                                <label class="custom-switch">
                                                    <input type="radio" id="all-abscent" name="all-status" value="2" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">All Abscent</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="custom-switches-stacked">
                                                <label class="custom-switch">
                                                    <input type="radio" id="all-missed" name="all-status" value="3" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
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
                            @foreach($resources['members'] as $member)
                            <div class="border-bottom hover-normal p-2 cursor-default row">
                                <!-- column for member names and membership type -->
                                <div class="col-lg-7">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-capitalize">{{$member['profile']->last_name}}, {{$member['profile']->first_name}}
                                            @if($member['profile']->id == Auth::User()->id)
                                            <span class="text-uppercase bg-green text-white ml-2 p-1">you</span>
                                            @endif
                                        </span>
                                        @if(($resources['chairman'] !== null) && ($resources['chairman']->id == $member['profile']->id))
                                        <span class="text-capitalize text-red">Chairman</span>
                                        @elseif(($resources['secretary'] !== null) && ($resources['secretary']->id == $member['profile']->id))
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
                                    @if(($resources['secretary'] !== null) && ($resources['secretary']->id == Auth::User()->id))
                                    <form action="{{$resources['urls']['update_attendence']}}" method="post">
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
                                                        <span class="custom-switch-indicator"></span>
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
                                                        <span class="custom-switch-indicator"></span>
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
                                                        <span class="custom-switch-indicator"></span>
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
                                                <input type="button" value="update" class="btn btn-primary" onclick="updateAttendence({{$resources['urls']['update_attendence']}},{{json_encode($member['profile'])}})">
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
                            <div class="border-bottom border-ardhi p-0 mt-2"></div>
                            <!-- start of list of invitations -->
                            @foreach($resources['invites'] as $invite)
                                <div class="border-bottom p-2 cursor-default row">
                                    <!-- column for member names and membership type -->
                                    <div class="col-lg-7">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-capitalize">{{$invite['profile']->last_name}}, {{$invite['profile']->first_name}}</span>
                                            
                                            <span class="text-capitalize color-ardhi">Invitee</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="text-center">
                                            
                                            <div class="d-flex justify-content-around">
                                                <span class="text-capitalize">As <strong>{{$invite['role']->role_code}}</strong></span>
                                                
                                                @if(!$resources['specificMeeting']->meeting->wasHeld())
                                                    @if(($resources['chairman'] !== null) && ($resources['chairman']->id == Auth::User()->id))
                                                        <form action="{{$resources['urls']['remove_invitation'].$invite['invitation']->id}}" method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-icon btn-danger mt-1 mb-1" type="submit">
                                                                <span class="btn-inner--icon"><i class="fe fe-trash-2"></i></span>
                                                                <span class="btn-inner--text">Remove</span>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end column form member name and membership type -->
                                </div>
                            @endforeach
                            <!-- end of list of invitations -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of attendence tab content -->
            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
               								
            </div>
        </div>
        <!-- end tab-content -->

    </div>
</div>

<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url($resources['urls']['change_secretary'])}}" method="post">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="modal-title-default">Select Secretary</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($resources['members'] as $member)
                    <div class="border-bottom hover-normal p-2 cursor-default">
                        <p class="font-weight-700"></p>
                        <div class="d-flex justify-content-between">
                            @if(($resources['chairman'] !== null) && ($resources['chairman']->id == $member['profile']->id))
                            <span class="text-capitalize text-red">{{$member['profile']->first_name}}, {{$member['profile']->last_name}}</span>
                            <span class="text-capitalize text-red">Chairman</span>
                            @elseif(($resources['secretary'] !== null) && ($resources['secretary']->id == $member['profile']->id))
                            <span class="text-capitalize text-green">{{$member['profile']->first_name}}, {{$member['profile']->last_name}}</span>
                            <span class="text-capitalize text-green">Secretary</span>
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
                <div class="row p-1">
                    <div class="col-lg-4">
                        <span class="row text-left">Filter By</span></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-end">
                            <span><input type="search" name="" id="search-field" class="form-control" placeholder="search...."></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="d-flex flex-column">
                            <span>Departments</span>
                            <span>
                                <select name="" id="filterby-department" class="form-control" onchange="filterby({{json_encode(url('department_staff/'))}},'#filterby-department')">
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex flex-column">
                            <span>Directorates</span>
                            <span>
                                <select name="" id="filterby-directorate" class="form-control" onchange="filterby({{json_encode(url('directorate_staff/'))}},'#filterby-directorate')">
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex flex-column">
                            <span>Committees</span>
                            <span>
                                <select name="" id="filterby-committee" class="form-control" onchange="filterby({{json_encode(url('committee_staff/'))}},'#filterby-committee')">
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex flex-column">
                            <span>Role Types</span>
                            <span>
                                <select name="" id="filterby-roletype" class="form-control" onchange="filterbyRole({{json_encode(url('roles_staff/'))}},'#filterby-roletype')">
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row card p-0">
                    <div class="card-header m-0">
                        <div class="row border-bottom p-1">
                            <div class="col-lg-2">
                                <div class="custom-switches-stacked">
                                    <label class="custom-switch">
                                        <input type="checkbox" id="invites-check" value="1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-square"></span>
                                        <span class="custom-switch-description">All</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <span class="text-lg">First Name</span>
                            </div>
                            <div class="col-lg-3">
                                <span class="text-lg">Last Name</span>
                            </div>
                            <div class="col-lg-3">
                                <span class="text-lg">Invite by Role</span>
                            </div>
                        </div>
                    </div>
                    <div style="height: 350px; overflow:auto;" class="card-body p-0 m-0" id="invitation-list">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveInvitation({{$resources['urls']['invitation_link']}})">Invite Members</button>
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
                <form action="{{url('store_meeting_documents').'/'.$resources['specificMeeting']->meeting->id}}" method="post" id="upload-form" enctype="multipart/form-data">
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
                                    <input type="text" name="meeting_id" value="{{$resources['specificMeeting']->meeting->id}}" hidden>
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

        var users = Array();

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

            $('#search-field').keyup(function(event){
                let letters = event.target.value;
                $('#invitation-list').empty();
            
                users.forEach(row => {
                    if(letters.trim().length !== 0){
                        if(matchesCriteria(row,letters)){
                            let list = createInvitationList(row);;
                            $('#invitation-list').append(list);
                        }
                    }else{
                        let list = createInvitationList(row);
                        $('#invitation-list').append(list);
                    }
                });
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

            $('.invites').change(function(){console.log('hello');
                if($('input.invites').not(':checked').length > 0){
                    $('#invites-check').prop('checked',false);
                }
            });
            $('#invites-check').change(function(){
                if($(this).is(':checked')){
                    $('.invites').prop('checked',true);
                }else{
                    $('.invites').prop('checked',false);
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

        const submitAttendence = (path,members) => {
            let data = {
                "attended": Array(), "missed":Array(), "noreport":Array()
            }
            for (const member of members) {
                let attendence = $('input[name=' + member.profile.id + ']:checked').val();

                if(attendence == 'attended'){
                    data.attended.push(eval(member.profile.id)); 
                }else if(attendence == 'missed'){
                    data.missed.push(eval(member.profile.id));
                }else if(attendence == 'noreport'){
                    data.noreport.push(eval(member.profile.id));
                }
            }

            postdata(data,path,function(response){
                location.reload();
            });
        }

        const updateAttendence = (path,member) => {

            let status = $('input[name=' + member.id + ']:checked').val();

            let data = {
                "user_id": member.id, "status": status
            }


            postdata(data,path,function(response){
                location.reload();
            });
        }
        const postdata = (data,path,method) => {
            $.ajax({
                url: path,
                type:'post',
                headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: {'data':data},
                dataType:'json',
                success: function(response){
                    method(response);
                },
                error: function(xhr,status,error){

                }
            });
        }
        const getdata = (path,package,method) => {
            $.ajax({
                url: path,
                type:'post',
                headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data:{"data":package},
                dataType:'json',
                success: function(response){
                    method(response);
                },
                error: function(xhr,status,error){

                }
            });
        }

        const saveInvitation = (path) =>{
            invites = Array();
            $('input[name=invitation]:checked').each(function () {
                invites.push({"user_id" : this.value, "role_id" : $('#role'+this.value).val()});
            });
            postdata(invites,path,function(results){
                location.reload();
            });
        }

// function to fetch members from database by selected criteria 
        const filterby = (path,element) =>{
            let id = $(element).val();
            path +="/"+ id;

            getdata(path,null,function(data){
                users = data;
                showInvitationList(data);
            });
        }
        const filterbyRole = (path,element) =>{
            let type = $(element).val();

            getdata(path,type,function(data){
                users = data;
                showInvitationList(data);
            });
        }

        const inviteMembers = (path) =>{
            getdata(path,null,function(data){
                let users_list = "";
                users = data.users;
                showInvitationList(data.users);

                let dep_list = ""; let dir_list = ""; let com_list = ""; let role_list = "";
                dep_list = createDepartmentOptions(data.departments);
                dir_list = createDirectorateOptions(data.directorates);
                com_list = createCommitteeOptions(data.committees);
                role_list = createRoleOptions(data.roletypes);

                $('#filterby-department').empty();
                $('#filterby-department').append(dep_list);

                $('#filterby-directorate').empty();
                $('#filterby-directorate').append(dir_list);

                $('#filterby-committee').empty();
                $('#filterby-committee').append(com_list);

                $('#filterby-roletype').empty();
                $('#filterby-roletype').append(role_list);
                
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
        
        function matchesCriteria(row,letters){
            if(isMatched(row.user.first_name.toLowerCase(),letters.trim().toLowerCase())){
                return true;
            }else if(isMatched(row.user.last_name.toLowerCase(),letters.trim().toLowerCase())){
                return true;
            }else if(isMatched(row.user.username.toLowerCase(),letters.trim().toLowerCase())){
                return true;
            }else{
                row.roles.forEach(role => {
                    if(isMatched(role.role_name.toLowerCase(),letters.trim().toLowerCase())){
                        return true;
                    }else if(isMatched(role.role_type.toLowerCase(),letters.trim().toLowerCase())){
                        return true;
                    }
                });
                return false;
            }
            return false;
        }

        function isMatched(word,letters){
            if(word.search(letters) >= 0){
                return true;
            }else{
                return false;
            }
            return false;
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

        const createDepartmentOptions = (departments) =>{
            let data = '<option value="">All Departments</option>';
            departments.forEach(dep => {
                data += '<option value="' + dep.id + '">';
                data += dep.department_name + '('+dep.department_code+')</option>';
            });
            return data;
        }
        const createDirectorateOptions = (directorates) =>{
            let data = '<option value="">All Directorates</option>';
            directorates.forEach(dir => {
                data += '<option value="' + dir.id + '">';
                data += dir.directorate_name + '('+dir.directorate_code+')</option>';
            });
            return data;
        }
        const createCommitteeOptions = (committees) =>{
            let data = '<option value="">All Committees</option>';
            committees.forEach(com => {
                data += '<option value="' + com.id + '">';
                data += com.committee_name + '('+com.committee_code+')</option>';
            });
            return data;
        }
        const createRoleOptions = (roles) =>{
            let data = '<option value="">All Roles</option>';
            roles.forEach(role => {
                data += '<option value="' + role.role_type + '">';
                data += '<span class="text-capitalize">' + role.role_type + '</span></option>';
            });
            return data;
        }
        const createInvitationList = (person) =>{
            
            let list = '<div class="row border-bottom p-1">';
                list +=    '<div class="col-lg-2">';
                list +=        '<div class="custom-switches-stacked">';
                list +=            '<label class="custom-switch">';
                list +=                '<input type="checkbox" name="invitation" value="'+person.user.id+'" class="invites custom-switch-input">';
                list +=                '<span class="custom-switch-indicator custom-switch-indicator-square"></span>';
                list +=            '</label>';
                list +=        '</div>';
                list +=    '</div>';
                list +=    '<div class="col-lg-3"><span>'+person.user.first_name+'</span></div>';
                list +=    '<div class="col-lg-3"><span>'+person.user.last_name+'</span></div>';
                list +=    '<div class="col-lg-3">';
                list +=            '<div>';
                list +=                '<select name="role'+person.user.id+'" id="role'+person.user.id+'" class="form-control">';
                                            person.roles.forEach(role => {
                                                if(role.role_type == 'staff'){
                list +=                    '<option value="'+role.id+'" selected>'+role.role_name+" (" +role.role_code+')</option>';
                                                }else{
                list +=                    '<option value="'+role.id+'">'+role.role_name+" (" +role.role_code+')</option>';
                                                }
                                            });
                list +=                '</select>';
                list +=            '</div>';
                list +=        '</div>';
                list +=    '</div>';

            return list;
        }

        const showInvitationList = (data) =>{
            let users_list = "";
            data.forEach(element => {
                    users_list += createInvitationList(element);
                });
                $('#invitation-list').empty();
                $('#invitation-list').append(users_list);
        }
	</script>
@endsection