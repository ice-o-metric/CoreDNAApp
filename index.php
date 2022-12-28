<html>
<body>
<?php require_once('RequestMaker.php'); ?>
<h1>Loading...</h1>
<?php require_once('AssessmentEndpoint.php'); 
$endpoint = new AssessmentEndpoint();
$endpoint->SendAndOutput('Daniel Vida', 'receive.attachments@gmail.com', 'https://github.com/ice-o-metric/CoreDNAApp');
?>
</body>
</html>