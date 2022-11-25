<section class="bg-light">
    <div class="container-lg  bg-white">
        <div class="row bg-dark text-white p-2 border rounded">
            <h5>Employee</h5>
        </div>
        
        <div class="row p-2  overflow-auto">
            <table id="employee" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Created By</th>
                        <th>Datetime Added</th>
                        <th>Datetime Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(count($records) > 0){
                        foreach($records as $item){
                    ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->first_name; ?></td>
                        <td><?php echo $item->last_name; ?></td>
                        <td><?php echo $item->user_name ? $item->user_name : 'N/A' ?></td>
                        <td><?php echo $item->datetime_added; ?></td>
                        <td><?php echo $item->datetime_updated; ?></td>
                        <td><button class="btn btn-outline-primary m-1" onclick="edit(<?php echo $item->id; ?>)">Edit</button></td>
                    </tr>
                    <?php 
                        }
                    }
                    ?>
                       
                </tbody>
            </table>
        </div>
        <div class="mt-3 pb-3">
            <button class="btn btn-outline-primary mx-auto mt-auto btn-sm" data-bs-toggle="modal" data-bs-target="#add_modal" >Add New</button>
            <button class="btn btn-danger btn-sm" id="delete_confirmation">Delete Selected</button>
        </div>
        
    </div>
</section>


