<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="register.css">   
    </head>

    <body>
        <?php
            function signup()
            {
                $nickName = $_POST["registerPage_nickName"].trim();
                $userEmail = $_POST["#registerPage_userEmail"].trim();
                $birthday = $_POST["#registerPage_birthday"];
                $gender = $_POST["#registerPage_gender"];
                $userIcon = $_POST["#registerPage_userIcon"];
                $password = $_POST["#registerPage_password"].trim();

                //encrypt the password and save the encryption
                $password = password_hash($password,PASSWORD_DEFAULT);
                
                //db setting
                $server = "localhost";
                $user = "eie4432project";
                $pw = "20017556D";
                $db = "eie4432project";
                
                $flag = true;
            
                //open a connection with MySQL
                $connect = mysqli_connect($server,$user,$pw,$db);
                //test the connection
                if(!$connect){
                    die("Connection failed:" .mysqli_connect_error());
                    $flag = false;
                }
                else{

                    $stmt = $connect->prepare("SELECT * FROM user WHERE email = ?");
                    $stmt->bind_param("s",$userEmail);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if(!$result){
                        die("Could not successfully run query." .mysqli_error($connect));
                        $flag = false;
                    }
                    else{
                        if(mysqli_num_rows($result) == 0){
                            //$stmt = $connect->prepare("INSERT INTO user (nickName, email, ) VALUES (?,?,?,?,?,?)");
                            //$stmt->bind_param("ssssss", $nickName, $userEmail, $birthday, $gender, $password);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if(!$result){
                                die("Could not successfully run query." .mysqli_error($connect));
                                $flag = false;
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

            if(isset($_POST["registerPage_register"]))
            {
                signup();
            } 
        ?>

        <div id="register-popup">
            <form class="register-form" action="register.php" id="register-form" method="post">
                <h1>Register</h1>
                <div class="rowData">
                    <div>
                        <label>Nick Name: </label><span id="nickName-info" class="info"></span>
                    </div>
                    <div>
                        <input type="text" id="registerPage_nickName" name="registerPage_nickName" class="inputBox" />
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Email: </label><span id="userEmail-info" class="info"></span>
                    </div>
                    <div>
                        <input type="text" id="registerPage_userEmail" name="registerPage_userEmail" class="inputBox" />
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Birthday: </label><span id="birthday-info" class="info"></span>
                    </div>
                    <div>
                        <input type="date" id="registerPage_birthday" name="registerPage_birthday" class="inputBox"></textarea>
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Gender: </label><span id="gender-info" name="gender-info" class="info"></span>
                    </div>
                    <div>
                        <select id="registerPage_gender" name="gender" class="inputSelect">
                            <option class="inputOption" value=""></option>
                            <option class="inputOption" value="M">Male</option>
                            <option class="inputOption" value="F">Female</option>
                            <option class="inputOption" value="O">Others</option>
                        </select>
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Profile image: </label><span id="userIcon-info" class="info"></span>
                    </div>
                    <div>
                        <input type="file" id="registerPage_userIcon" name="registerPage_userIcon" accept="image/*" class="inputBox">
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Password: </label><span id="password-info" class="info"></span>
                    </div>
                    <div>
                        <input type="password" id="registerPage_password" name="registerPage_password" class="inputBox">
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Confirm Password: </label><span id="confirmPassword-info" class="info"></span>
                    </div>
                    <div>
                        <input type="password" id="registerPage_confirmPassword" class="inputBox">
                    </div>
                </div>
                <div>
                    <table>
                        <tr>
                            <td width=33%><input type="submit" id="registerPage_register" name="registerPage_register" value="Register" /></td>
                            <td width=33%><input type="reset" id="registerPage_reset" value="Reset" /></td>
                            <td width=33%><button id="registerPage_back">Back</button></td>
                        </tr>
                    </table>               
                </div>
            </form>
        </div>
    </body>
</html>
