<?php
function html_header($html_title,$style_sheet){
echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/TR/html401/loose.dtd" xml:lang="ja" lang="ja">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>$html_title</title>
    <link rel="stylesheet" type="text/css" href="css/$style_sheet.css">
</head>
EOD;
}
?>

