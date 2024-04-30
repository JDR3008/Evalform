<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvalForm</title>
</head>

<body style="justify-content:center" class="page-container">

<?php 
use chillerlan\QRCode\{QRCode, QROptions};

$data = $url;

// quick and simple:
echo '<img width=1024 src="'.(new QRCode)->render($data).'" alt="QR Code" />';
?>

</body>
</html>