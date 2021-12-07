<?php
    session_start();

    if(isset($_SESSION['saled'])){
        if($_SESSION['saled'] == 'T'){
            echo '<script>alert("Transaction succeed!")</script>';
        }

        $_SESSION['saled'] = 'F';
    }
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="global.css">
<link rel="stylesheet" href="cart.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>  
    <div class="header">
        <?php include 'header.php'?>
    </div>

    <div class="cart_page" id="cart_page">

        <form id="sale-form" action="sale.php" method="post">
            <h1>The shopping cart</h1>
            <?php
                if(!isset($_SESSION['cart'])){
                    $cart = array();          
                }else{
                    $cart = $_SESSION['cart'];
                }

                foreach($cart as $cart_item){
                    print "<div class=\"cart_item\">";
                    
                    print "<div class=\"cart_item_img\">";
                    print "<img src=\"".$cart_item[3]."\">";
                    print "</div>";

                    print "<div class=\"cart_item_desc\">";
                    print "Description:";
                    print "<br>";
                    print $cart_item[1];
                    print "</div>";

                    print "<div class=\"cart_item_price_parent\">";
                    print "Price of each:";
                    print "<br>";
                    print "<span class=\"cart_item_price\">$".$cart_item[2]."</span>";
                    print "</div>";

                    print "<div class=\"cart_item_number_parent\">";
                    print "Qty:";
                    print "<br>";
                    print "<input class=\"cart_item_number\" type=\"number\" value=\"".$cart_item[5]."\" min=\"1\" disabled>";
                    print "</div>";             

                    print "</div>";
                }
            ?>

            <div class="cart_payment_info">
                <?php    
                    $total_qty = 0;
                    $amount = 0.0;
                    foreach($cart as $cart_item){
                        $total_qty += $cart_item[5];
                        $amount += $cart_item[2] * $cart_item[5];              
                    }

                    print "<h3>Total Qty: ".$total_qty."</h3>";
                    print "<h3>Amount: $".$amount."</h3>";
                ?>
            </div>

            <div class="cart_page_bottom">
                <button id="cart_reset" name="cart_reset">Clear the cart</button>
                <input id="cart_bill" name="cart_bill" type="submit" value="Bill"/>
            </div>

        </form>
    </div>
    
    <div class="footer">
        <?php include 'footer.php'?>
    </div>
<body>

</html>