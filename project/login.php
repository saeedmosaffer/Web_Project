<?php
session_start();
include "db.php";

$error="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $sql = "SELECT * FROM login_register AS l WHERE l.email = :email";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":email", $_REQUEST["email"]);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if($statement->rowCount() !=0 ){
        $userName = $result["username"];
        $userPassword = $result["password"];
        if($_REQUEST["password"] === $userPassword){
            $_SESSION["email"] = $result["email"];
            $_SESSION["username"] = $userName;
            $_SESSION["boolean"] = true;
            $loginSuccessful = true;
            header("Location: dashboard.php?loginSuccessful=" . $loginSuccessful);
            exit();
        }else{
            $error = "Invalid password";
        }
    }else{
        $error = "No such account found!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register_login.css"/>
    <title>Log In</title>
</head>
<body>
    <div class="container">
        <form method="post" action="">
            <table  cellspacing="0">
                <p>Log In</p>
                <tbody>
                    <tr>
                        <td colspan="2">Email:</td>
                        <td colspan="2">
                            <input type="email" name="email" required>
                            <?php if($error == "No such account found!"){ ?>
                                <span class="error"><?php echo $error;?></span>
                                <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Password:</td>
                        <td colspan="2">
                            <input type="password" name="password" required>
                            <?php if($error == "Invalid password"){ ?>
                                <span class="error"><?php echo $error;?></span>
                                <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input type="submit" value="Login" id="login">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>