<?= $this->extend('baseTemplate') ?>
<?= $this->section('content') ?>

<?php 
use chillerlan\QRCode\{QRCode, QROptions};

$data = $url;

// quick and simple:
echo '<img width=1024 src="'.(new QRCode)->render($data).'" alt="QR Code" />';
?>