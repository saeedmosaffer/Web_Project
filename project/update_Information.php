<?php
session_start();
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sqlCheck = "SELECT team_name FROM team";
    $checkStatement = $pdo->prepare($sqlCheck);
    $checkStatement->execute();
    $result = $checkStatement->fetchAll(PDO::FETCH_ASSOC);
        if(($_REQUEST["skillLevel"]>=1) && ($_REQUEST["skillLevel"]<=5)){
            $sqli = "UPDATE team SET team_name=:team_name, skill_level=:skill_level, game_day=:game_day WHERE team_id = :id";
            $statementi = $pdo->prepare($sqli);
            $statementi->bindValue(":team_name", $_REQUEST["teamName"]);
            $statementi->bindValue(":skill_level", $_REQUEST["skillLevel"]);
            $statementi->bindValue(":game_day", $_REQUEST["gameDay"]);
            $statementi->bindValue("id",$_GET["id"]);
            $statementi->execute();
            $_GET["name"] = $_REQUEST["teamName"];
            $_GET["skill"] = $_REQUEST["skillLevel"];
            $_GET["gameDay"] = $_REQUEST["gameDay"];
            echo "Updated Successfuly";
        }else{
            echo "Skill Level must within range [1-5]";
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Update</title>
</head>
<body>
    <header>
        <div id="user-profile" style="display: flex; align-items: center;">
        <img src="photos/world_cup.jpg" alt="logo" >
        <Strong style="margin-left: 10px;">Birzeit Sports</Strong>
        </div>
        <a href="aboutus.html">About Us</a>
       <!-- <img src="<?php isset($_GET["photo"])?$_GET["photo"]: ""?>" alt="profile photo" id="profilephoto"> -->
        <div id="user-profile" style="display: flex; align-items: center;">
        <img src="photos\MyPhoto.jpeg" alt="MyPhoto" id="MyPhoto" style="margin-right: 10px;">
        <b style="margin-left: 10px;"><?php echo $_SESSION['username']; ?></b>
    </div>
    </header>
    <div id="container">
        <div id="main">
            <form method="post" action="">
            <h2>Edit Team</h2>
            <a href="dashboard.php">Back to the dashboard</a><br><br>
                <table cellspacing="0">
                    <tbody>
                        <tr>
                            <td><Strong>Team Name:</Strong></td>
                            <td>
                                <input type="text" name="teamName" value="<?php echo isset($_GET["name"])?$_GET["name"]:"";?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Skill Level(1-5):</strong></td>
                            <td>
                                <input type="number" name="skillLevel" min="1" max="5" value="<?php echo isset($_GET["skill"])?$_GET["skill"]:"";?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Game Day:</strong></td>
                            <td>
                                <input type="text" name="gameDay" value="<?php echo isset($_GET["gameDay"])?$_GET["gameDay"]:"" ;?>" required>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Update" id="submit">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
            <footer>
            <img src="photos\world_cup.jpg" alt="logo">
            <p>&copy; 2023 Birzeit Sports</p>
            <p>Contact us: 	REGS.ADMS@birzeit.edu</p>
            <p>Phone number: +972 2-298-2057</p>
            <p><a href="aboutus.html">About Us</a></p>
        </footer>
</body>
</html>