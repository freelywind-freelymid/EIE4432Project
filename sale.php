<?php
    session_start();

    $loginId = $_SESSION['loginId'];
    $loginState = $_SESSION['loginState'];

    $cart = $_SESSION['cart'];

    if($loginState == 'A'){
        header('Location: admin.php');      
    }
    else if($loginState != 'C'){
        header('Location: index.php');
    }

    if(isset($_POST['cart_bill'])){
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
            $today = date("Y-m-d");

            $stmt = $connect->prepare("INSERT INTO transaction (custID, date) VALUES (?,?)");
            $stmt->bind_param("ss", $loginId, $today);
            $stmt->execute();
            
            $stmt = $connect->prepare("SELECT transID from transaction WHERE custID = ? AND date = ? ORDER BY transID DESC");
            $stmt->bind_param("ss", $loginId, $today);
            $stmt->execute();
            $result = $stmt->get_result();

            $transID = null;
            if(!$result){
                die("Could not successfully run query." .mysqli_error($connect));
            }
            else{
                while($row = mysqli_fetch_assoc($result)){
                    $transID = $row['transID'];
                    break;
                }
            }

            foreach($cart as $cart_item){
                $stmt = $connect->prepare("INSERT INTO trans_detail (transID, itemID, qty, price) VALUES (?,?,?,?)");
                $stmt->bind_param("ssss",$transID, $cart_item[0], $cart_item[5], $cart_item[2]);
                $stmt->execute();
                
                $active = 'T';
                $qty = $cart_item[4] - $cart_item[5];
                if($qty <= 0){
                    $active = 'F';
                }

                $stmt = $connect->prepare("UPDATE item SET active = ?, qty = ? WHERE itemID = ?");
                $stmt->bind_param("sss", $active, $qty, $cart_item[0]);
                $stmt->execute();
            }
        }

        //close the connection
        mysqli_close($connect);

        unset($_SESSION['cart']);
        $_SESSION['saled'] = 'T';
    }

    header('Location: cart.php');
?>