<section class="bg-light">
    <div class="container-lg bg-white ">
            <div class="row bg-dark text-white py-2 border rounded mb-3">
                <h5>Employee Time Record</h5>
            </div>
            <div class="row p-2 overflow-auto">
                <table id="time_record" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="d-none"></th>
                            <th class="text-center">Employee ID</th>
                            <th>Employee Name</th>
                            <th>Created By</th>
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
                            <td class="text-center"><?php echo $item->employee_id; ?></td>
                            <td><?php echo $item->first_name .' '. $item->last_name; ?></td>
                            <td><?php echo $item->user_name != "" ? $item->user_name : "Deleted User"; ?></td>
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
