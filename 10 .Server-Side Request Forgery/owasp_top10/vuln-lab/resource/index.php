<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Server-Side Request Forgery</title>
</head>

<body>

    <div class="center-container">
        <div class="login-form">
            <h4>Image Download Service</h4>
            <div class="input-group">
                <?php
                    $error = '';
                    $downloadLink = '';
                    
                    if (isset($_GET['url'])) {
                        if (!filter_var($_GET['url'], FILTER_VALIDATE_URL)) {
                            $error = 'Error!';
                        } else {
                            $content = file_get_contents($_GET['url']);
                            $downloadLink = 'data:image/png;base64,' . base64_encode($content);
                        }
                    }
                ?>
                <form>
                    <input type="text" name="url" placeholder="Enter image URL here">
                    <br><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
            <?php if ($downloadLink) {
                echo '<a href="' . $downloadLink . '" download="Image.png" ><button id="toggleButton">Download Image</button></a>';
            } ?>
            <p class="text-danger"><?php echo $error; ?></p>
        </div>
    </div>

</body>

</html>
