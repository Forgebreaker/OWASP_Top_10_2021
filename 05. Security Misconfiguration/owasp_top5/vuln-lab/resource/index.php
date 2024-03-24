<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xmlString = file_get_contents('php://input');
    $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOENT);
    if ($xml !== false && isset($xml->clientname)) {
        $name = $xml->clientname;
        echo "Hmm! Just a small entity from the outside world, if you can show me the content of /flag.txt, I may consider not killing you yet. Show me what you've got, " . $name;
    } else {
        http_response_code(400);
        echo "Invalid XML data received.";
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Security Misconfiguration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function sendUserInfo() {
            var xhr = new XMLHttpRequest();
            var url = "index.php"; 
            var userName = document.getElementById('userName').value;
            var xmlString = `<userInfo><clientname>${userName}</clientname></userInfo>`;

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "text/xml");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = xhr.responseText;
                    startTypingAnimation(data);
                } else {
                    alert('Error with status code: ' + xhr.status);
                }
            };
            xhr.send(xmlString);
        }

        function startTypingAnimation(text) {
            const typingSpeed = 20; 
            let index = 0;
            var displayElement = document.getElementById("display");
            displayElement.textContent = '';

            function type() {
                if (index < text.length) {
                    displayElement.textContent += text.charAt(index);
                    index++;
                    setTimeout(type, typingSpeed);
                }
            }

            type();
        }
    </script>
</head>
<body>
    <div class="center-container">
        <div class="login-form">
            <div class="input-group">
                <label for="userName"><h3>Outlander ! Who are you ?</h3></label>
                <input type="text" id="userName" placeholder="Enter your name">
            </div>
            <input type="submit" value="Submit" onclick="sendUserInfo()">
            <div id="display" class="error-message"></div>
        </div>
    </div>

    <div id="typingContainer"></div>
</body>
</html>
