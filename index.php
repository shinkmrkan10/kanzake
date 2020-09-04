<?php
include('html_header.php');
$html_title='燗酒普及協会(since Sep.9 1998)';
html_header($html_title);

echo <<<EOD
<body bgcolor="#5f0000" text="#00fffff" link="#00ff00" alink="#0000ff" vlink="#cfcfcf">
<center>
<hr width=80%>
<a href="kanzake.htm"><img src="jpeg/kanzake.jpg" border=0></a>
<hr width=80%>
<table cellpadding=10>
<tr><th>
<a href="kan/"><img src="gif/kan.gif" alt="燗" border=0></a>
</th><th>
<img src="gif/sake.gif" alt="酒" border=0>
</th><th>
<a href="utsuwa/"><img src="gif/utsuwa.gif" alt="器" border=0></a>
</th><th>
<a href="enkai/"><img src="gif/utage.gif" alt="宴" border=0></a>
</th><th>
<img src="gif/siru.gif" alt="知" border=0>
</th></tr>
<tr><th>
<img src="gif/mise.gif" alt="店" border=0>
</th><th colspan=3>
EOD;

error_reporting(0);

require_once ('db_login.php');
require_once ('DB.php');

$connection = DB::connect("mysql://$db_username:$db_password@$db_host/$db_database");

if (DB::isError($connection)) {
    die ("Could not connect to the database :  <br>" . DB::errorMessage($connection));
}
$time_st = time( );
$a_date = date("Y-m-d", $time_st);
$a_time = date("H:i:s", $time_st);
$a_ip = $_SERVER["REMOTE_ADDR"];
$a_agent = $_SERVER["HTTP_USER_AGENT"];
$a_host = gethostbyaddr($a_ip);
$a_ref = $_SERVER["HTTP_REFERER"];
$time_st_p = $a_date . " " . $a_time ;
$m_date = date("Y-m", $time_st);
$m_month = date("F", $time_st);

$query = "insert into counter values(NULL,'$time_st_p','$a_host','$a_ref','$a_date')";
$result = $connection->query($query);

if (DB::isError($result))

{
    die ("Could not query the database : <br>".$query. " ".DB::errorMessage($result));
}
$timestamp=time( );
$month=date("m",$timestamp);
if ($month>=3 & $month<=5)
{
    $image='hana-gaeru.gif';
}
elseif ($month>=6 & $month<=8)
{
    $image='natsu-gaeru.gif';
}
elseif ($month>=9 & $month<=11)
{
    $image='kann-gaeru.gif';
}
else 
{
    $image='yuki-gaeru.gif';
}
echo ('<img src="');
echo ("gif/$image");
echo ('" border=0><br>');
echo <<<EOD
Copyright(c)1998-2000 Chie Ikeda, Shin Kimura
</th><th>
<img src="gif/hito.gif" alt="人" border=0>
</th></tr>
</table>
<hr width=80%>
<p>
<a href="kanzake.htm">ごあいさつ</a>
　｜　<a href="https://shinkmrkan10.blogspot.jp">燗酒普及協会ブログ</a>
</p>
次の活動予定　：現在の情勢を考慮し活動自粛中です。<br>
2019年10月6日(日)<a href="http://www.taruichi.co.jp/blog/2016/07/post-1594.html">樽一会</a>にて燗付けいたしました。<br>
2019年6月30日(日)<a href="jpeg/nf2018.jpg">日本酒フェスティバル</a>、協力参加いたしました。<br>
<hr width=80%>
　お酒は２０歳になってから．お酒はおいしく適量を．<br>
Copyright(C) 1998-2004 Kanzake Fukyu Kyoukai, All Rights Reserved.
<ADDRESS>お問い合わせ：燗酒普及協会事務局 (<A HREF="mailto:info@kanzake.org">info@kanzake.org</A>)</ADDRESS>
</center>
</body>
</html>
EOD;
$connection->disconnect( );
?>