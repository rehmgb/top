<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/http; chagset=UTF-8");
require_once("../db.config.php");
require_once("../api/FCR.php");

	$conn = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);
	$conn->set_charset("utf8");
	$result = $conn->query("SELECT
				  avatar.id,
				  avatar.name,
				  avatar.race_class_res_id,
				  soul.faction_res_id,
				  achievement.avatar_id,
				  achievement.class_res_id,
				  achievement.achievement,
				  guild.name AS guild_name
				  FROM avatar
			   	LEFT JOIN soul ON soul.id = avatar.soul_id
				LEFT JOIN guild_member_descriptors ON guild_member_descriptors.avatar_id = avatar.id
				LEFT JOIN guild ON guild.id = guild_member_descriptors.guild_id
				  INNER JOIN achievement
					ON achievement.avatar_id = avatar.id
				GROUP BY achievement.avatar_id
						ORDER BY achievement DESC
						LIMIT 5");

	$outp = "";



	while($arena = $result->fetch_array(MYSQLI_ASSOC)) {
		
	  if ($outp != "") {$outp .= ",";}
	  $outp .= '{"name":"'  . $arena["avatar_name"] . '",';
	  $outp .= '"faction":"'   . GetFaction($arena["faction_res_id"])       . '",';
	  $outp .= '"guild":"'   . $arena["guild_name"]        . '",';
	  $outp .= '"race":"'   . GetRace($arena["race_class_res_id"])        . '",';
	  $outp .= '"class":"'. GetClass($arena["race_class_res_id"])      . '",';
	  $outp .= '"achievement":"'   . $arena["achievement"]        . '"}';
	}
	$outp ='{"arena":['.$outp.']}';
	$conn->close();

echo($outp);
?>