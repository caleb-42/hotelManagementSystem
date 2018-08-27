<?php
include_once("./create_admin.php");
$date=date("D M d, Y g:i a");
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>RegAdmin</title>
        <link rel="icon" href="favicon.bmp">    
        <link href="../../vendors/bootstrap4-alpha/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body{
                background: #aaa;
                overflow: hidden;
            }
            .required{
                color: red;
                opacity: .8;
            }
            label{
                font-weight: 600;
            }
            input[type=text]{
                border-radius: 25px !important;
                border: 2px solid #ccc !important;
                width: 70% !important;
                margin: auto;
            }
            .f-12{
                font-size: 12px;
            }
            .f-14{
                font-size: 14px;
            }
            form{
                width: 45%;
                margin: auto;
                background: #ddd;
                border-radius: 25px !important;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class = "adminform row justify-content-center" style="height: 90vh;">
                <form role="form" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="align-self-center text-center px-3 py-5">
                    <h4 class = "mb-5 mx-5 ">Create Admin</h4>
                    <div class="form-group">
                        <label for="username" class="mx-5">Username<span class="required">*</span></label>
                            <input type="text" name="username" class="form-control details" id="username" required/>
                    </div>
                    <div class="form-group">
                        <label for="password" class="mx-5">Password<span class="required">*</span></label>
                            <input type="text" name="password" class="form-control details" id="password" required/>
                    </div>
                    <div class="form-group">
                        <label for="admin" class="">Admin</label>
                            <input value="admin" type="radio" name="cat" class="" id="admin"/>
                        <label for="user" class="">User</label>
                            <input value = "user" type="radio" name="cat" class="" id="user"/>
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn " name="B1" style="background-color: #222; color: white;">Create User <span class="glyphicon glyphicon-log-in"></span></button> 
                    </div>
                    <div class="mt-1 f-14"><?php echo $output; ?></div>
                </form>
            </div>
        </div>
        <footer class="row justify-content-center f-12 mt-3">
            <p>&copy; 2012 - 2017 Webplay Nig Ltd. All Rights Reserved.</p>
        </footer>

    </body>
</html>