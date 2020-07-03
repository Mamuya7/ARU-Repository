@extends('layouts.app')

@section('content')
    <div>
        <form action="store_meeting" method="post">
            @csrf
            <div class="p-3">
                <label for="role">Chairman As</label>
                <select name="role" id="role" class="form-control">
                    <option value="null" selected disabled></option>
                    @foreach(Auth::User()->roles as $role)
                    <option value="{{$role->pivot->id}}">{{$role->role_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-3">
                <label for="agenda">Agenda</label>
                <input type="text" id="agenda" name="agenda" class="form-control">
            </div>
            <div class="p-3">
                <label for="description">Description</label>
                <textarea id="description" cols="30" rows="10" name="description" class="form-control"></textarea>
            </div>
            <div class="p-3 text-right">
                <input type="submit" value="Create" class="btn btn-warning">
            </div>
        </form>
    </div>
@endsection