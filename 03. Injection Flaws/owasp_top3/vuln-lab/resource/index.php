<!doctype html>
<html lang="en">

<head>
    <title>Injection Flaws</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> 
</head>

<body>
    <div class="container" id="glass">
        <div class="align-items-center justify-content-center row" style="min-height: 100vh;">
            <div class="col-sm-6 text-center">
                <form action="" method="get">
                    <?php
                    if (isset($_GET["search"])) {
                        $search = $_GET["search"];
                        
                        $command = "cut -d':' -f1 /etc/passwd | grep $search";
                        
                        $returned_user = exec($command);
                        if ($returned_user == "") {
                            $result = "<div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong> User <b>$search</b> was not found on the <b>system</b>
                            </div>";
                        } else {
                            $result = "<div class='alert alert-success' role='alert'>
                            <strong>Success!</strong> User <b>$search</b> was found on the <b>system</b>
                            </div>";
                        }
                        echo $result;
                    }
                    ?>
                    <div class="search-bar">
                        <h2>Search For User</h2><br>
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="text" id="search" name="search" placeholder="Search user...">
                            </div>
                            <input type="submit" value="Search">
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="bootstrap.min.js"></script>
</body>

</html>
