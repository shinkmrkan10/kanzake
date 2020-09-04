<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/TR/html401/loose.dtd" xml:lang="ja" lang="ja">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Displaying in a HTML table</title>
</head>
<body>
<table border="1">
    <tr>
        <th>Counter</th>
        <th>Timestamp</th>
        <th>Access host</th>
        <th>Referer</th>
    </tr>

<?php
//    ログイン情報をインクルードする
include('db_login.php');
//    接続する
$connection = mysql_connect($db_host, $db_username, $db_password);
if (!$connection){
    die ("Could not connect to the database: <br />". mysql_error(  ));
}
//    データベースを選択する
$db_select = mysql_select_db ( $db_database ) ;
if (!$db_select){
    die ("Could not select the database: <br />". mysql_error(  ));
}
//    クエリを作成する
$query = "SELECT  *  FROM  counter order by counter_id desc " ;
//    クエリの実行
$result = mysql_query ( $query ) ;
if (!$result){
    die ("Could not query the database: <br />". mysql_error(  ));
}


//    結果から行を取得して表示する
for ($i=0;$i<50;$i++)
{
    $row  =  mysql_fetch_array( $result, MYSQL_ASSOC ) ;
    $counter_id = $row["counter_id"] ;
    $accessed = $row["accessed"] ;
    $a_host = $row["a_host"] ;
    $a_ref = $row["a_ref"] ;
    echo "<tr>" ;
    echo "<td>$counter_id</td>" ;
    echo "<td>$accessed</td>" ;
    echo "<td>$a_host</td>" ;
    echo "<td>$a_ref</td>" ;
    echo "</tr>" ;
}
//    クエリを作成する
$query = "DELETE  FROM  counter where counter_id < $counter_id " ;
//    クエリの実行
$result = mysql_query ( $query ) ;
if (!$result){
    die ("Could not query the database: <br />". mysql_error(  ));
}

//    接続を閉じる
mysql_close ( $connection ) ;
?>
</table>
</body>
</html>