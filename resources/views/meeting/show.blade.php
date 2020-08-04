@extends('layouts.app')

@section('content')
<span class="fas fa-edit text-xl round-p5-ardhi color-ardhi hover-ardhi shadow fab"></span>
<div class="p-1">
    <div class="row">
        <div class="col-lg-9">
            <div class="d-flex justify-content-center">
                <input type="text" id="title" class="form-control text-center text-uppercase text-xl" value="{{$meeting->meeting_title}}" disabled>
            </div>
        </div>
        <div class="col-lg-3">
            <span class="text-xxl">{{$meeting->meeting_date}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-7 col-lg-7 col-md-8">
            <div class="d-flex flex-column">
                <div class="pb-2">
                    <textarea name="" id="" cols="30" rows="10" class="form-control" disabled>
                        {{$meeting->meeting_description}}
                    </textarea>
                </div>
                <div class="pt-2">
                    <span>Attachments</span>
                    <div class="row">
                        @foreach($documents as $document)
                        <div class="col-lg-4">
                            <div class="document card shadow">
                                <div class="card-body">
                                    <img src="{{ $document->icon($document->document_extension)}}" alt="document" />
                                    <span onclick="downloadfile({{json_encode($document)}},{{json_encode(url('downloadfile'))}})">
                                        <i class="fe fe-download"></i>
                                    </span>
                                </div>
                                <div class="card-footer p-1">
                                    <h3 class="text-capitalize">{{$document->document_type}}</h3>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <span>Other Attachments</span>
                    <div id="attachments" class="row"  data-toggle="modal" data-target="#attachment-modal">
                        <div id="create-attachment" class="col-lg-3 hover-ardhi box-md">
                            <span class="fas fa-plus"></span>
                        </div>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="row">
                        <div class="col-lg-9">
                            <label for="chairman">Chairman</label>
                            <input type="text" id="chairman" value="{{($chair === null)? 'Not Selected': $chair->last_name.' '.$chair->first_name}}" class="form-control" disabled>
                        </div>
                        <!-- <div class="col-lg-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Change</button>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <label for="secretary">Secretary</label>
                            <input type="text" id="secretary" value="{{($secr === null)? 'Not Selected': $secr->last_name.' '.$secr->first_name}}" class="form-control" disabled>
                        </div>
                        <div class="col-lg-3">
                            @if(($meeting->wasHeld()) && (Auth::User()->id == $chair->id))
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Change</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-4">
            <div class="shadow">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active border" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fas fa-user-tie mr-2"></i>Members</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 border" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fas fa-tags mr-2"></i>History</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow mb-0">
                    <div class="card-body pt-2 pl-3 pr-3">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="d-flex flex-column h-100vh">
                                    @if($meeting->wasHeld())
                                    <div class="border-ardhi box-fit hover-ardhi cursor-default mb-3" data-toggle="modal" data-target="#largeModal">
                                        <span class="fas fa-plus-square text-xl text-black pl-1 pt-1"></span>
                                        <span class="p-2 font-weight-800">Invite Member</span>
                                    </div>
                                    @endif
                                    @foreach($members as $member)
                                    <div class="border-bottom hover-normal p-2 cursor-default">
                                        <p class="font-weight-700"></p>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-capitalize">{{$member->first_name}}</span>
                                            @if(($chair !== null) && ($chair->id == $member->id))
                                            <span class="text-capitalize text-red">Chairman</span>
                                            @elseif(($secr !== null) && ($secr->id == $member->id))
                                            <span class="text-capitalize text-green">Secretary</span>
                                            @else
                                            <span class="text-capitalize">Member</span>
                                            @endif
                                        </div>
                                    </div>
                                   @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                <div class="d-flex flex-column h-100vh">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
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
                        @if(($chair !== null) && ($chair->id == $member->id))
                        <span class="text-capitalize text-red">{{$member->first_name}}</span>
                        <span class="text-capitalize text-red">Chairman</span>
                        @else
                        <label class="custom-switch">
                            <input type="radio" name="secretary" value="{{$member->id}}" class="custom-switch-input">
                            <span class="custom-switch-indicator mr-3"></span>
                            <span class="custom-switch-description text-capitalize">{{$member->first_name}}</span>
                        </label>
                        <span class="text-capitalize">Member</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                <form action="{{url('uploadfile').'/'.$meeting->id}}" method="post" id="upload-form" enctype="multipart/form-data">
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
                                    <input type="text" name="meeting_id" value="{{$meeting->id}}" hidden>
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
            $('#upload').click(function(){
                let file = filetype();
                if(file.isSet){
                    $("#upload-form").trigger("submit");
                    $("#file-upload").val("");
                    $("#close-upload").trigger('click');
                    clearAlert();
                }
            });
        });

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
            })
        }

        const filetype = () => {
            let file = $("input[name=file-type]:checked").val();
            if(file === 'none'){
                $('#but4').trigger('click');
                setAlert({title:"File Type Not Selected",
                            type: "warning",
                            timer: 2000});

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