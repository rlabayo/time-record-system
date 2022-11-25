$(document).ready(function () {
    $.validator.addMethod('alphaNumericSpecialChars', function(value,element){
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/.test(value);
    },'Lowercase, uppercase, number and special characters only with minimum of 10 characters.');

    $.validator.addMethod('checkPassword', function(value,element){
        if($('#password').val() == $('#confirm_password').val()){
            return true;
        }else{
            return false;
        }
        
    }, 'Please input correct password.');

    $.validator.addMethod('checkUpdatePassword', function(value,element){
        if($('#new_password').val() == $('#edit_confirm_password').val()){
            return true;
        }else{
            return false;
        }
        
    }, 'Please input correct password.');

    $.validator.addMethod('checkUsernameIfExists', function(value, element){
        if($('#user_name_exists').val() == 'true'){
            return false;
        } else{
            return true;
        }
    });

    $('#form-add-user').validate({
        ignore: '',
        rules: {
            user_name: {
                required: true,
            },
            password: {
                required: true,
                alphaNumericSpecialChars : true,
                minlength: 10
            },
            confirm_password:{
                required: true,
                checkPassword: true
            },
            user_type: {
                required: true
            }
        },
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
            var $form = $(form);
            $form.submit();
        },
        errorClass: 'error col-12',
        errorElement: "span"
    });

    $('#form-edit-user').validate({
        ignore: '',
        rules: {
            edit_user_name: {
                required: true,
            },
            current_password: {
                alphaNumericSpecialChars : true,
                minlength: 10,
            },
            new_password:{
                alphaNumericSpecialChars : true,
                minlength: 10,
            },
            edit_confirm_password:{
                checkUpdatePassword: true
            }
        },
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
            var $form = $(form);
            $form.submit();
        },
        errorClass: 'error col-12',
        errorElement: "span"
    });

    var table = $('#user').DataTable({     
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

     $('#user_name').change(function(){
        check_if_username_exists(this.value);
     });

     $('#submit_user').click(function(e){
        e.preventDefault();
        var user_name = $('#user_name').val();
        var confirm_password = $('#confirm_password').val();
        var password = $('#password').val();
        var user_type = $('#user_type').val();

        $('#form-add-user').valid();
        var is_valid = $('#form-add-user').valid();

        if(((is_valid == true) && (password == confirm_password)
            && (user_name != "" && password != "" && confirm_password != "" && user_type != ""))){
            $.ajax({
                type : 'post',
                ContentType: 'application/json',
                url : baseUrl + 'user/create',
                data : {
                    'user_name' : user_name,
                    'user_password' : password,
                    'user_type' : user_type
                },
                success: function(res){
                    if(res.response.status == true){
                        $('#add_modal').modal('hide');

                        document.getElementById('successModalLabel').innerHTML = 'Success!';
                        document.getElementById('successMessage').innerHTML = "User created successfully.";
                        $('#successModal').modal('show');
                    }else{
                        if(res.response.session_expired == true){
                            document.getElementById('sessionModalLabel').innerHTML = 'Error';
                            document.getElementById('sessionMessage').innerHTML = "Session Expired.";
                            $('#sessionModal').modal('show');
                        }else{
                            document.getElementById('errorModalLabel').innerHTML = 'Error';
                            document.getElementById('errorMessage').innerHTML = "Error encountered while creating new user.";
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

     $('#edit_user_name').change(function(){
        check_if_updated_username_exists(this.value, $('#user_id').val());
     });

     $('#current_password').change(function(){
        check_current_password(this.value);
     });

     $('#new_password, #edit_confirm_password').change(function(){
        var new_password = $('#new_password').val();
        var confirm_password = $('#edit_confirm_password').val();

        $('span.error').remove();

        check_password_validation(new_password, confirm_password);
        
     });

     function check_password_validation(new_password, confirm_password){ 
        if(new_password != "" || confirm_password != ""){
            $('#current_password').prop('required','true');
            $('#new_password').prop('required','true');
            $('#edit_confirm_password').prop('required','true');

            $('#current_password').valid();
        }else if(new_password == "" && confirm_password == "") {
            $('#current_password').removeAttr('required');
            $('#new_password').removeAttr('required');
            $('#edit_confirm_password').removeAttr('required');

            $('#current_password').valid();
        }
     }

     $('#edit_user').click(function(e){
        e.preventDefault();
        var user_name_exists = $('#user_name_exists').val();
        var user_name = $('#edit_user_name').val();
        var new_password = $('#new_password').val();
        var user_type = $('#edit_user_type').val();
        var user_id = $('#user_id').val();
        var confirm_password = $('#current_password').val();

        check_password_validation(new_password, confirm_password);

        var form = $("#form-edit-user");
        var fHasError = form.has("span.error");
        
        if((fHasError.length == 0) && (user_name != "" && user_id != "" && user_name_exists != "true")){
            $.ajax({
                type : 'post',
                ContentType: 'application/json',
                url : baseUrl + 'user/edit',
                data : {
                    'user_name' : user_name,
                    'user_password' : new_password,
                    'user_type' : user_type,
                    'id' : user_id
                },
                success: function(res){console.log(res);
                    if(res.response.status == true){
                        $('#edit_modal').modal('hide');

                        document.getElementById('successModalLabel').innerHTML = 'Success!';
                        document.getElementById('successMessage').innerHTML = "Successfully updated the user details.";
                        $('#successModal').modal('show');
                    }else{
                        if(res.response.session_expired == true){
                            document.getElementById('sessionModalLabel').innerHTML = 'Error';
                            document.getElementById('sessionMessage').innerHTML = "Session Expired.";
                            $('#sessionModal').modal('show');
                        }else{
                            document.getElementById('errorModalLabel').innerHTML = 'Error';
                            document.getElementById('errorMessage').innerHTML = "Error encountered while updating the user details.";
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

     $('#delete_confirmed').click(function(){
        $('#confirmationModal').modal('hide');
        var rows_selected = table.column(0).checkboxes.selected();

        if(rows_selected.length > 0){
            // Iterate over all selected checkboxes
            $.each(rows_selected, function(index, rowId){
                var error = false;
                $.ajax({
                    type : 'get',
                    ContentType: 'application/json',
                    url : baseUrl + 'user/check',
                    data : {
                        'id' : rowId
                    },
                    success: function(res){
                        if(res.status == true){
                            $('#self').val(true);
                        }
                    }
                });
                $.ajax({
                    type : 'get',
                    ContentType: 'application/json',
                    url : baseUrl + 'user/delete',
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
                        var self = $('#self').val();
                        if(((index+1) == rows_selected.length) && error == true){
                            if(self == true){
                                document.getElementById('errorMessage').innerHTML = "Error encountered while deleting user/s. You can't delete your own user account.";
                            }else{
                                document.getElementById('errorMessage').innerHTML = "Error encountered while deleting user/s.";
                            }
                            document.getElementById('errorModalLabel').innerHTML = 'Error';
                            $('#errorModal').modal('show');
                        }else if(((index+1) == rows_selected.length) && error == false){
                            if(self == 'true' || self == true){
                                document.getElementById('infoModalLabel').innerHTML = 'Warning';
                                document.getElementById('infoMessage').innerHTML = "You successfully deleted other user/s, but the current user account used can't be deleted. ";
                                $('#infoModal').modal('show');
                            }else{
                                document.getElementById('successModalLabel').innerHTML = 'Success!';
                                document.getElementById('successMessage').innerHTML = "You deleted an user/s successfully!";
                                $('#successModal').modal('show');
                            }
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

     $('#delete_confirmation').click(function(){
        var rows_selected = table.column(0).checkboxes.selected();
        if(rows_selected.length > 0){
            document.getElementById('confirmationModalLabel').innerHTML = 'Confirmation';
            document.getElementById('confirmationMessage').innerHTML = "Are you sure you want to delete user account/s?";
            $('#confirmationModal').modal('show');
        }else{
            document.getElementById('infoModalLabel').innerHTML = 'Warning';
            document.getElementById('infoMessage').innerHTML = "No selected user.";
            $('#infoModal').modal('show');
        }
    });



     $('#cancel_insert_user').click(function(){
        document.getElementById('user_name').val = "";
        document.getElementById('password').val = "";
        document.getElementById('confirm_password').val = "";
        document.getElementById('user_type').val = "";
     });
});

function check_if_username_exists(username){
    $.ajax({
        type : 'get',
        ContentType: 'application/json',
        url : baseUrl + 'user/get/user_name',
        data : {
            'user_name' : username
        },
        success: function(response){ 
            var elem = '<span id="error-user_name" class="error col-12"></span>';
            if(response.user.status == true){ // already exist
                $('.form-group-user-name').append(elem);
                document.getElementById('error-user_name').innerHTML = "Username already exists.";
                document.getElementById('user_name_exists').val = true;
            }else{
                $('#error-user_name').remove();
                document.getElementById('user_name_exists').val = false;
            }
        },
        error: function(xhr, status, error){
            console.log(xhr);
            console.log(error);
        }
    });
}

function check_if_updated_username_exists(username, id){
    $.ajax({
        type : 'get',
        ContentType: 'application/json',
        url : baseUrl + 'user/get/user_name',
        data : {
            'user_name' : username,
            'id' : id
        },
        success: function(response){ 
            var elem = '<span id="error-edit_user_name" class="error col-12"></span>';
            if(response.user.status == true){ // already exist
                $('.form-group-edit-user-name').append(elem);
                document.getElementById('error-edit_user_name').innerHTML = "Username already exists.";
            }else{
                $('#error-edit_user_name').remove();
            }
        },
        error: function(xhr, status, error){
            console.log(xhr);
            console.log(error);
        }
    });
}

function check_current_password(password){
    $.ajax({
        type : 'get',
        ContentType: 'application/json',
        url : baseUrl + 'user/get/user_password',
        data : {
            'id' : $('#user_id').val(),
            'current_password' : password
        },
        success: function(res){
            $('span.error').remove();
            var elem = '<span id="error-current_password" class="error col-12"></span>';
            if(res.response.status == false && password != ""){ 
                $('.form-group-current-password').append(elem);
                document.getElementById('error-current_password').innerHTML = "Please input correct password.";
            } else{
                $('span.error').remove();
            }
        },
        error: function(xhr, status, error){
            console.log(xhr);
            console.log(error);
        }
    });
}

function edit(id){
    $('span.error').remove();
    $.ajax({
        type : 'get',
        ContentType: 'application/json',
        url : baseUrl + 'user/get',
        data : {
            'id' : id
        },
        success: function(res){console.log(res.user.records[0].user_type);
            $('#edit_user_name').val(res.user.records[0].user_name);
            $('#edit_user_type').val(res.user.records[0].user_type);
            $('#user_id').val(res.user.records[0].id);
            console.log(res);
            $('#edit_modal').modal('show');
        },
        error: function(xhr, status, error){
            console.log(xhr);
            console.log(error);
        }
    });
}


function refresh_page(){
    location.reload();
}

function view_password(elem){
    if($('#' + elem).prop('type') == "password"){
        $('#'+ elem +'_btn').empty();
        $('#'+ elem +'_btn').append('<i class="bi bi-eye-slash-fill"></i>');
        $('#' + elem).prop('type', 'text').change()
    }else{
        $('#'+ elem +'_btn').empty();
        $('#'+ elem +'_btn').append('<i class="bi bi-eye-fill"></i>');
        $('#' + elem).prop('type', 'password').change()
    }
}

function generate_password(elem_id){
    var alphaChars = 'abcdefghijklmnopqrstuvwxyz';
    var alphaUpperChars = alphaChars.toUpperCase();
    var numChars = '0123456789';
    var specialChars = "@$!%*?&";

    var shuffledAlphaChars = shuffle(alphaChars, 10);
    var fAlphaChars = shuffledAlphaChars.substr(1,randomNum(7, 4)); // get 4 lowercase letters

    var shuffledAlphaUpperChars = shuffle(alphaUpperChars, 10);
    var fAlphaUpperChars = shuffledAlphaUpperChars.substr(1,randomNum(7, 4)); // get 4 uppercase letters

    var shuffledNumChars = shuffle(numChars,2);
    var fNumChars = shuffledNumChars.substr(1,2); // get 2 numbers

    var shuffledSpecialChars = shuffle(specialChars, 2);
    var fSpecialChars = shuffledSpecialChars.substr(1,2); // get 2 special characters

    var concatChars = fAlphaChars + '' + fAlphaUpperChars + '' + fNumChars + '' + fSpecialChars;
    var final_password = shuffle(concatChars, 5);

    $('#' + elem_id).val(final_password);
}

function randomNum(m=20, n=10){
    var i = Math.floor(Math.random() * (m-n) + n);

    return i;
}

function shuffle(str, n){
    var str = str.split('');

    for(var j=0; j < str.length; j++){
        i = randomNum(str.length, n);
        temp = str[j];
        str[j] = str[i];
        str[i] = temp;
    }
    s = str.join('');
    
    return s;
}
