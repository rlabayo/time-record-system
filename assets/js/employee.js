$(document).ready(function () {

    var table = $('#employee').DataTable({     
        'columnDefs': [
           {
              'targets': 0,
              'checkboxes': {
                 'selectRow': true
              }
           }
        ],
        'select': {
           'style': 'multi'
        },
        'order': [[1, 'asc']]
     });

     $('#form-add-employee').validate({
        ignore: '',
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            }
        },
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
            var $form = $(form);
            $form.submit();
        },
        errorElement: "span"
    });

    $('#form-edit-employee').validate({
        ignore: '',
        rules: {
            edit_first_name: {
                required: true,
            },
            edit_last_name: {
                required: true,
            }
        },
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
            var $form = $(form);
            $form.submit();
        },
        errorElement: "span"
    });

    $('#submit_employee').click(function(e){
        e.preventDefault();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();

        $('#form-add-employee').valid();
        var is_valid = $('#form-add-employee').valid();

        if((is_valid == true) && (first_name != "" && last_name != "")){
            $.ajax({
                type : 'post',
                ContentType: 'application/json',
                url : baseUrl + 'employee/create',
                data : {
                    'first_name' : first_name,
                    'last_name' : last_name
                },
                success: function(res){
                    if(res.response.status == true){
                        $('#add_modal').modal('hide');

                        document.getElementById('successModalLabel').innerHTML = 'Success!';
                        document.getElementById('successMessage').innerHTML = "Employee created successfully.";
                        $('#successModal').modal('show');
                    }else{
                        if(res.response.session_expired == true){
                            document.getElementById('sessionModalLabel').innerHTML = 'Error';
                            document.getElementById('sessionMessage').innerHTML = "Session Expired.";
                            $('#sessionModal').modal('show');
                        }else{
                            document.getElementById('errorModalLabel').innerHTML = 'Error';
                            document.getElementById('errorMessage').innerHTML = "Error encountered while creating an employee.";
                            $('#errorModal').modal('show');
                        }
                        
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                    console.log(error);
                }
            });
        }
    });

    $('#edit_employee').click(function(e){
        e.preventDefault();
        var first_name = $('#edit_first_name').val();
        var last_name = $('#edit_last_name').val();
        var emp_id = $('#emp_id').val();

        $('#form-edit-employee').valid();
        var is_valid = $('#form-edit-employee').valid();

        if((is_valid == true) && (first_name != "" && last_name != "" && emp_id != "")){
            $.ajax({
                type : 'post',
                ContentType: 'application/json',
                url : baseUrl + 'employee/edit',
                data : {
                    'first_name' : first_name,
                    'last_name' : last_name,
                    'id' : emp_id
                },
                success: function(res){
                    if(res.response.status == true){
                        $('#edit_modal').modal('hide');

                        document.getElementById('successModalLabel').innerHTML = 'Success!';
                        document.getElementById('successMessage').innerHTML = "Successfully updated the employee.";
                        $('#successModal').modal('show');
                    }else{
                        if(res.response.session_expired == true){
                            document.getElementById('sessionModalLabel').innerHTML = 'Error';
                            document.getElementById('sessionMessage').innerHTML = "Session Expired.";
                            $('#sessionModal').modal('show');
                        }else{
                            document.getElementById('errorModalLabel').innerHTML = 'Error';
                            document.getElementById('errorMessage').innerHTML = "Error encountered while updating the employee details.";
                            $('#errorModal').modal('show');
                        }
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                    console.log(error);
                }
            });
        }
    });

    $('#delete_confirmation').click(function(){
        var rows_selected = table.column(0).checkboxes.selected();
        if(rows_selected.length > 0){
            document.getElementById('confirmationModalLabel').innerHTML = 'Confirmation';
            document.getElementById('confirmationMessage').innerHTML = "Are you sure you want to delete employee/s?";
            $('#confirmationModal').modal('show');
        }else{
            document.getElementById('infoModalLabel').innerHTML = 'Warning';
            document.getElementById('infoMessage').innerHTML = "No selected employee.";
            $('#infoModal').modal('show');
        }
    });

    $('#delete_confirmed').click(function(){
        $('#confirmationModal').modal('hide');
        var rows_selected = table.column(0).checkboxes.selected();

        if(rows_selected.length > 0){
            $.each(rows_selected, function(index, rowId){
                var error = false;
                $.ajax({
                    type : 'get',
                    ContentType: 'application/json',
                    url : baseUrl + 'employee/delete',
                    data : {
                        'id' : rowId
                    },
                    success: function(res){
                        if(res.response.status == false){
                            error = true;

                            if(res.response.session_expired == true){
                                document.getElementById('sessionModalLabel').innerHTML = 'Error';
                                document.getElementById('sessionMessage').innerHTML = "Session Expired.";
                                $('#sessionModal').modal('show');

                                setTimeout(refresh_page, 30000);
                            }
                        }
                        if(((index+1) == rows_selected.length) && error == true){
                            document.getElementById('errorModalLabel').innerHTML = 'Error';
                            document.getElementById('errorMessage').innerHTML = "Error encountered while deleting employee/s";
                            $('#errorModal').modal('show');
                        }else if(((index+1) == rows_selected.length) && error == false){
                            document.getElementById('successModalLabel').innerHTML = 'Success!';
                            document.getElementById('successMessage').innerHTML = "You deleted an employee/s successfully!";
                            $('#successModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error){
                        console.log(xhr);
                        console.log(error);
                    }
                });
            });
        }else {
            document.getElementById('infoModalLabel').innerHTML = 'Warning';
            document.getElementById('infoMessage').innerHTML = "No selected user.";
            $('#infoModal').modal('show');
        } 
    });
    
});

function refresh_page(){
    location.reload();
}

function edit(id){
    $.ajax({
        type : 'get',
        ContentType: 'application/json',
        url : baseUrl + 'employee/get',
        data : {
            'id' : id
        },
        success: function(res){
            $('#edit_first_name').val(res.employee.records[0].first_name);
            $('#edit_last_name').val(res.employee.records[0].last_name);
            $('#emp_id').val(res.employee.records[0].id);
            $('#edit_modal').modal('show');
        },
        error: function(xhr, status, error){
            console.log(xhr);
            console.log(error);
        }
    });
}

