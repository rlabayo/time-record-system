<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-sm-6">
                <div class="row justify-content-center p-3 bg-white mx-2 rounded-top">
                    <div class="col text-center border rounded p-3 border-secondary bg-secondary text-white border-2 m-1">
                        <h5>Date</h5>
                        <span class="lead fs-5" id="date_today"><?php echo date("Y-m-d"); ?></span>
                    </div>
                    <div class="col text-center border rounded p-3 border-secondary border-2 m-1">
                        <h5 >Time</h5>
                        <span id="time" class="text-muted fs-5 lead"></span>
                    </div>
                </div>
                <div class="row justify-content-center mt-2 px-lg-5 py-5 bg-white mx-2 rounded-bottom" id="check_div">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="emp_id" name="emp_id" class="form-control" placeholder="Input Imployee ID" >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" onclick="check_employee()" type="button">Check</button>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-primary btn-block mt-2" id="time_in" disabled>Time In</button>
                        <button class="btn btn-outline-danger btn-block mt-2" id="time_out" disabled>Time Out</button>
                    </div>
                    <div class="mt-5">
                        <h5>Employee details:</h5>
                        <div id="result" class="mt-3">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-sm-6 overflow-auto ml-2 ">
                <div class="row bg-dark text-white p-2 border rounded mb-3">
                    <h5>Daily Time Record <span class="text-light fs-6">(2 days)</span></h5>
                </div>
                <table id="time_record" class="table table-striped bg-white" style="width:100%">
                    <thead>
                        <tr>
                            <th class="d-none"></th>
                            <!-- <th class="text-center">Employee ID</th> -->
                            <th>Employee Name</th>
                            <th>Date Added</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(count($records) > 0){
                            foreach($records as $item){
                        ?>
                        <tr>
                            <td class="d-none"></td>
                            <!-- <td class="text-center"><?php echo $item->employee_id; ?></td> -->
                            <td><?php echo $item->first_name .' '. $item->last_name; ?></td>
                            <td><?php echo $item->time_record_date; ?></td>
                            <td><?php echo $item->time_in; ?></td>
                            <td><?php echo $item->time_out; ?></td>
                        </tr>
                        <?php 
                            }
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>