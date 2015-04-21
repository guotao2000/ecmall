<?php
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
logger("错误类型：".$postObj->ErrorType."错识描述：".$postObj->Description."错误详情：".$postObj->AlarmContent);

//日志记录
function logger($log_content)
{
	$max_size = 100000;
	$log_filename = "log.xml";
	if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
	file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
}
?>