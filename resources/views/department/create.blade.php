@extends('layouts.admin')

@section('content')
 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mb-0">REGISTER NEW DEPARTMENT</h2>
                </div>
            <div class="card-body">
                <form action="storeDepartment" method="post">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Department Name</label>
                                    <input type="text" class="form-control" name="department_name" placeholder="Department Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Department Code</label>
                                    <input type="text" class="form-control" name="department_code" placeholder="Department Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-control custom-radio">
                                    <input type="radio" id="defaultUnchecked" name="department-type" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="defaultUnchecked">school</label>                                                        
                                </div>   
                            </div>

                            <div class="col-md-6">
                                <div class="form-group custom-control custom-radio">
                                    <input type="radio" id="defaultChecked" name="department-type" class="custom-control-input" value="2" required>
                                    <label for="defaultChecked" class="custom-control-label">Directorate</label>                                                        
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="school_directorate_id" id="dirschool" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="" id="direct_selected" selected disabled></option>
                                        <option data-tokens="" value=""></option>   
                                    </select>
                                </div>
                            </div>
                        </div>

                        

                        <div class="row">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="btn_sbmt">
                                                {{ __('Register') }}
                                    </button>
                                </div>
                            </div>  
                        </div>
                                    
                </form>
            </div>
        </div>
    <div>
</div>



<script>
    class SchoolDirectorate{
        static schools = null;
        static directorates = null;

        static setSchools(schools){
            SchoolDirectorate.schools = schools;
        }
        
        static setDirectorates(directorates){
            SchoolDirectorate.directorates = directorates;
        }

        static getSchools(){
            return SchoolDirectorate.schools;
        }

        static getDirectorates(){
            return SchoolDirectorate.directorates; 
        }
    }
    $(document).ready(function(){

        displaySchool();
        $("#dirschool").hide();
        $('input[type=radio][name=department-type]').change(function(){
            $('#dirschool').empty();
            let list = "";
            if(this.value == 1){
                list = createDropdownList(SchoolDirectorate.getSchools(),true);
            }else{
                list = createDropdownList(SchoolDirectorate.getDirectorates(),false);
            }
            $('#dirschool').append(list);
            $("#dirschool").show();
        });
     
        function displaySchool(){
            $.ajax({
            url: '/showdirectoryschools',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            dataType: 'json',
            success:function(response){
                SchoolDirectorate.setSchools(response.schools);
                SchoolDirectorate.setDirectorates(response.directorates);
            },
            error:function(xhr,status,err){
                console.log(err);
            }
        });
        }
        $(function() {
            $('.selectpicker').selectpicker();
        });
    });
    
    const createDropdownList = (data,isSchools) =>{
        let list = '<option value="" id="direct_selected" selected disabled></option>';
        if(isSchools){
                data.forEach(school => {
                    list += '<option data-tokens="'+school.school_name +" "+ school.school_code;
                    list += '" value="'+school.id+'">'+school.school_name+ " (" +school.school_code +")"+'</option>'; 
                });
        }else{
                data.forEach(directorate => {
                    list += '<option data-tokens="'+directorate.directorate_name +" "+ directorate.directorate_code;
                    list += '" value="'+directorate.id+'">'+directorate.directorate_name+ " (" +directorate.directorate_code +")"+'</option>'; 
                });
        }
        return list;
    }
</script>

@endsection

   