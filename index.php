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

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="global.css">
<link rel="stylesheet" href="index.css">
</head>

<body>  
    <table>
        <tr>
            <td colspan="2">
                <div class="header">
                    <?php include 'header.php'?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="promote">
                    <img src="res/image/ui/promote.jpg">
                    <div class="promote-word">
                        <h1>What's <a id="next" href="#browsing">NEXT</a>?</h1>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <a name="browsing"></a>
            <td rowspan="2">
                <div class="search_index">
                </div>
            </td>
            <td>
                <div class="result_page">
                    
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div class="footer">
                    <?php include 'footer.php'?>
                </div>
            </td>
        </tr>
    </table>
<body>

</html>