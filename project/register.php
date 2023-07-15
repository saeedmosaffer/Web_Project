<?php
session_start();
include "db.php";


$error="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_REQUEST["email"];
    $sql = "select email from login_register where email = :email";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":email", $email);
    $statement->execute();
    if($statement->rowCount() == 0){
        if((strlen($_REQUEST["password"]) >= 8)){
            if($_REQUEST["password"] === $_REQUEST["confirm"]){
                if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE){
                    $username = $_REQUEST["username"];
                    $password = $_REQUEST["password"];

                    $sqlInsert = "INSERT INTO login_register(username, email, password) values(:username, :email, :password)";
                    $statementInsert= $pdo->prepare($sqlInsert);
                    $statementInsert->bindValue(":username", $username);
                    $statementInsert->bindValue(":email", $email);
                    $statementInsert->bindValue(":password", $password);
                    if($statementInsert->execute()){
                        echo "Your Data Inserted Successfully";
                        header("Location: login.php");
                        exit();
                    }else{
                        $error = "An error occuered when inserted your data";
                    }
                }else{
                    $username = $_REQUEST["username"];
                    $password = $_REQUEST["password"];

                    $sqlInsert = "INSERT INTO login_register (username, email, password, photo) values(:username, :email, :password, :photo)";
                    $statementInsert= $pdo->prepare($sqlInsert);
                    $statementInsert->bindValue(":username", $username);
                    $statementInsert->bindValue(":email", $email);
                    $statementInsert->bindValue(":password", $password);
                    $statementInsert->bindValue(":photo", $_FILES['photo']['name']);
                    if($statementInsert->execute()){
                        echo "Your Data Inserted Successfully";
                        header("Location: login.php");
                        exit();
                    }else{
                        $error = "An error occuered when inserted your data";
                    }
                }
            }else{
                $error = "Password not match";
            }
        }else{
            $error = "Password length is less than 8 char";
        }
    }else{
        $error = "Account Already Exists";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register_login.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <form method="post" action="" enctype="multipart/form-data">
            <p><strong>Registration Form</strong></p>
            <table>
                <tbody>
                    <tr>
                        <td colspan="2">username:<span class="req">*</span></td>
                        <td>
                            <input type="text" name="username" class="required" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Email:<span class="req">*</span></td>
                        <td colspan="2">
                            <input type="email" name="email" class="required" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                            <?php if ($error == "Account Already Exists") { ?>
                                <span class="error"><?php echo $error;?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Password:<span class="req">*</span></td>
                        <td colspan="2">
                            <input type="password" name="password" class="required" required>
                            <?php if ($error == "Password length is less than 8 char") { ?>
                                <span class="error"><?php echo $error;?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm Password:<span class="req">*</span></td>
                        <td colspan="2">
                            <input type="password" name="confirm" class="required" required>
                            <?php if ($error == "Password not match") { ?>
                                <span class="error"><?php echo $error;?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr colspan="2">
                        <td>Profile Picture:</td>
                        <td colspan="2"><input type="file" name="photo" id="photo" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input type="submit" name="register" id="reg" value="Register">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>