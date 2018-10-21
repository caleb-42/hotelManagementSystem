<?php date_default_timezone_set('Africa/Lagos');
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
        <title>PrimePoint Admin Panel</title>

        <!-- jQuery core -->
        <script src="./vendors/jquery/jquery-3.1.1.min.js"></script>

        <!-- Bootstrap core-->
        <link rel="stylesheet" href="./vendors/bootstrap4-alpha/css/bootstrap.min.css">
        <link rel="stylesheet" href="./vendors/font-awesome-4.7.0/css/font-awesome.min.css">
        <script src="./vendors/bootstrap4-alpha/js/bootstrap.min.js"></script>

        <!-- Custom styles for this template -->
        <link href="./assets/css/logIn.css" rel="stylesheet">
        <link href="./assets/css/utilities.css" rel="stylesheet">
        <link href="./assets/css/win8loader.css" rel="stylesheet">

        <style>

        </style>
    </head>
    <body>
        <div class="container">
            <div class = "adminform row justify-content-center" style="height: 100vh;">
                <form autocomplete="off" role="form" method="post" action = "../php1/restaurant_bar/restaurant_logon.php" class="align-self-center">
                    <div class="formhd text-center px-4 pt-4">
                        <img  class = "" width = 200px height = 70px src = "assets/img/logo.png"/>
                        <h5 class = "Title mb-4 pb-1 mx-5 mt-3 wht font-fam-Calibri">Sales</h5>
                        <div class="row mb-4 pb-2">
                            <input type="text" name="username" class="form-control text-center font-fam-Montserrat-bold inputcolor" required id="username" required value = "Username" placehd = "Username"/>
                            <input type="text" name="password" class="form-control text-center font-fam-Montserrat-bold inputcolor" id="password" value="Password" required placehd = "Password"/>
                            <button type="submit" class="btn btn-lg btn-darkgrn w-100 font-fam-Myriad mt-2" name="B1" style="" onclick="login();">Sign in </button> 
                        </div>
                    </div>
                    <div class="row justify-content-center pb-5" style="height:120px;">
                        <div style = "margin-top:-20px;" class="text-center row w-100 justify-content-center" ><img id="sendGif" class=""  style = "" src="assets/img/loadersquash1.gif" width="100px" height="100px" />
                            <!--<div class='loader'>
                                <div class='circle'></div>
                                <div class='circle'></div>
                                <div class='circle'></div>
                                <div class='circle'></div>
                                <div class='circle'></div>
                            </div>-->
                        </div>
                        <div class="row justify-content-center w-100" style="margin-top:-56px !important;" >
                            <p id="output" class="str text-center " style="opacity:1; font-size:17px; font-weight: 700" ><?php $output = ""; if(array_key_exists("output", $_GET)){
                                $output = $_GET["output"] ? $_GET["output"] : "";
                            } echo "<script type = 'text/javascript'>
            jQuery(function(){
            jQuery('#sendGif').toggleClass('notvisible');
            if('$output' != ''){
            if ('$output' != 'Authorization Granted') {
                jQuery('#output').css('color', '#333');
            } else {
                jQuery('#output').css('color', '#333');
            }
            jQuery('#output').text('$output').fadeTo('slow', 1).delay(4000)
            .fadeTo('slow', 0,function(){
            jQuery('#output').text('');
            });
            jQuery('.btn').prop('disabled', false);}
            });</script>" ?></p>
                        </div>
                    </div>
                   
                </form>
            </div>
        </div>
        <footer class="f-12">
            <p class = "text-center">&copy; 2012 - <?php echo date('Y') ?> Webplay Nig Ltd. All Rights Reserved.</p>
            <p class = "text-center"><?php echo $date ?></p>
        </footer>
    </body>
    <script>
        $(document).ready(function () {
            $("input").on("focus", function(){
                console.log($(this).attr("placehd"));
                if($(this).val()==$(this).attr("placehd")){
                    $(this).val("");
                    $(this).toggleClass("inputcolor");
                    $(this).attr("placehd") == "Password" ? $(this).attr("type", "password") : null;
                }
            }); 
            $("input").on("blur", function(){
                console.log($(this).attr("placehd"));
                if($(this).val()==""){
                    $(this).val($(this).attr("placehd"));
                    $(this).toggleClass("inputcolor");
                    $(this).attr("placehd") == "Password" ? $(this).attr("type", "text") : null;
                }
            });
        });
        function login(){
            /*$(".btn").prop('disabled', true);*/
            if($("#username").val() != "" && $("#password").val() != ""){
                jQuery('#sendGif').toggleClass('notvisible');
            }
        }

    </script>
</html>