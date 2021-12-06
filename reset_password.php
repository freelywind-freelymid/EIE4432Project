<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="reset_password.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="reset_password.js"></script>
</head>

<body>
    <div class="header">    
        <?php include 'header.php'?>
    </div>

    <div class="reset_info_page">
        <h1 style="color:white;">Forget and reset password</h1>
        <?php           
            if(isset($_POST['reset-info-update'])){
                $user_email = trim($_POST['reset_info_page_email']);
                $user_password = trim($_POST['reset_info_page_password']);    
                
                $user_password = password_hash($user_password, PASSWORD_DEFAULT);

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
                    $stmt = $connect->prepare("UPDATE customer SET password = ? WHERE email = ?");
                    $stmt->bind_param("ss", $user_password, $user_email);
                    $stmt->execute();     
                }

                //close the connection
                mysqli_close($connect);
            }

            echo "<div class=\"reset-info\">";
            echo "<form id=\"reset-info-form\" action=\"\" method=\"post\">";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Email: </label><span id=\"reset-info-page-email-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"text\" id=\"reset_info_page_email\" name=\"reset_info_page_email\" class=\"inputBox\" />";
            echo "</div>";
            echo "</div>"; 
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Password: </label><span id=\"reset-info-page-password-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"password\" id=\"reset_info_page_password\" name=\"reset_info_page_password\" class=\"inputBox\">";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"rowData\">";
            echo "<div>";
            echo "<label>Confirm Password: </label><span id=\"reset-info-page-confirmPassword-info\" class=\"info\"></span>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"password\" id=\"reset_info_page_confirmPassword\" class=\"inputBox\">";
            echo "</div>";
            echo "</div>";
            echo "<div>";
            echo "<input type=\"submit\" id=\"reset-info-update\" name=\"reset-info-update\" value=\"Save\" />";             
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