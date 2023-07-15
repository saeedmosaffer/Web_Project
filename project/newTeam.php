<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM team WHERE team_name = :team_name";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":team_name", $_REQUEST["teamName"]);
    $statement->execute();
    if ($statement->rowCount() <= 0) {
        if (($_REQUEST["skillLevel"] >= 1) && ($_REQUEST["skillLevel"] <= 5)) {
            $sqli = "INSERT INTO team (team_name, skill_level, game_day, email) VALUES (:team_name, :skill_level, :game_day, :user_email)";
            $statementi = $pdo->prepare($sqli);
            $statementi->bindValue(":team_name", $_REQUEST["teamName"]);
            $statementi->bindValue(":skill_level", $_REQUEST["skillLevel"]);
            $statementi->bindValue(":game_day", $_REQUEST["gameDay"]);
            $statementi->bindValue(":user_email", $_SESSION["email"]);
            $statementi->execute();
        }
    } else {
        echo "Team Already Exists";
    }
}

if (isset($_POST["logout"])) {
    $_SESSION = array();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>New Team</title>
</head>

<body>
    <div id="wrapper">
        <header>
        <div id="user-profile" style="display: flex; align-items: center;">
        <img src="photos/world_cup.jpg" alt="logo" >
        <Strong style="margin-left: 10px;">Birzeit Sports</Strong>
        </div>
            <a href="aboutus.html">About Us</a>
            <!--
            <img src="<?php echo isset($_SESSION["photo"]) ? $_SESSION["photo"] : ''; ?>" alt="Profile photo" id="profilephoto">
            <b><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></b>
            -->
            <div id="user-profile" style="display: flex; align-items: center;">
        <img src="photos\MyPhoto.jpeg" alt="MyPhoto" id="MyPhoto" style="margin-right: 10px;">
        <b style="margin-left: 10px;"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></b>
    </div>
        </header>
        <div id="container">
            <div id="main">
                <form method="post" action="">
                    <h2>New Team</h2>
                    <a href="dashboard.php">dashboard</a><br><br>
                    <table cellspacing="0">
                        <tbody>
                            <tr>
                                <td><strong>Team Name:</strong></td>
                                <td>
                                    <input type="text" name="teamName" required>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Skill Level(1-5):</strong></td>
                                <td>
                                <input type="number" name="skillLevel" min="1" max="5" required>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Game Day:</strong></td>
                                <td>
                                    <input type="date" name="gameDay" required>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" name="submit" id="submit">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
                <footer>
            <img src='photos\world_cup.jpg' alt='logo'>
            <p>&copy; 2023 Birzeit Sports</p>
            <p>Contact us: 	REGS.ADMS@birzeit.edu</p>
            <p>Phone number: +972 2-298-2057</p>
            <p><a href='aboutus.html'>About Us</a></p>
        </footer>
    </div>
</body>

</html>
