@extends('layouts.admin')

@section('content')
 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mb-0">REGISTER ROLES</h2>
                </div>
            <div class="card-body">
            <form action="storeRole" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Role Name</label>
                            <input type="text" class="form-control" name="role_name" placeholder="Role Name">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Role Code</label>
                            <input type="text" class="form-control" name="role_code" placeholder="Role Name">
                        </div>
                    </div>

                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn_sbmt">
                                        {{ __('Register') }}
                            </button>
                        </div>
                </div>                
            </form>
            </div>
        </div>
    <div>
</div>
@endsection

   