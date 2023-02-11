<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/http; chagset=UTF-8");
require_once("../db.config.php");
require_once("../api/FCR.php");

	$conn = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);
	$conn->set_charset("utf8");
	$result = $conn->query("SELECT 
			avatar.name,
			avatar.level,
			avatar.race_class_res_id,
			avatar.gear_score,
			soul.faction_res_id,
			guild.name AS guild_name
			FROM avatar
			LEFT JOIN soul ON soul.id = avatar.soul_id
			LEFT JOIN guild_member_descriptors ON guild_member_descriptors.avatar_id = avatar.id
			LEFT JOIN guild ON guild.id = guild_member_descriptors.guild_id
			ORDER BY avatar.gear_score DESC
		LIMIT 5");

	$outp = "";



	while($gs = $result->fetch_array(MYSQLI_ASSOC)) {
		
	  if ($outp != "") {$outp .= ",";}
	  $outp .= '{"name":"'  . $gs["name"] . '",';
	  $outp .= '"level":"'   . $gs["level"]        . '",';
	  $outp .= '"gear_score":"'   . $gs["gear_score"]        . '",';
	  $outp .= '"faction":"'   . GetFaction($gs["faction_res_id"])       . '",';
	  $outp .= '"guild":"'   . $gs["guild_name"]        . '",';
	    $outp .= '"race":"'   . GetRace($gs["race_class_res_id"])        . '",';
	  $outp .= '"class":"'. GetClass($gs["race_class_res_id"])     . '"}';

	}

	$outp ='{"gearscore":['.$outp.']}';
	$conn->close();

echo($outp);
?>