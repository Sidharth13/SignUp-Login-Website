<?php

session_start();

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
    
    $email = mysqli_real_escape_string($con, $_POST['email']);
    
    $emailquery = " select * from registration where email='$email' "; // to check if the particular email is already present in database
    $query = mysqli_query($con,$emailquery);

    $emailcount = mysqli_num_rows($query);

    if($emailcount){ // now it will check if the email is registered before , now it can't be used again.

                $namedata = mysqli_fetch_array($query);

                $name = $namedata['name'];
                $token = $namedata['token'];

                    $subject = "Password Reset";
                    $body = "Hi, $name. Click here to reset your password ("Url of your website")/signup/reset_password.php?token=$token ";
                    $sender_email = "From: ";
                
                    if (mail($email, $subject, $body, $sender_email)) {
                        $_SESSION['msg'] = "Check your mail to reset your password $email";
                        header('location:login.php');
                    } else {
                        ?>
                            <script>
                                alert("Email sending failed...");
                            </script>
                        <?php
                    }
                
            }else{
                ?>
                    <script>
                        alert("No email found");
                    </script>
                <?php
            }

}

?>


        <div class="card bg-light">
        <article class="card-body mx-auto" style="max-width: 400px;">
            <h4 class="card-title mt-3 text-centre">Recover Your Account</h4>
            <p class="text-center">Enter your email correctly</p>

            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST"> <!-- html entities so that the page will redirect -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" class="form-control" placeholder="Email Address" type="email" required>
                    </div> <!-- form group// -->
                   
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block"> Send Mail </button>
                    </div> <!-- form group// -->
                    <p class="text-center">Have an account? <a href="login.php">Log In</a></p>
            </form>
        </article>
        </div> <!-- card.// -->
    </body>
</html>