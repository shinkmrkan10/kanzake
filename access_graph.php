<html>

<head>

    <title>Access Graph</title>

</head>
<body>
<?php

require_once ('db_login.php');

require_once ('DB.php');

$connection = DB::connect("mysql://$db_username:$db_password@$db_host/$db_database");

if (DB::isError($connection)) {

    die ("Could not connect to the database :  <br>" . DB::errorMessage($connection));

}

$query = "SELECT * FROM counter order by counter_id desc";

$result = $connection->query($query);

if (DB::isError($result))

{

    die ("Could not query the database : <br>".$query. " ".DB::errorMessage($result));

}
echo '<br/><strong>Access log </strong>(last 10 access) 最近のアクセスログ10件<br />';

echo '<table border>';

echo '<tr><th>counter</th><th>timestamp</th><th>access host</th><th>referer</th></tr>';


for ($i=0;$i<10;$i++)
{

    $result_row = $result->fetchRow(DB_FETCHMODE_ASSOC);

    echo "<tr>" ;
    echo "<td>" ;
    echo $result_row["counter_id"] ;
    echo "</td><td>" ;
    echo $result_row["accessed"] ;
    echo "</td><td>" ;
    echo $result_row["a_host"] ;
    echo "</td><td>" ;
    echo $result_row["a_ref"] ;
    echo "</td></tr>" ;

}

echo "</table>";

echo '<br/><strong>Access graph </strong>(last 10 days access) 最近のアクセスグラフ10日分<br />';

echo "<table><br />";
//    クエリを作成する。日付ごとのアクセス総数
$query = "SELECT  accessed,count(accessed) as d_count  FROM  counter group by a_date order by accessed desc " ;
//    クエリの実行
$result = $connection->query($query);
if (!$result){
    die ("Could not query the database: <br />". mysql_error(  ));
}

//    結果から行を取得して表示する
for ($i=0;$i<10;$i++)
{
    $result_row = $result->fetchRow(DB_FETCHMODE_ASSOC);
    echo "<tr><td>" ;
    echo $result_row["accessed"] ;
    printf("</td><td><pre><strong>(%3d)</strong></pre></td>",$result_row["d_count"]) ;
    echo "<td>" ;
    for ($j=0;$j<$result_row["d_count"];$j++)
    {
        if (($j+1)%100 == 0){
            echo "||" ;
        }
        elseif (($j+1)%10 == 0){
            echo "|" ;
        }
        if ($j == 0){
            echo "|" ;
        }
        if ($j%5 == 2){
            echo "*" ;
        }
    }
    echo "</td>" ;
    echo "</tr>" ;
}

echo "</table>" ;

$connection->disconnect( );

?>

</body>

</html>