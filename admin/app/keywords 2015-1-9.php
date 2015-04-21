<?php
function keywordsArray($key_word){
			$connection=mysql_connect('localhost','root','root');
			mysql_query("SET NAMES 'utf8'");
			mysql_query("SET CHARACTER_SET_CLIENT=utf8");
			mysql_query("SET CHARACTER_SET_RESULTS=utf8");
			$db_selecct=mysql_select_db('ecmall');
			$keyword = trim($key_word);
			$sql = "select * from ecm_wxword order by wxw_id asc";
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
						$reply_content = $wxkeywords[$i]['reply'];
						break;
					}
				}
			}

			if(!isset($reply_content) || empty($reply_content)){
				return ;
			}

			return $reply_content;
}
?>