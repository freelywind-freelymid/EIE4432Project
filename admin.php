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

    $chartData = array();
    $clothesData = array();

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

        $stmt = $connect->prepare("SELECT item.itemID, item.description, item.img_path, COUNT(trans_detail.qty) as qty  
                                    FROM item, trans_detail
                                    WHERE item.itemID = trans_detail.itemID
                                    GROUP BY trans_detail.itemID
                                    ORDER BY COUNT(trans_detail.qty) DESC
                                    LIMIT 3");
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$result){
            die("Could not successfully run query." .mysqli_error($connect));
        }
        else{
            while($row = mysqli_fetch_assoc($result)){
                $chart_item_Data = array("label"=>$row['description'], "y"=>$row['qty']);
                
                $clotheData = array();
                array_push($clotheData, $row['itemID']);
                array_push($clotheData, $row['description']);
                array_push($clotheData, $row['img_path']);
                array_push($clotheData, $row['qty']);
                array_push($clothesData, $clotheData);

                array_push($chartData, $chart_item_Data);
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
    <script src="createItem.js"></script>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "dark1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Top 3 popular clothes"
                },
                axisY: {
                    title: "Sales amount"
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($chartData, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();        
        }
    </script>
</head>

<body style="text-align:center;">
    <div class="header">    
        <?php include 'header.php'?>
    </div>

    <h1 style="color:white;">Admin Control panel</h1>
    <div class="admin_butt">
        <button id="butt_create">Create a new item</button>
        <button id="butt_viewupdate" onClick="location.href='#viewupdate'">View/Update the stock</button>
        <button id="butt_allRecord" onClick="location.href='#allRecord'">View purchase records</button>
        <button id="butt_popular" onClick="location.href='#popolar'">View the popular clothes</button>
        <div>
            <form action="admin.php" method="post">
                <span style="color:white; font-size:18px;">Seaching purchase records which customer ID is </span>
                <input id="search_custID" name="search_custID" type="number" value="1" min="1">
                <input type=submit id="butt_searchRecord" name="butt_searchRecord" value="Search">
            </form>
        </div>        
    </div>

    <div class="createItemPage">
        <?php include 'createItem.php'?>
    </div>

    <?php
        if(isset($_POST['butt_searchRecord'])){
            $search_custID = $_POST['search_custID'];

            $customerName = "";

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
                $stmt = $connect->prepare("SELECT transaction.transID, customer.nickName, transaction.date
                                            FROM customer, transaction
                                            WHERE transaction.custID = customer.custID AND customer.custID = ?");
                $stmt->bind_param("s", $search_custID);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $admin_record_part_upper = array();
                if(!$result){
                    die("Could not successfully run query." .mysqli_error($connect));
                }
                else{     
                    while($row = mysqli_fetch_assoc($result)){
                        $admin_record_part_upper_array = array();
                        array_push($admin_record_part_upper_array, $row['transID']);
                        $customerName = $row['nickName'];
                        array_push($admin_record_part_upper_array, $row['nickName']);
                        array_push($admin_record_part_upper_array, $row['date']);

                        array_push($admin_record_part_upper, $admin_record_part_upper_array);
                    }
                }

                $admin_record_part = array();
                foreach($admin_record_part_upper as $admin_record_part_item){
                    $stmt = $connect->prepare("SELECT item.description, trans_detail.price, trans_detail.qty  
                                            FROM item, trans_detail
                                            WHERE trans_detail.transID = ?");
                    $stmt->bind_param("s", $admin_record_part_item[0]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if(!$result){
                        die("Could not successfully run query." .mysqli_error($connect));
                    }
                    else{
                        while($row = mysqli_fetch_assoc($result)){
                            $admin_record_part_item_temp = array();
                            array_push($admin_record_part_item_temp, $admin_record_part_item[0]);
                            array_push($admin_record_part_item_temp, $admin_record_part_item[2]);
                            array_push($admin_record_part_item_temp, $admin_record_part_item[1]);
                            array_push($admin_record_part_item_temp, $row['description']);
                            array_push($admin_record_part_item_temp, $row['price']);
                            array_push($admin_record_part_item_temp, $row['qty']);

                            array_push($admin_record_part, $admin_record_part_item_temp);
                        }
                    }
                }

                if(count($admin_record_part) <= 0){
                    print "<div class=\"admin_sale_record_part\">";
                    print "<h1 style=\"color:white; text-align:center;\"> No any purchase records of the customer.</h1>";
                    print "</div>";
                }
                else{
                    print "<h1 style=\"color:white; text-align:left;\">".$customerName."'s purchase records</h1>";
                    print "<div class=\"admin_sale_record_part\">";
                    print "<table>";
                    print "<tr><th>Transcation ID</th><th>Date</th><th>Nick name</th><th>Description</th><th>Price of each</th><th>Qty</th></tr>";
                    foreach($admin_record_part as $admin_record_part_item){
                        print "<tr>";
                        print "<td>".$admin_record_part_item[0]."</td>";
                        print "<td>".$admin_record_part_item[1]."</td>";
                        print "<td>".$admin_record_part_item[2]."</td>";
                        print "<td>".$admin_record_part_item[3]."</td>";
                        print "<td>$".$admin_record_part_item[4]."</td>";
                        print "<td>".$admin_record_part_item[5]."</td>";
                        print "</tr>";
                    }
                    print "</table>";
                    print "</div>";
                }             
            }

            //close the connection
            mysqli_close($connect);
        }
    ?>

    <div class="popularchart">
        <a name="popolar"></a>
        <h1 style="color:white; text-align:left;">Top 3 popular clothes</h1>
        <div class="popularDetail">
            <?php
                $counter = 1;
                foreach($clothesData as $clotheDetail){
                    echo "<div>";
                    echo "<div>";
                    echo "<b style=\"font-family: Viner Hand ITC; color:red;\">No: ".$counter."</b>";
                    echo "</div>";
                    echo "<div>";
                    echo "<img src=\"".$clotheDetail[2]."\" height=\"100px\">";
                    echo "</div>";
                    echo "<div>";
                    echo "<p>";
                    echo $clotheDetail[1];
                    echo "<br>";
                    echo "<b>Sales ".$clotheDetail[3]." item(s)</b>";
                    echo "</p>";           
                    echo "</div>";
                    echo "</div>";

                    $counter++;
                }
            ?>
        </div>
        <div id="chartContainer_parent">
            <diV id="chartContainer" style="height: 370px; width: 80%;"></div>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        </div>      
    </div>

    <a name="allRecord"></a>
    <h1 style="color:white; text-align:left;">All purchase records</h1>
    <div class="admin_sale_record">
        <?php
            $admin_record_whole = $_SESSION['admin_record_whole'];

            usort($admin_record_whole, function($a, $b) {
                return $b[1] <=> $a[1];
            });

            print "<table>";
            print "<tr><th>Transcation ID</th><th>Date</th><th>Nick name</th><th>Description</th><th>Price of each</th><th>Qty</th></tr>";
            foreach($admin_record_whole as $admin_record_whole_item){
                print "<tr>";
                print "<td>".$admin_record_whole_item[0]."</td>";
                print "<td>".$admin_record_whole_item[1]."</td>";
                print "<td>".$admin_record_whole_item[2]."</td>";
                print "<td>".$admin_record_whole_item[3]."</td>";
                print "<td>$".$admin_record_whole_item[4]."</td>";
                print "<td>".$admin_record_whole_item[5]."</td>";
                print "</tr>";
            }
            print "</table>";
        ?>
    </div>

    <a name="viewupdate"></a>
    <h1 style="color:white; text-align:left;">View/Update the stock</h1>
    <h2 style="color:white; text-align:left;">All info. of items</h2>
    <div class="admin_items_page" id="admin_items_page">     
        <?php
            $admin_items = $_SESSION['admin_items'];
                
            foreach($admin_items as $admin_item){
                print "<form class=\"admin_item_detail\" action=\"updateItemDetail.php\" method=\"post\" enctype=\"multipart/form-data\" value=\"".$admin_item[0]."\">";
                print "<div class=\"admin_item\">";
                
                print "<div class=\"admin_item_img\">";
                print "<img src=\"".$admin_item[3]."\">";
                print "<input name=\"admin_item_img_".$admin_item[0]."\" type=\"file\" accept=\"image/*\">";
                print "</div>";

                print "<div class=\"admin_item_desc\">";
                print "Description:";
                print "<br>";
                print "<input name=\"admin_item_desc_".$admin_item[0]."\" type=\"text\" value=\"".$admin_item[1]."\">";
                print "</div>";

                print "<div class=\"admin_item_price_parent\">";
                print "Price of each:";
                print "<br>";
                print "$<input type=\"number\" class=\"admin_item_price\" name=\"admin_item_price_".$admin_item[0]."\" value=\"".$admin_item[2]."\" step=\"0.1\">";
                print "</div>";

                print "<div class=\"admin_item_number_parent\">";
                print "Stock qty:";
                print "<br>";
                print "<input class=\"admin_item_number\" type=\"number\" name=\"admin_item_number_".$admin_item[0]."\" value=\"".$admin_item[6]."\" min=\"1\">";
                print "</div>";

                print "<div class=\"admin_item_active_parent\">";
                print "Active:";
                print "<br>";
                if($admin_item[4] == 'T'){
                    print "<input type=\"checkbox\" class=\"admin_item_active\" checked value='T' name=\"admin_item_active_".$admin_item[0]."\">";
                }
                else{
                    print "<input type=\"checkbox\" class=\"admin_item_unactive\" value='T' name=\"admin_item_active_".$admin_item[0]."\">";
                }    
                print "</div>";

                print "<div class=\"admin_item_butt\">";
                print "<input type=\"submit\" class=\"admin_item_butt_save\" name=\"admin_item_butt_save_".$admin_item[0]."\" value=\"Save\">";
                //print "<button class=\"admin_item_butt_del\">Delete</button>";
                print "</div>";

                print "</div>";
                print "</form>";
            }          
        ?>
    </div>

    <div class="footer">
        <?php include 'footer.php'?>
    </div>
</body>

</html>