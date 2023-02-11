<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/http; chagset=UTF-8");
require_once("../db.config.php");
require_once("../api/FCR.php");

	$conn = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);
	$conn->set_charset("utf8");
	$result = $conn->query("SELECT 
	ships.name AS ship_name,
	ships.gear_score,
	avatar.name AS avatar_name,
	soul.faction_res_id,
	guild.name AS guild_name
	FROM ships
	LEFT JOIN avatar ON avatar.soul_id = ships.owner_soul_id
	LEFT JOIN soul ON ships.owner_soul_id = soul.id
	LEFT JOIN guild_member_descriptors ON guild_member_descriptors.avatar_id = avatar.id
	LEFT JOIN guild ON guild.id = guild_member_descriptors.guild_id AND guild_member_descriptors.avatar_id = avatar.id
	ORDER BY ships.gear_score DESC
	LIMIT 5");

	$outp = "";



	while($ships = $result->fetch_array(MYSQLI_ASSOC)) {
		
	  if ($outp != "") {$outp .= ",";}
	  $outp .= '{"name":"'  . $ships["avatar_name"] . '",';
	  $outp .= '"faction":"'   . GetFaction($ships["faction_res_id"])       . '",';
	  $outp .= '"ship":"'   . $ships["ship_name"]        . '",';
	  $outp .= '"guild":"'   . $ships["guild_name"]        . '",';
	  $outp .= '"gear_score":"'   . $ships["gear_score"]        . '"}';
	}
	$outp ='{"ships":['.$outp.']}';
	$conn->close();

echo($outp);
?>