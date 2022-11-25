    <!-- Common JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Module JS -->
    <?php 
        if(count($js) > 0){
            foreach($js as $js_item){
                $js_display = $js_item['src'] != "" ? "<script src='". $js_item['src'] ."' type='" . $js_item['type']. "' ></script>" : ""; 
                echo $js_display;
            }
        }
    ?>

    <script src="<?php echo base_url();?>assets/js/refresh.js?ver=2" type="text/javascript"></script>
    
</body>
</html>