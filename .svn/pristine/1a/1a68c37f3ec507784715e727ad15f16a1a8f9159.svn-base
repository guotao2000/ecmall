<?php
function keywordsArray($key_word, $token){
			$connection=mysql_connect('localhost','root','root');
			mysql_query("SET NAMES 'utf8'");
			mysql_query("SET CHARACTER_SET_CLIENT=utf8");
			mysql_query("SET CHARACTER_SET_RESULTS=utf8");
			$db_selecct=mysql_select_db('ecmall');

			$keyword = trim($key_word);
			$token = trim($token);

			$sql_r = "select * from ecm_wx_pub_config where token='" . $token . "'";
			$res = mysql_query($sql_r);
			while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
				$wx_id = $row['wx_id'];
			}

			$sql = "select * from ecm_wxtuwen where is_subscribe=1 and is_pub=1 and is_default=0 and wx_id=" . $wx_id . " order by update_time desc";
			$results_array = mysql_query($sql);
			while($row = mysql_fetch_array($results_array, MYSQL_ASSOC)){
				$wxkeywords[] = $row;
			}
			
			for($i=0; $i<count($wxkeywords); $i++){
				$words = trim($wxkeywords[$i]['keywords']);
				$words_array = explode(',', $words);
				
				for($j=0; $j<count($words_array); $j++){
					$words_array[$j] = trim($words_array[$j]);
					  if(strstr($keyword, $words_array[$j])){
						$reply_content[] = $wxkeywords[$i];
						break;
					}
				}
			}
			return $reply_content;
}

function wordsGetDefault($token){
			$connection=mysql_connect('localhost','root','root');
			mysql_query("SET NAMES 'utf8'");
			mysql_query("SET CHARACTER_SET_CLIENT=utf8");
			mysql_query("SET CHARACTER_SET_RESULTS=utf8");
			$db_selecct=mysql_select_db('ecmall');

			$token = trim($token);

			$sql_r = "select * from ecm_wx_pub_config where token='" . $token . "'";
			$res = mysql_query($sql_r);
			while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
				$wx_id = $row['wx_id'];
			}

			$sql = "select * from ecm_wxtuwen where is_subscribe=1 and is_pub=1 and is_default=1 and wx_id=" . $wx_id . " order by update_time desc";
			$results_array = mysql_query($sql);
			while($row = mysql_fetch_array($results_array, MYSQL_ASSOC)){
				$wxkeywords = $row;
			}

			return $wxkeywords;
}

?>