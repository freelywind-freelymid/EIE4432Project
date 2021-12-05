<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="createItem.css">   
    </head>

    <body>
        <?php
            function create()
            {
                $description = trim($_POST["createItem_description"]);
                $price = $_POST["createItem_price"];
                $active = 'T';
                if(empty($_POST["createItem_active"])){
                    $active = 'F';
                }
                $typeID = 0;
                //$typeID = $_POST["createItem_typeID"];
                $qty = $_POST["createItem_qty"];

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
                        $stmt = $connect->prepare("INSERT INTO item (description, price, active, typeID, qty) VALUES (?,?,?,?,?)");
                        $stmt->bind_param("sssss", $description, $price, $active, $typeID, $qty);
                        $stmt->execute();

                        $stmt = $connect->prepare("SELECT MAX(itemID) as id FROM item");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if(!$result){
                            die("Could not successfully run query." .mysqli_error($connect));
                            $flag = false;
                        }
                        else{
                            while($row = mysqli_fetch_assoc($result)) {
                                if(mysqli_num_rows($result) == 0){
                                    $path_header = 'res/image/item/';
                                    $final_path = null;
                                    $itemID = $row['id'];
                                            
                                    // limit the file size
                                    if ($_FILES['createItem_itemImg']['size'] <= 500000) {
                                        $file = $_FILES['createItem_itemImg']['tmp_name'];

                                        //rename the file
                                        $newfilename = $itemID . '.' . strtolower(end(explode('.',$_FILES['createItem_itemImg']['name'])));
                                                
                                        $dest = $path_header . $newfilename;
                                        $final_path = $dest;

                                        //is file exists?
                                        if(file_exists($dest) > 0){
                                            //delete the file            
                                            unlink($dest);
                                        }
                                        move_uploaded_file($file, $dest);              

                                        $stmt = $connect->prepare("UPDATE item SET img_path = ? WHERE itemID = ?");
                                        $stmt->bind_param("ss", $dest, $itemID);
                                        $stmt->execute();
                                    }
                                }              
                            }
                        }             
                    }

                    //close the connection
                    mysqli_close($connect);
                }
                
                if($flag){
                    echo '<script>alert("Create succes!")</script>';                  
                }
                else{
                    echo '<script>alert("Create fail!")</script>';
                }
            }

            if(isset($_POST["createItem_create"]))
            {
                create();
            } 
        ?>

        <div id="createItem-popup">
            <form class="createItem-form" action="" id="createItem-form" method="post" enctype="multipart/form-data">
                <h1>Add new item</h1>
                <div class="rowData">
                    <div>
                        <label>Description: </label><span id="description-info" class="info"></span>
                    </div>
                    <div>
                        <input type="text" id="createItem_description" name="createItem_description" class="inputBox" />
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Price: </label><span id="price-info" class="info"></span>
                    </div>
                    <div>
                        <input type="number" id="createItem_price" name="createItem_price" class="inputBox" min="0.1" step="0.1" />
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Qty: </label><span id="qty-info" class="info"></span>
                    </div>
                    <div>
                        <input type="number" id="createItem_qty" name="createItem_qty" class="inputBox" min="1" step="1"></textarea>
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Active: </label><span id="active-info" class="info"></span>
                    </div>
                    <div>
                        <input type="checkbox" id="createItem_active" name="createItem_active" value="T" class="inputBox" checked>
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Image: </label><span id="itemImg-info" class="info"></span>
                    </div>
                    <div>
                        <input type="file" id="createItem_itemImg" name="createItem_itemImg" accept="image/*" class="inputBox">
                    </div>
                </div>
                <div>
                    <table>
                        <tr>
                            <td width=33%><input type="submit" id="createItem_create" name="createItem_create" value="Add" /></td>
                            <td width=33%><input type="reset" id="createItem_reset" value="Reset" /></td>
                            <td width=33%><button id="createItem_back">Back</button></td>
                        </tr>
                    </table>               
                </div>
            </form>
        </div>
    </body>
</html>
