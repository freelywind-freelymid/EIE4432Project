<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<body>
<?php
    $_SESSION['loginFlag'] = 'T';

    $loginId = trim($_POST["loginPage_loginId"]);
    $password = trim($_POST["loginPage_password"]);
            
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
        $stmt = $connect->prepare("SELECT password FROM admin WHERE name = ?");
        $stmt->bind_param("s",$loginId);
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$result){
            die("Could not successfully run query." .mysqli_error($connect));
        }
        else{
            if(mysqli_num_rows($result) == 1){
                while($row = mysqli_fetch_assoc($result)){
                    if(password_verify($password,$row['password'])){
                        $_SESSION['loginId'] = $loginId;
                        $_SESSION['loginState'] = "A";

                        $flag = true;
                    }
                }           
            }
            else{
                //is customer?
                $stmt = $connect->prepare("SELECT password FROM customer WHERE email = ?");
                $stmt->bind_param("s",$loginId);
                $stmt->execute();
                $result = $stmt->get_result();

                if(!$result){
                    die("Could not successfully run query." .mysqli_error($connect));
                }
                else{
                    if(mysqli_num_rows($result) == 1){
                        while($row = mysqli_fetch_assoc($result)){
                            if(password_verify($password,$row['password'])){
                                $_SESSION['loginId'] = $loginId;
                                $_SESSION['loginState'] = "C";

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
        $_SESSION['loginId'] = $loginId;
        $_SESSION['loginState'] = "U";   
    }

    header('Location: index.php');
?>
</body>

</html>
