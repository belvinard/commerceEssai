<?php
// Output session configuration settings
echo "Session Configuration Settings:<br>";
echo "session.gc_maxlifetime: " . ini_get('session.gc_maxlifetime') . "<br>";
echo "session.cookie_lifetime: " . ini_get('session.cookie_lifetime') . "<br>";
?>
