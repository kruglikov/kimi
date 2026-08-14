<?php

include ("db.php");

echo "1\n";
$result = mysqli_query($dbconn, "SELECT DATABASE()");
echo "2\n";

$row = mysqli_fetch_array($result, MYSQLI_NUM );
echo "fetched\n";
echo $row[0]."\n";
echo "finished\n";

?>