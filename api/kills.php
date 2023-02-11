<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/http; chagset=UTF-8");
require_once("../db.config.php");
require_once("../api/FCR.php");

	$conn = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);
	$conn->set_charset("utf8");
	$result = $conn->query("SELECT 
	avatar.name AS avatar_name,
	avatar.level AS avatar_level,
	avatar.race_class_res_id,
	avatar.kills,
	soul.faction_res_id,
	guild.name AS guild_name
	FROM avatar
	LEFT JOIN soul ON soul.id = avatar.soul_id
	LEFT JOIN guild_member_descriptors ON guild_member_descriptors.avatar_id = avatar.id
	LEFT JOIN guild ON guild.id = guild_member_descriptors.guild_id
	ORDER BY avatar.kills DESC
	LIMIT 5");

	$outp = "";



	while($kills = $result->fetch_array(MYSQLI_ASSOC)) {
		
	  if ($outp != "") {$outp .= ",";}
	  $outp .= '{"name":"'  . $kills["avatar_name"] . '",';
	  $outp .= '"level":"'   . $kills["avatar_level"]        . '",';
	  $outp .= '"kills":"'   . $kills["kills"]        . '",';
	  $outp .= '"faction":"'   . GetFaction($kills["faction_res_id"])       . '",';
	  $outp .= '"guild":"'   . $kills["guild_name"]        . '",';
	  $outp .= '"race":"'   . GetRace($kills["race_class_res_id"])        . '",';
	  $outp .= '"class":"'. GetClass($kills["race_class_res_id"])     . '"}';

	}

	$outp ='{"kills":['.$outp.']}';
	$conn->close();

echo($outp);
?>