<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="login.css">
    </head>

    <body>
        <?php
            function showOK(){
                setcookie("loginId", $loginId, time() + 86400, "/"); // 86400 = 1 day
                setcookie("loginState", true, time() + 86400, "/"); // 86400 = 1 day
            }

            function showFail(){
                setcookie("loginId", $loginId, time() + 86400, "/"); // 86400 = 1 day
                setcookie("loginState", false, time() + 86400, "/"); // 86400 = 1 day
            }

            function login()
            {
                $loginId = $_POST["#loginPage_loginId"].trim();
                $password = $_POST["#loginPage_password"].trim();

                //encrypt the password and save the encryption
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
                    $stmt = $connect->prepare("SELECT userPassword FROM user WHERE email = ?");
                    $stmt->bind_param("s",$loginId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if(!$result){
                        die("Could not successfully run query." .mysqli_error($connect));
                    }
                    else{
                        if(mysqli_num_rows($result) == 1){
                            while($row = mysqli_fetch_assoc($result)){
                                if($password == $row['userPassword']){
                                    $flag = true;
                                }
                            }           
                        }
                    }                   
                }

                //close the connection
                mysqli_close($connect);

                if($flag){
                    showOK();
                }
                else{
                    showFail();
                }
            }

            if(isset($_POST["loginPage_login"]))
            {
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
