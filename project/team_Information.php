<?php
session_start();
include "db.php";

if(isset($_SESSION["boolean"])){
    $id = $_GET["id"];
    $name = $_GET["name"];
    $skill = $_GET["skill"];
    $gameDay = $_GET["day"];
    $emailFK = $_GET["email"];

    if (isset($_POST["logout"])) {
        $_SESSION = array();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $id = $_GET["id"];
        $sql = "DELETE FROM team WHERE team_id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        header("Location: dashboard.php");
        exit();
    }

    echo '
    <html>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header>
            <div id="user-profile" style="display: flex; align-items: center;">
                <img src="photos/world_cup.jpg" alt="logo" >
                <Strong style="margin-left: 10px;">Birzeit Sports</Strong>
            </div>
            <form method="POST" style="display: inline;">
                <button type="submit" name="logout">Logout</button>
            </form>
            <a href="aboutus.html">About Us</a>
            <div id="user-profile" style="display: flex; align-items: center;">
                <img src="photos\MyPhoto.jpeg" alt="MyPhoto" id="MyPhoto" style="margin-right: 10px;">
                <b style="margin-left: 10px;"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?></b>
            </div>
        </header>
        <div id="main">
            <p>Team Details</p>
            <a href="dashboard.php">Back to the dashboard </a><br><br>
            <table>
                <thead>
                    <th>Team Name</th>
                    <th>Skill Level</th>
                    <th>Game Day:</th>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$name.'</td>
                        <td>'.$skill.'</td>
                        <td>'.$gameDay.'</td>
                    </tr>
                </tbody>
            </table>';

    $sql = "SELECT p.player_name, t.email FROM player AS p JOIN team AS t on p.team_id = t.team_id WHERE p.team_id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":id", $id);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>Players</p>";
    if (!empty($result)) {
        echo "<ul>";
        foreach ($result as $row) {
            echo "<li>{$row["player_name"]}</li>";
        }
        echo "</ul>";
    }

    if($emailFK == $_SESSION["email"]){
        echo '
            <br><br>
            <form method="post" action="">
                <table cellspacing="0">
                    <tr>
                        <td>Player Name:</td>
                        <td>
                            <input type="text" name="name" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Add" id="add"></td>
                    </tr>
                </table>
            </form>

            <div id="user-profile" style="display: flex; justify-content: space-between; align-items: center;">
                <a href="update_Information.php?id='.$id.'&name='.$name.'&skill='.$skill.'&gameDay='.$gameDay.'">Edit</a><br>
                <form method="post" action="" class="delete-form">
                    <input type="hidden" name="delete" value="true">
                    <button type="submit" onclick="return confirm(&quot;Are you sure you want to delete the team?&quot;)" class="button">Delete</button>
                </form>
            </div>
            
        </div>
        <footer>
            <img src="photos\world_cup.jpg" alt="logo">
            <p>&copy; 2023 Birzeit Sports</p>
            <p>Contact us: 	REGS.ADMS@birzeit.edu</p>
            <p>Phone number: +972 2-298-2057</p>
            <p><a href="aboutus.html">About Us</a></p>
        </footer>
        </body>
        </html>';

        if(isset($_POST["name"])){
            $sqlN = "SELECT num_of_players FROM team WHERE team_id = :teamid";
            $statementN = $pdo->prepare($sqlN);
            $statementN->bindValue(":teamid", $id);
            $statementN->execute();
            $number = $statementN->fetch(PDO::FETCH_ASSOC);
            if($number["num_of_players"] < 9){
                $sqlp = "INSERT INTO player (player_name,team_id) VALUES (:name, :team_id)";
                $statement = $pdo->prepare($sqlp);
                $statement->bindValue(":name", $_POST["name"]);
                $statement->bindValue(":team_id", $id);
                $statement->execute();

                $sqlT = "UPDATE team SET num_of_players = num_of_players + 1 WHERE team_id = :id ";
                $statementT = $pdo->prepare($sqlT);
                $statementT->bindValue(":id", $id);
                $statementT->execute();
            }else{
                echo "The team is full, you cannot add more!<br>";
            }
        }
    }else{
        echo '
        <footer>
            <img src="photos\world_cup.jpg" alt="logo">
            <p>&copy; 2023 Birzeit Sports</p>
            <p>Contact us: 	REGS.ADMS@birzeit.edu</p>
            <p>Phone number: +972 2-298-2057</p>
            <p><a href="aboutus.html">About Us</a></p>
        </footer>
    </body>
    </html>';
    }
}else{
    echo "You must login first";
}
?>
