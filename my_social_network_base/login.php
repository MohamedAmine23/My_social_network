<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Log In</div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="signup.php">Sign Up</a>
        </div>
        <div class="main">
            <form action="login.php" method="post">
                <table>
                    <tr>
                        <td>Pseudo:</td>
                        <td><input id="pseudo" name="pseudo" type="text" value=""></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input id="password" name="password" type="password" value=""></td>
                    </tr>
                </table>
                <input type="submit" value="Log In">
            </form>
        </div>
    </body>
</html>
