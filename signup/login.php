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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_search = " select * from registration where email='$email' and status='active' "; // it will search if the email is already present in database or not.
    $query = mysqli_query($con,$email_search);

    $email_count = mysqli_num_rows($query);

    if($email_count){// it will check if the password is matching from database or not
        $email_pass = mysqli_fetch_assoc($query);

        $db_pass = $email_pass['password'];

        $_SESSION['name'] = $email_pass['name']; // this will fetch the name of user.

        $pass_decode = password_verify($password, $db_pass);

        if($pass_decode){ // it will tell if the password which user entered  in database is correct then login successful otherwise not.
            
            if(isset($_POST['rememberme'])){

                setcookie('emailcookie',$email,time()+86400); // it will restore the email id in it for 24 hours , till that time user will not provie his credentials.
                setcookie('passwordcookie',$password,time()+86400); // it will restore the email id in it for 24 hours , till that time user will not provie his credentials.

                header('location:home.php'); // it will redirect you to home page after successful login
            }else{
                header('location:home.php'); // it will redirect you to home page after successful login
            }

             

        }else {
            ?>
                <script>
                    alert("Password Incorrect");
                </script>
            <?php
        }
    }else{
        ?>
            <script>
                alert("Invalid Email");
            </script>
        <?php
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

    <div>
       <p class="bg-success text-white px-4"> <?php 
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg']; 
            }else{
                echo $_SESSION['msg'] = "You are logged out. Please login again";
            }
       
        ?> </p> 
    </div>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST"> <!-- html entities so that the page will redirect -->
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
        </div>
        <input name="email" class="form-control" placeholder="Email Address" type="email" value="<?php if(isset($_COOKIE['emailcookie'])) { echo $_COOKIE['emailcookie']; } ?>" >
    </div> <!-- form group// -->
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        </div>
        <input class="form-control" placeholder="Enter Password" type="password" name="password" value="<?php if(isset($_COOKIE['passwordcookie'])) { echo $_COOKIE['passwordcookie']; } ?>" >
    </div> <!-- form group// -->

    <div class="form-group">
        <input type="checkbox" name="rememberme" > Remember Me
    </div>

    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary btn-block"> Login Now </button>
    </div> <!-- form group// -->
    <p class="text-center">Forgot Your Password . Don't Worry? <a href="recover_email.php"> Click Here</a></p>
    <p class="text-center">Not Have an account? <a href="regis.php"> SignUp Here</a></p>
    </form>
</article>
</div> <!-- card.// -->
</body>
</html>

