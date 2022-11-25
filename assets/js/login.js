$(document).ready(function () {
    $('#form-login').validate({
        ignore: '',
        rules: {
            user_name: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            user_name: {
                required: "Please enter your username"
            },
            password: {
                required: "Please enter your password"
            },
        },
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
            var $form = $(form);
            $form.submit();
        },
        errorElement: "span"
    });

    $('#login').click(function(e){
        e.preventDefault();
        var user_name = $('#user_name').val();
        var password = $('#password').val();
        
        $('#form-login').valid();
        var is_valid = $('#form-login').valid();

        if(is_valid == true && user_name != "" && password != ""){
            $.ajax({
                type : 'post',
                url : baseUrl + 'login/process',
                data : {
                    'user_name' : user_name,
                    'password' : password
                },
                success: function(res){
                    document.getElementById('login_error').innerHTML = "";
                    var result;
                    try{
                        result = JSON.parse(res);
                    }catch(e){
                        location.reload();
                    }

                    var result = JSON.parse(res);

                    if (result && typeof result === "object") {
                        if(result.response.status == true){
                            window.location.href = baseUrl + "time_recording";
                        }else{
                            document.getElementById('login_error').innerHTML = "Incorrect username or password.";
                        }
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                    console.log(error);
                }
            }); 
            return false;
        }
    });


});