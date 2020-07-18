@extends('layouts.app')

@section('content')
<div>
    <div class="p-3">
        <input type="search" name="" id="" class="form-control" placeholder="search.....">
    </div>
    <div>
        @if($school)
            @foreach($school as $meeting)
        <form action="show_meeting/{{$meeting->meeting_id}}" method="post" class="cursor-default meeting">
        @csrf
        <div class="card border-warning p-2 m-1 hover-warning">
            <div class="text-lg text-uppercase">{{$meeting->meeting_title}}</div>
            <div>{{$meeting->meeting_description}}</div>
        </div>
        </form>
            @endforeach
        @endif

        @if($department)
            @foreach($department as $meeting)
        <form action="show_meeting/{{$meeting->meeting_id}}" method="post" class="cursor-default meeting">
        @csrf
        <div class="card border-warning p-2 m-1 hover-warning">
            <div class="text-lg text-uppercase">{{$meeting->meeting_title}}</div>
            <div>{{$meeting->meeting_description}}</div>
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
        });
    </script>
@endsection