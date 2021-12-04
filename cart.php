<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="global.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>  
    <div class="header">
        <?php include 'header.php'?>
    </div>

    <div class="cart_page" id="cart_page">

        <form action="" method="post">
        <?php
            if(!isset($_SESSION['cart'])){
                $cart = array();          
            }else{
                $cart = $_SESSION['cart'];
            }

            foreach($cart as $cart_item){
                print "<div class=\"cart_item\">";

                print "<img class=\"cart_item_img\" src=\"".$cart_item[3]."\">";
                print "<div class=\"cart_item_desc\">";
                print "Item description: ".$cart_item[1];
                print "</div>";

                print "<div class=\"cart_item_number_parent\">";
                print "<input class=\"cart_item_number\" type=\"number\" value=\"".$cart_item[4]."\" min=\"1\">";
                print "</div>";

                print "<div class=\"cart_item_butts\">";
                print "<button class=\"cart_butt_buy\">Buy now</button>";
                print "<button class=\"cart_butt_del\" onClick='location.href=\"?addToCart=".$cart_item[0]."\"'>Delete</button>";
                print "</div>";

                print "</div>";
            }
        ?>

        <div class="cart_payment_info">
            <h3>Qty: </h3> <span id="cart_qty">0</span>
            <h3>Amount: </h3> <span id="cart_amount">$0.0</span>
        </div>

        <div class="cart_page_bottom">
            <input id="cart_reset" type="reset" value="Reset"/>
            <input id="cart_bill" type="submit" value="Bill"/>
        </div>

        </form>
    </div>
    
    <div class="footer">
        <?php include 'footer.php'?>
    </div>
<body>

</html>