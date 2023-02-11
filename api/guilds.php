<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/http; chagset=UTF-8");
require_once("../db.config.php");
require_once("../api/FCR.php");

	$conn = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);
	$conn->set_charset("utf8");
	$result = $conn->query("SELECT 
		guild.id, 
		guild.name, 
		guild.authority, 
		guild.unlocked_level, 
		avatar.name AS leader_name, 
		soul.faction_res_id, 
		count(guild_members.id) AS members_count FROM guild
        LEFT OUTER JOIN (guild_member_descriptors as guild_members) ON guild_members.guild_id = guild.id
        LEFT JOIN guild_member_descriptors ON guild_member_descriptors.guild_id = guild.id AND guild_member_descriptors.rank_res_id = 408682500
        INNER JOIN avatar ON avatar.id = guild_member_descriptors.avatar_id
        INNER JOIN soul ON soul.id = avatar.soul_id
        GROUP BY guild.id
        ORDER BY guild.authority DESC
		LIMIT 5");

	$outp = "";



	while($guilds = $result->fetch_array(MYSQLI_ASSOC)) {
		
	  if ($outp != "") {$outp .= ",";}
	  $outp .= '{"guild":"'  . $guilds["name"] . '",';
	  $outp .= '"level":"'   . $guilds["unlocked_level"]        . '",';
	  $outp .= '"authority":"'   . $guilds["authority"]        . '",';
	  $outp .= '"faction":"'   . GetFaction($guilds["faction_res_id"])       . '",';
	  $outp .= '"leader_name":"'   . $guilds["leader_name"]        . '",';
	  $outp .= '"members_count":"'   . $guilds["members_count"]        . '"}';

	}
	$outp ='{"guilds":['.$outp.']}';
	$conn->close();

echo($outp);
?>