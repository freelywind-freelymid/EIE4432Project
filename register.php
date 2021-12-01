<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="register.css">   
    </head>

    <body>
        <?php
            function showErrMsg(){

            }

            function showResult(){
                if($flag){
                    echo '<script>alert("Register succes!")</script>';                  
                }
                else{
                    echo '<script>alert("Register fail!")</script>';
                }
            }

            function signup()
            {
                $nickName = trim($_POST["registerPage_nickName"]);
                $userEmail = trim($_POST["registerPage_userEmail"]);
                $birthday = $_POST["registerPage_birthday"];
                $gender = $_POST["registerPage_gender"];
                $password = trim($_POST["registerPage_password"]);

                //encrypt the password and save the encryption
                $password = password_hash($password,PASSWORD_DEFAULT);
                             
                $flag = true;         
            
                if($flag){
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
                        $flag = false;
                    }
                    else{
                        $stmt = $connect->prepare("SELECT * FROM customer WHERE email = ?");
                        $stmt->bind_param("s",$userEmail);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if(!$result){
                            die("Could not successfully run query." .mysqli_error($connect));
                            $flag = false;
                        }
                        else{
                            if(mysqli_num_rows($result) == 0){

                                $icon_path_header = 'res/image/user/icon/';
                                $icon_final_path = null;

                                //if(count($_FILES) > 0){
                                    $file = $_FILES['registerPage_userIcon']['tmp_name'];

                                    //rename the file
                                    $newfilename = $userEmail . '.' . $_FILES['registerPage_userIcon']['type'];
                                    
                                    $dest = $icon_path_header . $newfilename;
                                    $icon_final_path = $dest;
                                    
                                    move_uploaded_file($file, $dest);
                                //}                               

                                $stmt = $connect->prepare("INSERT INTO customer (nickName, email, icon_path, gender, birthday, password) VALUES (?,?,?,?,?,?)");
                                $stmt->bind_param("ssssss", $nickName, $userEmail, $icon_final_path, $gender, $birthday, $password);
                                $stmt->execute();
                            }
                            else{
                                $flag = false;
                                showErrMsg();
                            }
                        }                   
                    }

                    //close the connection
                    mysqli_close($connect);
                }
                echo '<script>alert('.$_FILES['registerPage_userIcon']['name'].')</script>';
                //echo '<script>alert('.$icon_final_path.')</script>';
                //showResult();
            }

            if(isset($_POST["registerPage_register"]))
            {
                signup();
            } 
        ?>

        <div id="register-popup">
            <form class="register-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" id="register-form" method="post">
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
                        <select id="registerPage_gender" name="registerPage_gender" name="gender" class="inputSelect">
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
                        <input type="file" id="registerPage_userIcon" name="registerPage_userIcon" enctype="multipart/form-data" accept="image/*" class="inputBox">
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
