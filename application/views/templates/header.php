<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
        <!-- <meta http-equiv="refresh" content="180"> -->
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/icon.png"  type="image/x-icon">
        <!-- Common CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Module CSS -->
        <?php 
            if(count($css) > 0){
                foreach($css as $css_item){
                    $css_display = $css_item['url'] != "" ? "<link type='". $css_item['type'] ."' href='". $css_item['url'] ."' rel='" . $css_item['rel']. "' />" : ""; 
                    echo $css_display;
                }
            }
            date_default_timezone_set("Asia/Manila");
        ?>
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css?ver=1" />
        <script>
            var baseUrl = "<?php echo base_url(); ?>";
        </script>
    </head>
    <body class="bg-light">
    <?php $this->load->view('templates/nav'); ?>