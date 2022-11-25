$(document).ready(function(){
    $('#time_record').DataTable();    
    startTime();

    $('#time_in').click(function(){
        var emp_id = $('#emp_id').val();
        var time_in = document.getElementById('time').innerHTML;

        if(emp_id != "" && time_in !=""){
            console.log('test');
           $.ajax({
                type : 'post',
                ContentType: 'application/json',
                url : baseUrl + 'time_recording/time_in',
                data : {
                    'emp_id' : emp_id,
                    'time_in' : time_in
                },
                success: function(res){
                    if(res.response.status == true){
                        document.getElementById('successModalLabel').innerHTML = 'Success!';
                        document.getElementById('successMessage').innerHTML = "Successful time in.";
                        $('#successModal').modal('show');
                    }else{
                        document.getElementById('errorModalLabel').innerHTML = 'Error';
                        document.getElementById('errorMessage').innerHTML = "Failed time in.";
                        $('#errorModal').modal('show');
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                    console.log(error);
                }
            }); 
        }
        
    });

    $('#time_out').click(function(){
        var emp_id = $('#emp_id').val();
        var time_out = document.getElementById('time').innerHTML;

        if(emp_id != "" && time_out !=""){
           $.ajax({
                type : 'post',
                ContentType: 'application/json',
                url : baseUrl + 'time_recording/time_out',
                data : {
                    'emp_id' : emp_id,
                    'time_out' : time_out
                },
                success: function(res){console.log(res);
                    if(res.response.status == true){
                        document.getElementById('successModalLabel').innerHTML = 'Success!';
                        document.getElementById('successMessage').innerHTML = "Successful time out.";
                        $('#successModal').modal('show');
                    }else{
                        document.getElementById('errorModalLabel').innerHTML = 'Error';
                        document.getElementById('errorMessage').innerHTML = "Failed time out.";
                        $('#errorModal').modal('show');
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                    console.log(error);
                }
            }); 
        }
        
    });
});

function refresh_page(){
    location.reload();
}

function startTime() {
    const today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML =  h + ":" + m + ":" + s;
    setTimeout(startTime, 1000);
}
  
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

function check_employee(){
    // clear div
    $('#result').empty();
    if(document.getElementById('emp_id').value != ""){
        $.ajax({
            type : 'get',
            ContentType: 'application/json',
            url : baseUrl + 'time_recording/get_emp_details',
            data : {
                'emp_id' : document.getElementById('emp_id').value
            },
            success: function(res){
                // disable buttons
                document.getElementById("time_in").disabled = true;
                document.getElementById("time_out").disabled = true;

                var elem = "";
                if(res.response.status == true){ // with today's record
                    var full_name = res.response.details.full_name;
                    var date_time_in = res.response.details.date_time_in ? res.response.details.date_time_in : '';
                    var date_time_out = res.response.details.date_time_out ? res.response.details.date_time_out : '';
                    var time_in = res.response.details.time_in ? res.response.details.time_in : '';
                    var time_out = res.response.details.time_out ? res.response.details.time_out : '';
                    elem += "<p>Name: <span class='text-muted'>"+ full_name +"</span></p>";
                    elem += "<p>Date: <span class='text-muted'>"+ date_time_in +"</span> &nbsp; Time in: <span class='text-muted'>"+ time_in +"</span></p>";
                    elem += "<p>Date: <span class='text-muted'>"+ date_time_out +"</span> &nbsp; Time out: <span class='text-muted'>"+ time_out +"</span></p>";
                    
                    var check_date = new String(date_time_out).localeCompare(new String(document.getElementById('date_today').innerHTML));
                    
                    if(time_in != "" && time_out == ""){
                        document.getElementById("time_out").disabled = false; // enable time out button
                    }else if(time_in != "" && time_out != "" && check_date){
                        elem = "";
                        elem += "<p>Name: <span class='text-muted'>"+ full_name +"</span></p>";
                        elem += "<p>Date: <span class='text-muted'></span> &nbsp; Time in: <span class='text-muted'></span></p>";
                        elem += "<p>Date: <span class='text-muted'></span> &nbsp; Time out: <span class='text-muted'></span></p>";
                        document.getElementById("time_in").disabled = false; // enable time in button
                    } else if((time_in == "" && time_out == "") || (time_in != "" && time_out != "")){ 
                        document.getElementById("time_in").disabled = false; // enable time in button
                    }
                }else{
                    elem += "<p class='text-muted'>No Record Found.</p>";
                }

                $('#result').append(elem);
                
            },
            error: function(xhr, status, error){
                console.log(xhr);
                console.log(error);
            }
        });
    }
    
}