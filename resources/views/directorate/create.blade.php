@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mb-0">REGISTER NEW DIRECTORATE</h2>
                </div>
            <div class="card-body">
            <form action="storesDirectorate" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Directorate Name</label>
                            <input type="text" class="form-control" name="directorate_name" placeholder="Directorate Name">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Diretorate Code</label>
                            <input type="text" class="form-control" name="directorate_code" placeholder="Directorate Code">
                        </div>
                    </div>
            
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

 
   