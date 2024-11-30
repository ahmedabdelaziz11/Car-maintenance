<?php ob_start(); 
http_response_code(404);

echo "<h1>404 - Page Not Found</h1>";
echo "<p>Sorry, the page you're looking for could not be found.</p>";
exit();
?>
<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>