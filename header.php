<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="header.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="register.js"></script>
<script src="login.js"></script>
<script src="sign-out.js"></script>
</head>

<body>
    <div class="topnav">
        <table>
            <tr>
                <th class="company_icon_col"><img id="company_icon" name="company_icon" src="res/image/ui/company_icon.png" height="30"></th>
                <th>
                    <div class="dropdown">
                        <div class="dropdown-Title">Women</div>
                        <div class="dropdown-content">
                        </div>
                    </div>
                </th>
                <th>
                    <div class="dropdown">
                        <div class="dropdown-Title">Men</div>
                        <div class="dropdown-content">
                        </div>
                    </div>
                </th>
                <th>
                    <div class="dropdown">
                        <div class="dropdown-Title">Others</div>
                        <div class="dropdown-content">
                        </div>
                    </div>
                </th>
                <th>
                    <div class="dropdown">
                        <div class="dropdown-Title">New arrivals</div>
                        <div class="dropdown-content">
                        </div>
                    </div>
                </th>
                <th>
                    <div class="dropdown">
                        <div class="dropdown-Title">Popular</div>
                        <div class="dropdown-content">
                        </div>
                    </div>
                </th>
                <th class="title-right"><div><img id="cart" src="res/image/ui/cart.png" height="15"></div></th>
                <?php
                    if($_SESSION['loginState'] == 'A' || $_SESSION['loginState'] == 'C'){
                        echo '<th class="title-right"><div id="sign-out">Sign Out</div>';
                    }
                    else{
                        echo '<th class="title-right"><div id="register">Register</div></th>';
                        echo '<th class="title-right"><div id="login">Login</div></th>';
                    }
                ?>               
            </tr>
        </table>
    </div>

    <div class="registerPage">
        <?php include 'register.php'?>
    </div>

    <div class="loginPage">
        <?php include 'login.html'?>
    </div>

</body>

</html>
