<?php
    session_start();
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
            if(isset($_POST[''])){
                $loginId = $_SESSION['loginId'];
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
                        }
                    }       
                }

                //close the connection
                mysqli_close($connect);
            }
        ?>
    </div>

    <div class="footer">
        <?php include 'footer.php'?>
    </div>
</body>

</html>