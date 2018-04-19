<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2017-12-23
 * Time: 3:08 PM
 */

?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Registration</title>
        <link href = "CSS/styles.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
    <div class="center container">
        <h1>Register New User</h1>
    </div>

    <div id="reg_content">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <p>First Name :
            <input type="text" name="first_name" />
        </p>
        <p>Last Name :
            <input type="text" name="last_name" />
        </p>
        <p>Username :
            <input type="text" name="username" />
        </p>
        <p>Password :
            <input type="password" name="password_1" />
        </p>
        <p>Re-type Password :
            <input type="password" name="password_2" />
        </p>
        <input type="submit" name="submit" value="Register">
    </form>
    </div>
    </body>

</html>
