<!DOCTYPE html>
<html>

<head>
<title>20017556D EIE4432 Project</title>

<link rel="stylesheet" href="header.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="register.js"></script>
<script src="login.js"></script>
</head>

<body>
    <div class="topnav">
        <table>
            <tr>
                <th rowspan="2"><img class="dropbtn" name="company_icon" src="res/image/ui/company_icon.png" height="70"></th>
                <th>
                    <ul>
                        <li class="dropdown">
                            <div class="dropdown-Title">Women</div>
                            <div class="dropdown-content">
                            </div>
                        </li>
                    </ul>
                </th>
                <th>
                    <ul>
                        <li class="dropdown">
                            <div class="dropdown-Title">Men</div>
                            <div class="dropdown-content">
                            </div>
                        </li>
                    </ul>
                </th>
                <th>
                    <ul>
                        <li class="dropdown">
                            <div class="dropdown-Title">Others</div>
                            <div class="dropdown-content">
                            </div>
                        </li>
                    </ul>
                </th>
                <th>
                    <ul>
                        <li class="dropdown">
                            <div class="dropdown-Title">Popular</div>
                            <div class="dropdown-content">
                            </div>
                        </li>
                    </ul>
                </th>
                
                <th class="title-right loginbtn"><div class="dropbtn title-right" id="login">Login</div></th>
                <th class="title-right"><div class="dropbtn title-right" id="register">Register</div></th>
                <th class="title-right"><div class="dropbtn">Shipping Cart<img src="res/image/ui/cart.png" height="15"></div></th>
            </tr>
            <tr>
                <form>
                    <div class="search_part">
                        <td colspan="7"><input class="search_bar" id="search_bar" type="search" alt="seacrh bar"></td>
                        <td><button><img src="res/image/ui/search.png" alt="search"></button></td>
                    </div>
                </form>          
            </tr>
        </table>
    </div>

    <div class="registerPage">
        <?php include 'register.php'?>
    </div>

    <div class="loginPage">
        <?php include 'login.php'?>
    </div>

</body>

</html>
