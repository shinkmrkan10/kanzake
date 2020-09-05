<?php
include ('db_login.php');
require_once ('DB.php');
    $connection = DB::connect("mysql://$db_username:$db_password@$db_host/$db_database");
if  ( !$connection )
{
    die ("Could not connect to the database :  <br>" . DB::errorMessage( ));
}
$query = 'update counter SET a_date = "2020-09-03" 
                            where accessed LIKE "2020-09-03%"';
$result = $connection->query($query);
if (DB::isError($result))
{
    die ("Could not query the database : <br>".$query. " ".DB::errorMessage($result));
}
echo ("Table created successfully!");
$connection->disconnect( );
?>