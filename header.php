<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="header.css">
<script src="register.js"></script>
<script src="login.js"></script>
<script src="sign-out.js"></script>
<script src="header.js"></script>
</head>

<body>
    <div class="topnav">
        <table>
            <tr>
                <?php
                    if(isset($_SESSION['loginState'])){
                        if($_SESSION['loginState'] != 'A'){
                            echo '<th class="company_icon_col return-home"><img id="company_icon" name="company_icon" src="res/image/ui/company_icon.png" height="30"></th>';             
                        }
                        else{
                            echo '<th class="company_icon_col return-admin-home"><img id="company_icon" name="company_icon" src="res/image/ui/company_icon.png" height="30"></th>';
                        }
                    }
                    else{
                        echo '<th class="company_icon_col return-home"><img id="company_icon" name="company_icon" src="res/image/ui/company_icon.png" height="30"></th>';
                    }
                ?>
                
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
                <?php
                    if(isset($_SESSION['loginState'])){
                        if($_SESSION['loginState'] == 'U'){
                            echo '<th class="title-right"><div id="register">Register</div></th>';
                            echo '<th class="title-right"><div id="login">Login</div></th>';               
                        }
                        else if($_SESSION['loginState'] == 'C'){
                            $loginId = $_SESSION['loginId'];
                            $icon_path = null;

                            //db setting
                            $server = "localhost";
                            $user = "eie4432project";
                            $pw = "20017556D";
                            $db = "eie4432project";

                            //open a connection with MySQL
                            $connect = mysqli_connect($server,$user,$pw,$db);

                            //test the connection
                            if(!$connect){
                                die("Connection failed:" .mysqli_connect_error());
                            }
                            else{
                                $stmt = $connect->prepare("SELECT icon_path FROM customer WHERE custID = ?");
                                $stmt->bind_param("s", $loginId);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while($row = mysqli_fetch_assoc($result)){
                                    $icon_path = $row['icon_path'];
                                }
                            }

                            //close the connection
                            mysqli_close($connect);
            
                            echo '<th class="title-right"><div><img id="cart" src="res/image/ui/cart.png" height="30"></div></th>';
                            echo "<th class=\"title-right\"><div><img id=\"user_icon\" src=\"".$icon_path."\" height=\"30\"></div></th>";
                            echo '<th class="title-right"><div id="sign-out">Sign Out</div>';
                        }
                        else if($_SESSION['loginState'] == 'A'){
                            echo '<th class="title-right"><div id="sign-out">Sign Out</div>';
                        }
                        else{
                            echo '<th class="title-right"><div id="register">Register</div></th>';
                            echo '<th class="title-right"><div id="login">Login</div></th>';
                        }
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
