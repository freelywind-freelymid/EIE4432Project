<?php
    session_start();

    $admin_items = $_SESSION['admin_items'];

    $itemID = 0;

    foreach($admin_items as $admin_item){
        if(isset($_POST['admin_item_butt_save_'.$admin_item[0]])){
            $itemID = $admin_item[0];
            break;
        }
    }

    $description = $_POST['admin_item_desc_'.$itemID];
    $price = $_POST['admin_item_price_'.$itemID];
    $qty = $_POST['admin_item_number_'.$itemID];
    $active = 'T';
    if(empty($_POST['admin_item_active_'.$itemID])){
        $active = 'F';
    }
                           
    if(file_exists($_FILES['admin_item_img_'.$itemID]['tmp_name'])){
        $path_header = 'res/image/item/';
        $final_path = null;

        // limit the file size
        if ($_FILES['admin_item_img_'.$itemID]['size'] <= 500000) {
            $file = $_FILES['admin_item_img_'.$itemID]['tmp_name'];
            //rename the file
            $newfilename = $itemID . '.' . strtolower(end(explode('.',$_FILES['admin_item_img_'.$itemID]['name'])));
                                        
            $dest = $path_header . $newfilename;
            $final_path = $dest;

            //is file exists?
            if(file_exists($dest) > 0){
                //delete the file            
                unlink($dest);
            }
            move_uploaded_file($file, $dest);              
        }
    }                                  
    
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
        $stmt = $connect->prepare("UPDATE item SET description = ?, price = ?, active = ?, qty = ? WHERE itemID = ?");
        $stmt->bind_param("sssss", $description, $price, $active, $qty, $itemID);
        $stmt->execute();   
    }

    //close the connection
    mysqli_close($connect);

    //echo '<script>alert('.$itemID.')</script>';  
    header('Location: admin.php');
?>