<?php
    session_start();

    if($_SESSION['loginFlag'] == 'T'){
        switch ($_SESSION['loginState']){
            case 'A':
            case 'C':
                echo '<script>alert("Login succes!")</script>';
                break;

            case 'U':
                echo '<script>alert("Login fail!")</script>';
                break;
            
            default:
                break;
        }

        $_SESSION['loginFlag'] = 'F';
    }
?>

<?php
    session_start();

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
        $stmt = $connect->prepare("SELECT * FROM item WHERE active = 'T'");
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$result){
            die("Could not successfully run query." .mysqli_error($connect));
        }
        else{
            $items = array();
            while($row = mysqli_fetch_assoc($result)){
                $item = array();
                array_push($item, $row['itemID']);
                array_push($item, $row['description']);
                array_push($item, $row['price']);
                array_push($item, $row['img_path']);
                array_push($item, $row['typeID']);

                array_push($items, $item);
            }

            $_SESSION['items'] = $items;
        }                   
    }

    //close the connection
    mysqli_close($connect);
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="global.css">
<link rel="stylesheet" href="index.css">

</head>

<body>  
    <table>
        <tr>
            <td>
                <div class="header">
                    <?php include 'header.php'?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="promote">
                    <img src="res/image/ui/promote.jpg">
                    <div class="promote-word">
                        <h1>What's <a id="next" href="#browsing">NEXT</a>?</h1>
                    </div>
                </div>
            </td>
        </tr>
        <tr>        
            <td>
                <a name="browsing"></a>
                <div class="item_page" id="item_page">
                    <?php
                        $items = $_SESSION['items'];

                        foreach($items as $item){
                            print "<div class=\"item\">";

                            print "<div class=\"item_upper\">";
                            print "<img class=\"item_img\" src=\"".$item[3]."\">";
                            print "<div class=\"item_butts\">";
                            print "<button class=\"butt_buy\" value=\"".$item[0]."\">Buy now</button>";
                            print "<button class=\"butt_addToCart\" value=\"".$item[0]."\">Add to cart</button>";
                            print "</div>";
                            print "</div>";

                            print "<div class=\"item_lower\">";
                            print "<p>";
                            print $item[1];
                            print "<br>";
                            print "<b>$".$item[2]."</b>";
                            print "</p>";
                            print "</div>";

                            print "</div>";
                        }
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="footer">
                    <?php include 'footer.php'?>
                </div>
            </td>
        </tr>
    </table>
<body>

</html>