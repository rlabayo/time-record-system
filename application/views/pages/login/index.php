<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $header['title']; ?></title>

        <link rel="icon" href="<?php echo base_url(); ?>assets/images/icon.png"  type="image/x-icon">
        <!-- Common CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Module CSS -->
        <?php 
            if(count($header['css']) > 0){
                foreach($header['css'] as $css_item){
                    $css_display = $css_item['url'] != "" ? "<link type='". $css_item['type'] ."' href='". $css_item['url'] ."' rel='" . $css_item['rel']. "' />" : ""; 
                    echo $css_display;
                }
            }
        ?>
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css" />
        <script>
            var baseUrl = "<?php echo base_url(); ?>";
        </script>
    </head>
    <body class="bg-light">
        <section>
            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-md-4 col-sm-6 bg-white border rounded p-5">
                        <h2 class="text-center text-muted">LOGIN</h2>

                        <form id="form-login">
                            <div class="form-group my-3">
                                <label for="user_name" class="form-label text-muted">Username</label>
                                <input type="text" id="user_name" name="user_name" class="form-control"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label text-muted">Password</label>
                                <input type="password" id="password" name="password"  class="form-control"/>
                            </div>
                            <div class="row w-90 m-auto">
                                <button type="submit" class="btn btn-primary btn-block mt-3" id="login">LOGIN</button>
                                <p class="lead error fw-bold mt-2 text-center" id="login_error"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
            

    <!-- Common JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Module JS -->
    <?php 
        if(count($footer['js']) > 0){
            foreach($footer['js'] as $js_item){
                $js_display = $js_item['src'] != "" ? "<script src='". $js_item['src'] ."' type='" . $js_item['type']. "' ></script>" : ""; 
                echo $js_display;
            }
        }
    ?>
    
</body>
</html>