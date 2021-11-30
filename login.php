<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="login.css">
    </head>

    <body>
        <?php
            function login()
            {
                $loginId = trim($_POST["#loginPage_loginId"]);
                $password = trim($_POST["#loginPage_password"]);

                //encrypt the password
                $password = password_hash($password,PASSWORD_DEFAULT);
                
                //db setting
                $server = "localhost";
                $user = "eie4432project";
                $pw = "20017556D";
                $db = "eie4432project";
            
                $flag = false;

                //open a connection with MySQL
                $connect = mysqli_connect($server,$user,$pw,$db);
                //test the connection
                if(!$connect){
                    die("Connection failed:" .mysqli_connect_error());
                }
                else{
                    //is admin?
                    $stmt = $connect->prepare("SELECT pw FROM admin, admin_pw WHERE admin.name = ? and admin.adminID = admin_pw.adminID");
                    $stmt->bind_param("s",$loginId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if(!$result){
                        die("Could not successfully run query." .mysqli_error($connect));
                    }
                    else{
                        if(mysqli_num_rows($result) == 1){
                            while($row = mysqli_fetch_assoc($result)){
                                if($password == $row['pw']){
                                    setcookie("loginId", $loginId, time() + 86400, "/"); // 86400 = 1 day
                                    setcookie("loginState", "A", time() + 86400, "/"); // 86400 = 1 day

                                    $flag = true;
                                }
                            }           
                        }
                        else{
                            //is customer?
                            $stmt = $connect->prepare("SELECT pw FROM cust_pw WHERE custID = ?");
                            $stmt->bind_param("s",$loginId);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if(!$result){
                                die("Could not successfully run query." .mysqli_error($connect));
                            }
                            else{
                                if(mysqli_num_rows($result) == 1){
                                    while($row = mysqli_fetch_assoc($result)){
                                        if($password == $row['pw']){
                                            setcookie("loginId", $loginId, time() + 86400, "/"); // 86400 = 1 day
                                            setcookie("loginState", "C", time() + 86400, "/"); // 86400 = 1 day

                                            $flag = true;
                                        }
                                    }           
                                }
                            }
                        }
                    }                       
                }

                //close the connection
                mysqli_close($connect);

                if(!$flag){
                    setcookie("loginId", $loginId, time() + 86400, "/"); // 86400 = 1 day
                    setcookie("loginState", "U", time() + 86400, "/"); // 86400 = 1 day
                }
            }

            if(isset($_POST["#loginPage_login"]))
            {
                echo '<script>alert("Welcome to Geeks for Geeks")</script>';
                login();            
            }
        ?>

        <div id="login-popup">
            <form class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" id="login-form" method="post">
                <h1>Login</h1>
                <div class="rowData">
                    <div>
                        <label>Login ID: </label>
                    </div>
                    <div>
                        <input type="text" id="loginPage_loginId" name="loginPage_loginId" class="inputBox">
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Password: </label>
                    </div>
                    <div>
                        <input type="password" id="loginPage_password" name="loginPage_password" class="inputBox">
                    </div>
                    <div>
                        <a id="forgot-info">Forgot password?</a>
                    </div>
                </div>
                <div class="rowData">
                    <span id="login-info" class="info"></span>
                </div>
                <div>
                    <table>
                        <tr>
                            <td width=50%><input type="submit" id="loginPage_login" name="loginPage_login" value="Login" /></td>
                            <td width=50%><button id="loginPage_register">Register Now!</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button id="loginPage_back">Back</button></td>
                        </tr>
                    </table>               
                </div>
            </form>
        </div>
    </body>
</html>
