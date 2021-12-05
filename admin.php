<?php
    session_start();
?>

<?php
    if(isset($_SESSION['loginState'])){
        if($_SESSION['loginState'] != 'A'){
            header('Location: index.php');
        }
    }
    else{
        header('Location: index.php');
    }
?>

<?php
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
        $stmt = $connect->prepare("SELECT * FROM item");
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$result){
            die("Could not successfully run query." .mysqli_error($connect));
        }
        else{
            $admin_items = array();
            while($row = mysqli_fetch_assoc($result)){
                $admin_item = array();
                array_push($admin_item, $row['itemID']);
                array_push($admin_item, $row['description']);
                array_push($admin_item, $row['price']);
                array_push($admin_item, $row['img_path']);
                array_push($admin_item, $row['active']);
                array_push($admin_item, $row['typeID']);
                array_push($admin_item, $row['qty']);

                array_push($admin_items, $admin_item);
            }

            $_SESSION['admin_items'] = $admin_items;
        }
        
        $stmt = $connect->prepare("SELECT transaction.transID, customer.nickName, transaction.date
                                    FROM customer, transaction
                                    WHERE transaction.custID = customer.custID
                                    ORDER BY customer.nickName ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $admin_record_upper = array();
        if(!$result){
            die("Could not successfully run query." .mysqli_error($connect));
        }
        else{     
            while($row = mysqli_fetch_assoc($result)){
                $admin_record_upper_array = array();
                array_push($admin_record_upper_array, $row['transID']);
                array_push($admin_record_upper_array, $row['nickName']);
                array_push($admin_record_upper_array, $row['date']);

                array_push($admin_record_upper, $admin_record_upper_array);
            }
        }

        $admin_record_whole = array();
        foreach($admin_record_upper as $admin_record_upper_item){
            $stmt = $connect->prepare("SELECT item.description, trans_detail.price, trans_detail.qty  
                                    FROM item, trans_detail
                                    WHERE trans_detail.transID = ?");
            $stmt->bind_param("s", $admin_record_upper_item[0]);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if(!$result){
                die("Could not successfully run query." .mysqli_error($connect));
            }
            else{
                while($row = mysqli_fetch_assoc($result)){
                    $admin_record_whole_item = array();
                    array_push($admin_record_whole_item, $admin_record_upper_item[0]);
                    array_push($admin_record_whole_item, $admin_record_upper_item[2]);
                    array_push($admin_record_whole_item, $admin_record_upper_item[1]);
                    array_push($admin_record_whole_item, $row['description']);
                    array_push($admin_record_whole_item, $row['price']);
                    array_push($admin_record_whole_item, $row['qty']);

                    array_push($admin_record_whole, $admin_record_whole_item);
                }

                $_SESSION['admin_record_whole'] = $admin_record_whole;
            }
        }
    }

    //close the connection
    mysqli_close($connect);
?>

<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="admin.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="header">    
        <?php include 'header.php'?>
    </div>

    <h1 style="color:white; text-align:center;">Admin Control panel</h1>
    <div class="admin_butt">
        <button id="butt_create">Create a new item</button>
        <button id="butt_viewupdate" onClick="location.href='#viewupdate'">View/Update the stock</button>
        <button id="butt_allRecord" onClick="location.href='#allRecord'">View purchase records</button>
        <div>
            <form>
                <span style="color:white; font-size:18px;">Seaching purchase records which customer ID is </span>
                <input id="search_custID" type="number" value="1" min="1">
                <input type=submit id="butt_searchRecord" value="Search">
            </form>
        </div>        
    </div>

    <a name="allRecord"></a>
    <div class="admin_sale_recond">
        <?php
            $admin_record_whole = $_SESSION['admin_record_whole'];

            echo "<tabel>";
            echo "<tr>";
            echo "<th>";
            echo "Transcation ID";
            echo "</th>";
            echo "<th>";
            echo "Date";
            echo "</th>";
            echo "<th>";
            echo "Nick name";
            echo "</th>";
            echo "<th>";
            echo "Description";
            echo "</th>";
            echo "<th>";
            echo "Price of each";
            echo "</th>";
            echo "<th>";
            echo "Qty";
            echo "</th>";
            echo "</tr>";
            foreach($admin_record_whole as $admin_record_whole_item){              
                echo "<tr>";
                echo "<td>";       
                echo $admin_record_whole_item[0];
                echo "</td>";

                echo "<td>";
                echo $admin_record_whole_item[1];
                echo "</td>";

                echo "<td>";
                echo $admin_record_whole_item[2];
                echo "</td>";

                echo "<td>";
                echo $admin_record_whole_item[3];
                echo "</td>";

                echo "<td>";
                echo "$".$admin_record_whole_item[4];
                echo "</td>";

                echo "<td>";
                echo $admin_record_whole_item[5];
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </div>

    <a name="viewupdate"></a>
    <div class="admin_items_page" id="admin_items_page">     
        <?php
            $admin_items = $_SESSION['admin_items'];

            foreach($admin_items as $admin_item){
                print "<div class=\"admin_item\">";
                
                print "<div class=\"admin_item_img\">";
                print "<img src=\"".$admin_item[3]."\">";
                print "</div>";

                print "<div class=\"admin_item_desc\">";
                print "Description:";
                print "<br>";
                print "<input id=\"admin_item_desc_".$admin_item[0]."\" type=\"text\" value=\"".$admin_item[1]."\">";
                print "</div>";

                print "<div class=\"admin_item_price_parent\">";
                print "Price of each:";
                print "<br>";
                print "$<input type=\"number\" class=\"admin_item_price\" id=\"admin_item_price_".$admin_item[0]."\" value=\"".$admin_item[2]."\" step=\"0.1\">";
                print "</div>";

                print "<div class=\"admin_item_number_parent\">";
                print "Stock qty:";
                print "<br>";
                print "<input class=\"admin_item_number\" type=\"number\" value=\"".$admin_item[6]."\" min=\"1\">";
                print "</div>";

                print "<div class=\"admin_item_active_parent\">";
                print "Active:";
                print "<br>";
                if($admin_item[4] == 'T'){
                    print "<input type=\"checkbox\" class=\"admin_item_active\" checked>";
                }
                else{
                    print "<input type=\"checkbox\" class=\"admin_item_unactive\">";
                }    
                print "</div>";

                print "<div class=\"admin_item_butt\">";
                print "<button class=\"admin_item_butt_save\">Save</button>";
                print "<button class=\"admin_item_butt_del\">Delete</button>";
                print "</div>";

                print "</div>";
            }
        ?>
    </div>

    <div class="footer">
        <?php include 'footer.php'?>
    </div>
</body>

</html>