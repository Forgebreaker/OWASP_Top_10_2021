<?php 
session_start();
if(isset($_GET["debug"])) die(highlight_file(__FILE__));  // Remember to delete this
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gun Catalogue</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login-form">
        <div class="login-form">
            <h1>Gun Catalogue</h1>
            <?php
            class Gun {
                public $name;
                public $type;

                public function __construct($name, $type) {
                    $this->name = $name;
                    $this->type = $type;
                }

                public function getgun() {
                    return $this->name;
                }

                public function gettype() {
                    return $this->type;
                }
            }

            class Resource {
                public $link;

                public function __construct($link) {
                    $this->link = $link;
                }

                public function getgun() {
                    return system("curl " . $this->link); 
                }
            }

            if (!isset($_SESSION["Guns"])) {
                $_SESSION["Guns"] = array();
            }

            if (isset($_POST["name"]) && isset($_POST["type"])) {
                $gun = new Gun($_POST["name"], $_POST["type"]);
                $_SESSION["Guns"][] = serialize($gun);
                $data = serialize($gun) . "|";

                file_put_contents("./user_data/" . session_id(), $data, FILE_APPEND);
            }
            ?>
            <form method="post" class="gun-form">
                <div class="input-group">
                    <input type="text" name="name" id="name" class="input-group" placeholder="Enter The Gun's Name">
                    <input type="text" name="type" id="type" class="input-group" placeholder="Enter The Gun's Type">
                </div>
                <input type="submit" value="Add Gun" class="submit-button">
            </form>
            <br>
            <button onclick="window.location.href='?action=show'" class="show-link" id="toggleButton">Show Guns</button>
        </div>

        <?php 
        if (isset($_GET["action"]) && $_GET["action"] == "show") {
            echo "<div class='gun-list'>";
            $big_data = file_get_contents("./user_data/" . session_id());
            $gun_data = explode("|", $big_data);
            foreach ($gun_data as $minigun) {
                if ($minigun) {
                    $Gun = unserialize($minigun);
                    if ($Gun) {
                        echo "<p>Name: " . htmlspecialchars($Gun->getgun()) . ", Type: " . htmlspecialchars($Gun->gettype()) . "</p>";
                    }
                }
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
