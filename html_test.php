<?php
include('html_header.php');
$html_title='Display of access log';
$style_sheet='second';
html_header($html_title,$style_sheet);
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

echo <<<EOD
<body>
<hr />

<strong>Top 10 access</strong>
<br />
<table border="1" align="left">
    <tr class="b-yellow">
        <th>Count</th>
        <th>date</th>
    </tr>
EOD;
//    クエリを作成する。日付ごとのアクセス総数
$query = "SELECT  a_date,count(a_date) as d_count  FROM  counter group by a_date order by d_count desc " ;
//    クエリの実行
$result = mysql_query ( $query ) ;
if (!$result){
    die ("Could not query the database: <br />". mysql_error(  ));
}


//    結果から行を取得して表示する
for ($i=0;$i<10;$i++)
{
    $row  =  mysql_fetch_array( $result, MYSQL_ASSOC ) ;
    $a_date = $row["a_date"] ;
    $a_count = $row["d_count"] ;
    echo "<tr>" ;
    echo '<td style="text-align:end">'."$a_count</td>" ;
    echo "<td>$a_date</td>" ;
    echo "</tr>" ;
}
 
echo <<<EOD
</table>

<table class="b-gray" align="left"><tr><td>access graph</td></tr></table>

<table>

EOD;
//    クエリを作成する。日付ごとのアクセス総数
$query = "SELECT  a_date,count(a_date) as d_count  FROM  counter group by a_date order by a_date desc " ;
//    クエリの実行
$result = mysql_query ( $query ) ;
if (!$result){
    die ("Could not query the database: <br />". mysql_error(  ));
}

//    結果から行を取得して表示する
for ($i=0;$i<15;$i++)
{
    $row  =  mysql_fetch_array( $result, MYSQL_ASSOC ) ;
    $a_date = $row["a_date"] ;
    $a_count = $row["d_count"] ;
    echo "<tr>" ;
    echo "<td>$a_date</td>" ;
    printf("<td><pre><strong>(%3d)</strong></pre></td>",$a_count) ;
    echo '<td class="red">' ;
    for ($j=0;$j<$a_count;$j++)
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
echo <<<EOD
</table>

<hr />
<table border="1">
    <tr class="b-yellow">
        <th>Counter</th>
        <th>Timestamp</th>
        <th>Access host</th>
        <th>Referer</th>
    </tr>
EOD;
//    クエリを作成する。アクセスログ全体
$query = "SELECT  *  FROM  counter order by counter_id desc " ;
//    クエリの実行
$result = mysql_query ( $query ) ;
if (!$result){
    die ("Could not query the database: <br />". mysql_error(  ));
}

//    結果から行を取得して表示する
for ($i=0;$i<100;$i++)
{
    $row  =  mysql_fetch_array( $result, MYSQL_ASSOC ) ;
    $counter_id = $row["counter_id"] ;
    $accessed = $row["accessed"] ;
    $a_host = $row["a_host"] ;
    $a_ref = $row["a_ref"] ;
    echo "<tr>" ;
    echo '<td style="text-align:end">'."$counter_id</td>" ;
    echo "<td>$accessed</td>" ;
    echo "<td>$a_host</td>" ;
    echo "<td>$a_ref</td>" ;
    echo "</tr>" ;
}
//    クエリを作成する。アクセスログの古い部分を削除する
//$query = "DELETE  FROM  counter where counter_id < $counter_id " ;
//    クエリの実行
//$result = mysql_query ( $query ) ;
//if (!$result){
//    die ("Could not query the database: <br />". mysql_error(  ));
//}

//    接続を閉じる
mysql_close ( $connection ) ;
echo <<<EOD
</table>
</body>
</html>
EOD;
?>