<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <?php include 'css/style.php' ?>
        <?php include 'links/links.php' ?>
    </head>
    <body>

<?php

include 'dbcon.php';
if(isset($_POST['submit'])){

    if(isset($_GET['token'])){

    $token = $_GET['token'];
    
    $newpassword = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    $pass = password_hash($newpassword, PASSWORD_BCRYPT); // to convert your pasword into hash value for more security 
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

        
        
        
        if($newpassword === $cpassword){
            
            $updatequery = " update registration set password='$pass' where token='$token' ";

            $iquery = mysqli_query($con, $updatequery);

            if($iquery){ // this query will tell that data is insereted or not
                     
                    $_SESSION['msg'] = "Your password has been updated";
                    header('location:login.php');


                }else{
                    $_SESSION['passmsg'] = "Your password is not updated";
                    header('location:reset_password.php');  
                }
        }else{
            $_SESSION['passmsg'] = "Your password is not matching";
         }
    }else{
        ?>
            <script>
            alert("No token found");
            </script>
        <?php
        }    

}

?>


        <div class="card bg-light">
        <article class="card-body mx-auto" style="max-width: 400px;">
            <h4 class="card-title mt-3 text-centre">Reset Password</h4>
            <p class="text-center">Create your new password</p>

            <p class="bg-info text-white px=4"> <?php 
            
                if(isset($_SESSION['passmsg'])){
                    echo $_SESSION['passmsg'];
                }else{
                    echo $_SESSION['passmsg'] = ""; 
                }
            ?> </p>
            
            <form action="" method="POST"> <!-- html entities so that the page will redirect -->
                <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" placeholder="New Password" type="password" name="password" value="" required>
                        </div> <!-- form group// -->
                        <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" placeholder="Confirm Password" type="password" name="cpassword" value="" required>
                        </div> <!-- form group// -->
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block"> Update Password </button>
                    </div> <!-- form group// -->
                    
                    <p class="text-center">Have an account? <a href="login.php">Log In</a></p>
            </form>
        </article>
        </div> <!-- card.// -->
    </body>
</html>
