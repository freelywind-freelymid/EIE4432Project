<?php
    session_start();

    if(isset($_SESSION['loginState'])){
        if($_SESSION['loginState'] == 'A'){
            header('Location: admin.php');
        }
        else if($_SESSION['loginState'] == 'U'){
            header('Location: index.php');
        }
    }
    else{
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="user_file.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="user_file.js"></script>
</head>

<body>
    <div class="header">    
        <?php include 'header.php'?>
    </div>

    <div class="user_info_page">
        <h1 style="color:white;">User file</h1>
        <?php
            $loginId = $_SESSION['loginId'];

            $flag = true;

            $user_nickName = "";
            $user_email = "";
            $icon_path = "";
            $user_gender = "";
            $user_birthday = "";
            $user_password = "";

            //db setting
            $server = "localhost";
            $user = "eie4432project";
            $pw = "20017556D";
            $db = "eie4432project";

            //open a connection with MySQL
            $connect = mysqli_connect($server,$user,$pw,$db);

            if(isset($_POST['user-info-update'])){
                $user_nickName = trim($_POST['user_info_page_nickName']);
                $user_email = trim($_POST['user_info_page_userEmail']);
                $user_gender = $_POST['user_info_page_gender'];
                $user_birthday = $_POST['user_info_page_birthday'];
                $user_old_password = trim($_POST['user_info_page_old_password']);
                $user_password = trim($_POST['user_info_page_password']);     

                if($user_password != ""){
                    if(password_verify($user_old_password, $_SESSION['old_password'])){
                        $user_password = password_hash($user_password);
    
                        $user_email = $_SESSION['user_email'];
    
                        if(file_exists($_FILES['user_info_page_userIcon']['tmp_name'])){
                            $path_header = 'res/image/user/icon/';
                    
                            // limit the file size
                            if ($_FILES['user_info_page_userIcon']['size'] <= 500000) {
                                $file = $_FILES['user_info_page_userIcon']['tmp_name'];
                                //rename the file
                                $newfilename = $user_email . '.' . strtolower(end(explode('.',$_FILES['user_info_page_userIcon']['name'])));
                                                            
                                $dest = $path_header . $newfilename;
                    
                                //is file exists?
                                if(file_exists($dest) > 0){
                                    //delete the file            
                                    unlink($dest);
                                }
                                move_uploaded_file($file, $dest);
                                
                                //test the connection
                                if(!$connect){
                                    die("Connection failed:" .mysqli_connect_error());
                                }
                                else{
                                    $stmt = $connect->prepare("UPDATE customer 
                                                                SET nickName = ?, email = ?, icon_path = ?, gender = ?, birthday = ?, password = ?
                                                                WHERE custID = ?");
                                    $stmt->bind_param("sssssss", $user_nickName, $user_email, $dest, $user_gender, $user_birthday, $user_password, $loginId);
                                    $stmt->execute(); 
                                }
                            }
                            else{
                                $flag = false;
                            }
                        }
                        else{
                            //test the connection
                            if(!$connect){
                                die("Connection failed:" .mysqli_connect_error());
                            }
                            else{
                                $stmt = $connect->prepare("UPDATE customer 
                                                            SET nickName = ?, email = ?, gender = ?, birthday = ?, password = ?
                                                            WHERE custID = ?");
                                $stmt->bind_param("ssssss", $user_nickName, $user_email, $user_gender, $user_birthday, $user_password, $loginId);
                                $stmt->execute(); 
                            }
                        }
                    }
                    else{
                        $flag = false;
                    }
                }
                else{
                    $user_email = $_SESSION['user_email'];
    
                    if(file_exists($_FILES['user_info_page_userIcon']['tmp_name'])){
                        $path_header = 'res/image/user/icon/';
                    
                        // limit the file size
                        if ($_FILES['user_info_page_userIcon']['size'] <= 500000) {
                            $file = $_FILES['user_info_page_userIcon']['tmp_name'];
                            //rename the file
                            $newfilename = $user_email . '.' . strtolower(end(explode('.',$_FILES['user_info_page_userIcon']['name'])));
                                                            
                            $dest = $path_header . $newfilename;
                    
                            //is file exists?
                            if(file_exists($dest) > 0){
                                //delete the file            
                                unlink($dest);
                            }
                            move_uploaded_file($file, $dest);
                                
                            //test the connection
                            if(!$connect){
                                die("Connection failed:" .mysqli_connect_error());
                            }
                            else{
                                $stmt = $connect->prepare("UPDATE customer 
                                                            SET nickName = ?, email = ?, icon_path = ?, gender = ?, birthday = ?
                                                            WHERE custID = ?");
                                $stmt->bind_param("ssssss", $user_nickName, $user_email, $dest, $user_gender, $user_birthday, $loginId);
                                $stmt->execute(); 
                            }
                        }
                        else{
                            $flag = false;
                        }
                    }
                    else{
                        //test the connection
                        if(!$connect){
                            die("Connection failed:" .mysqli_connect_error());
                        }
                        else{
                            $stmt = $connect->prepare("UPDATE customer 
                                                        SET nickName = ?, email = ?, gender = ?, birthday = ?
                                                        WHERE custID = ?");
                            $stmt->bind_param("sssss", $user_nickName, $user_email, $user_gender, $user_birthday, $loginId);
                            $stmt->execute(); 
                        }
                    }
                }
            }

            //test the connection
            if(!$connect){
                die("Connection failed:" .mysqli_connect_error());
            }
            else{
                $stmt = $connect->prepare("SELECT nickName, email, icon_path, gender, birthday, password
                                            FROM customer
                                            WHERE custID = ?");
                $stmt->bind_param("s", $loginId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if(!$result){
                    die("Could not successfully run query." .mysqli_error($connect));
                }
                else{     
                    while($row = mysqli_fetch_assoc($result)){
                        $user_nickName = $row['nickName'];
                        $user_email = $row['email'];
                        $icon_path = $row['icon_path'];
                        $user_gender = $row['gender'];
                        $user_birthday = $row['birthday'];
                        $user_password = $row['password'];

                        $_SESSION['user_email'] = $user_email;
                        $_SESSION['old_password'] = $user_password;
                    }
                }       
            }

            //close the connection
            mysqli_close($connect);

            echo "<div class=\"user-info\">";
            echo "<form id=\"user-info-form\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Nick Name: </label><span id=\"user-info-page-nickName-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"text\" id=\"user_info_page_nickName\" name=\"user_info_page_nickName\" class=\"inputBox\" value=\"".$user_nickName."\" />";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Email: </label><span id=\"user-info-page-userEmail-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"text\" id=\"user_info_page_userEmail\" name=\"user_info_page_userEmail\" class=\"inputBox\" value=\"".$user_email."\"/>";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Birthday: </label><span id=\"user-info-page-birthday-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"date\" id=\"user_info_page_birthday\" name=\"user_info_page_birthday\" class=\"inputBox\" value=\"".$user_birthday."\">";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Gender: </label><span id=\"user-info-page-gender-info\" name=\"gender-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<select id=\"user_info_page_gender\" name=\"user_info_page_gender\" class=\"inputSelect\">";
            echo "<option class=\"inputOption\" value=\"\"></option>";
            echo "<option class=\"inputOption\" value=\"M\"";
            if($user_gender == "M"){ echo " selected";}
            echo ">Male</option>";
            echo "<option class=\"inputOption\" value=\"F\"";       
            if($user_gender == "F"){ echo " selected";}
            echo ">Female</option>";
            echo "<option class=\"inputOption\" value=\"O\"";
            if($user_gender == "O"){ echo " selected";}
            echo ">Others</option>";
            echo "</select>";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Profile image: </label><span id=\"user-info-page-userIcon-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<img src=\"".$icon_path."\">";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"file\" id=\"user_info_page_userIcon\" name=\"user_info_page_userIcon\" accept=\"image/*\" class=\"inputBox\">";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Old password: </label><span id=\"user-info-page-old-password-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"password\" id=\"user_info_page_old_password\" name=\"user_info_page_old_password\" class=\"inputBox\">";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>New password: </label><span id=\"user-info-page-password-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"password\" id=\"user_info_page_password\" name=\"user_info_page_password\" class=\"inputBox\">";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Confirm Password: </label><span id=\"user-info-page-confirmPassword-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"password\" id=\"user_info_page_confirmPassword\" class=\"inputBox\">";
            echo "</div>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"submit\" id=\"user-info-update\" name=\"user-info-update\" value=\"Save\" />";             
            echo "</div>";
            echo "</form>";
            echo "</div>";
        ?>
    </div>

    <div class="footer">
        <?php include 'footer.php'?>
    </div>
</body>

</html>