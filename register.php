<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="register.css">
    </head>

    <body>
        <div id="register-popup">
            <form class="register-form" action="" id="register-form" method="post">
                <h1>Register</h1>
                <div class="rowData">
                    <div>
                        <label>Nick Name: </label><span id="nickName-info" class="info"></span>
                    </div>
                    <div>
                        <input type="text" id="nickName" name="nickName" class="inputBox" />
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Email: </label><span id="userEmail-info" class="info"></span>
                    </div>
                    <div>
                        <input type="text" id="userEmail" name="userEmail" class="inputBox" />
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Birthday: </label><span id="birthday-info" class="info"></span>
                    </div>
                    <div>
                        <input type="date" id="birthday" name="birthday" class="inputBox"></textarea>
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Gender: </label><span id="gender-info" class="info"></span>
                    </div>
                    <div>
                        <select id="gender" name="gender" class="inputSelect">
                            <option class="inputOption" value=""></option>
                            <option class="inputOption" value="M">Male</option>
                            <option class="inputOption" value="F">Female</option>
                            <option class="inputOption" value="O">Others</option>
                        </select>
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Profile image: </label><span id="userIcon-info" class="info"></span>
                    </div>
                    <div>
                        <input type="file" id="userIcon" name="userIcon" accept="image/*" class="inputBox">
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Password: </label><span id="password-info" class="info"></span>
                    </div>
                    <div>
                        <input type="password" id="password" name="password" class="inputBox">
                    </div>
                </div>
                <div class="rowData">
                    <div>
                        <label>Confirm Password: </label><span id="confirmPassword-info" class="info"></span>
                    </div>
                    <div>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="inputBox">
                    </div>
                </div>
                <div>
                    <table>
                        <tr>
                            <td width=33%><input type="submit" id="send" name="send" value="Register" /></td>
                            <td width=33%><input type="reset" id="reset" name="reset" value="Reset" /></td>
                            <td width=33%><button id="back" name="back">Back</button></td>
                        </tr>
                    </table>               
                </div>
            </form>
        </div>
    </body>
</html>
