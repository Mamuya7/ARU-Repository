@extends('layouts.app')

@section('content')
<div>
    <div class="p-3">
        <input type="search" name="" id="" class="form-control" placeholder="search.....">
    </div>
    <div>
        @foreach($meetings as $meeting)
            <div class="card border-warning p-2 m-1 cursor-default hover-warning">
                <div class="text-lg text-uppercase">{{$meeting->meeting_title}}</div>
                <div>{{$meeting->meeting_description}}</div>
            </div>
        @endforeach
    </div>
</div>
@endsection