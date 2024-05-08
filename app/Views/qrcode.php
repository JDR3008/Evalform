<!-- Extend the template -->
<?= $this->extend('baseTemplate') ?>
<?= $this->section('content') ?>

<?php 
use chillerlan\QRCode\{QRCode, QROptions};

$data = esc($url);

// Display QR Code on Screen
echo '<img width=512 src="'.(new QRCode)->render($data).'" alt="QR Code" />';
?>