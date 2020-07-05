@extends('layouts.app')

@section('content')
<div class="p-3">
    <div class="d-flex justify-content-center">
        <span class="text-md font-italic text-blue">created by {{$creator->last_name.' '.$creator->first_name}}</span>
    </div>
    <div class="row">
        <div class="col-xl-7 col-lg-7 col-md-8">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <div class="text-uppercase text-lg font-weight-600">{{$meeting->meeting_title}}</div>
                    <span class="fas fa-edit text-xl round-p5-ardhi color-ardhi hover-ardhi"></span>
                </div>
                <div class="pb-2">
                    <textarea name="" id="" cols="30" rows="10" class="form-control" disabled>
                        {{$meeting->meeting_description}}
                    </textarea>
                </div>
                <div class="pt-2">
                    <span>Upload minutes here</span>
                    <div class="card">
                        <div class="card-body">
                            <input type="file" class="dropify" data-height="100" />
                        </div>
                    </div>
                </div>
                <div class="pt-2">
                    <div>
                        <label for="chairman">Chairman</label>
                        <input type="text" id="chairman" value="{{$chairman}}" class="input-style" disabled>
                    </div>
                    <div class="pt-2">
                        <label for="secretary">Secretary</label>
                        <input type="text" id="secretary" value="{{$secretary}}" class="input-style" disabled>
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
                                    <div class="border-ardhi box-fit hover-ardhi cursor-default mb-3" data-toggle="modal" data-target="#largeModal">
                                        <span class="fas fa-plus-square text-xl text-black pl-1 pt-1"></span>
                                        <span class="p-2 font-weight-800">Add Members</span>
                                    </div>
                                    @foreach($members as $member)
                                    <div class="border-bottom hover-normal p-2">
                                        <p class="font-weight-700">{{$member->first_name.' '.$member->last_name}}</p>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-capitalize">{{$member->role_name}}</span>
                                            <span class="text-capitalize">{{$member->position}}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                <p class="description mb-0">
                                    Cosby sweater eu banh mi, qui irure terry richardson ex squid. 
                                    Aliquip placeat salvia cillum iphone. 
                                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
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
	</script>
@endsection