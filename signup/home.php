<?php

session_start();

if(!isset($_SESSION['name'])){
    echo "You have been logged out";
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <?php include 'css/style.php' ?>
        <?php include 'links/links.php' ?>
        <link ref="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
<body>

<header>
    <nav class="navbar">
        <div class="logo">
        </div>

        <div class="menu">
            <ul>
                <li><a href="#" class="active"> Home </a></li>
                <li><a href="#" > Gallery </a></li>
                <li><a href="#" > Services </a></li>
                <li><a href="#" > Portfolio </a></li>
                <li><a href="#" > About </a></li>
            </ul>
        </div>

        <div class="contact_btn">
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="center_content">
        <h1> Hello this is <?php echo $_SESSION['name']; ?></h1>
    </div>

    <div class="social_network">
        <div class="fa_icons">
            <a href="#">
                <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
        </div>
        <div class="fa_icons">
            <a href="#">
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
        </div>
    </div>
     
    

</header>

</body>
</html>
    
        
