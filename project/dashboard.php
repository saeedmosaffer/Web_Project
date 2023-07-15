<?php
session_start();
include "db.php";

if ($_SESSION["boolean"] == true) {
    $userEmail = $_SESSION["email"];
    $userUsername = $_SESSION["username"];

    if (!empty($userEmail) && !empty($userUsername)) {
        $sqlA = "SELECT photo FROM login_register WHERE email = :email";
        $sa = $pdo->prepare($sqlA);
        $sa->bindValue(":email", $userEmail);
        $sa->execute();
        $resa = $sa->fetch(PDO::FETCH_ASSOC);
        $photo = $resa["photo"];
        $_SESSION["photo"] = $resa["photo"];

        if (isset($_POST["logout"])) {
            $_SESSION = array();
            session_destroy();
            header("Location: login.php");
            exit();
        }

        include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>dashboard</title>
</head>
<body>
    <div id="wrapper">
        <div id="container">
            <div id="main">
                <main>
                    <h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>

                    <?php
                    $sql = "SELECT * FROM team";
                    $sqlStatement = $pdo->prepare($sql);
                    $sqlStatement->execute();
                    $sqlSResult = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);

                    if ($sqlStatement->rowCount() > 0) {
                        echo "<table border='1'>
                            <thead>
                                <th>Team Name</th>
                                <th>Skill Level(1-5)</th>
                                <th>Players</th>
                                <th>Game Day</th>
                            </thead>";
                        foreach ($sqlSResult as $row) {
                            $eamilFK = $row["email"];
                            $teamname = $row["team_name"];
                            $teamskill = $row["skill_level"];
                            $day = $row["game_day"];
                            $teamId = $row["team_id"];
                            echo "<tr>
                                <td>
                                    <a href='team_Information.php?id={$teamId}&name={$teamname}&skill={$teamskill}&day={$day}&email={$eamilFK}'>
                                        {$row["team_name"]}
                                    </a>
                                </td>
                                <td>{$row["skill_level"]}</td>
                                <td>{$row["num_of_players"]}/9</td>
                                <td>{$row["game_day"]}</td>
                            </tr>";
                        }

                        echo "</table>";
                        echo "<br>" . "<form>
                            <button type='submit' formaction='newTeam.php'>Create new team</button><br><br>
                        </form>";
                    } else {
                        echo "There are no teams! Let's create a new team";
                        echo "<br>" . "<form>
                            <button type='submit' formaction='newTeam.php'>Create new team</button><br><br>
                        </form>";
                    }
                    ?>
                </main>
            </div>
        </div> 
    </div>

    <?php
    include "footer.php";
    ?>

</body>
</html>

<?php
    } else {
        echo "You must log in first";
    }
}
?>
