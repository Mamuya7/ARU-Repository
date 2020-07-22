@extends('layouts.admin')

@section('content')

<div class="col-xl-12">
    <div class="card  shadow">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="mb-0">Committees</h2>
                </div>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table card-table text-nowrap">
                    <tr class="border-bottom">
                        <th>Number</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Action</th>
                        <th>Action</th>
                    </tr>

                    @foreach($committees as $committee)
                    <tr class="border-bottom">
                        <td>{{ $committee->id }}</td>
                        <td>{{ $committee->committee_name }}</td>
                        <td>{{ $committee->committee_name }}</td>
                        <td><button type="button" class="btn btn-sm btn-primary mt-1 mb-1">update</button> </td>
                        <td>
                            
                        <button type="button" class="btn btn-sm btn-primary mt-1 mb-1">Delete</button>                                 
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{ $committees->links() }}
            </div>
        </div>
    </div>
</div>

@endsection