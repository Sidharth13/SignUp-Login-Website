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
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    $pass = password_hash($password, PASSWORD_BCRYPT); // to convert your pasword into hash value for more security 
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

    $token = bin2hex(random_bytes(15)); // token varibale which will give random tokens when user login's.

    $emailquery = " select * from registration where email='$email' "; // to check if the particular email is already present in database
    $query = mysqli_query($con,$emailquery);

    $emailcount = mysqli_num_rows($query);

    if($emailcount>0){ // now it will check if the email is registered before , now it can't be used again.
        ?>
             <script>
                alert("Email already exists");
            </script>
        <?php
    }else{ // if not registered then check the password if it is matching or not.
        if($password === $cpassword){
            $insertquery = "insert into registration( name, email, password, cpassword, token, status) values('$name','$email','$pass','$cpass','$token','inactive')";

            $iquery = mysqli_query($con, $insertquery);

            if($iquery){ // this query will tell that data is insereted or not
                     
                
                    $subject = "Email Activation";
                    $body = "Hi, $name. Click here to activate your account (Url of your website/signup/activate.php)?token=$token ";
                    $sender_email = "From: ";
                
                    if (mail($email, $subject, $body, $sender_email)) {
                        $_SESSION['msg'] = "Check your mail to activate your account $email";
                        header('location:login.php');
                    } else {
                        echo "Email sending failed...";
                    }



                }else{
                        ?>
                            <script>
                                alert("Not Inserted");
                            </script>
                        <?php
                    }
          }else{
                ?>
                    <script>
                        alert("Password is not matching");
                    </script>
                <?php
            }
        }
    

}
?>


        <div class="card bg-light">
        <article class="card-body mx-auto" style="max-width: 400px;">
            <h4 class="card-title mt-3 text-centre">Create Account</h4>
            <p class="text-center">Get Started with your free account</p>
            <p>
                <a href="" class="btn btn-block btn-gmail"> <i class="fa fa-google"></i>  Login via Gmail</a>
                <a href="" class="btn btn-block btn-facebook"> <i class="fa fa-facebook-f"></i>  Login via facebook</a>
            </p>
            <p class="divider-text">
                <span class="bg-light">OR</span>
            </p>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST"> <!-- html entities so that the page will redirect -->
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                    </div>
                    <input name="name" class="form-control" placeholder="Full Name" type="text" required>
                    </div> <!-- form group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" class="form-control" placeholder="Email Address" type="email" required>
                    </div> <!-- form group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" placeholder="Create Password" type="password" name="password" value="" required>
                        </div> <!-- form group// -->
                        <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" placeholder="Repeat Password" type="password" name="cpassword" value="" required>
                        </div> <!-- form group// -->
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block"> Create Account </button>
                    </div> <!-- form group// -->
                    <p class="text-center">Have an account? <a href="login.php">Log In</a></p>
            </form>
        </article>
        </div> <!-- card.// -->
    </body>
</html>