<?php 
$props = json_decode(file_get_contents('php://input'), true);
include("dbconnect.php");
$login = $props['login'];
$pass = $props['pass'];
$title = $props['title'];
$text = $props['text'];
$imgs = $props['imgs'];
$transportRating = $props['transportRating'];
$infrastructures = $props['infrastructureArr'];
$isPaid = $props['isPaid'];
$paymentText = $props['paymentText'];
$lat = $props['lat'];
$lon = $props['lon'];
try {
    if($login == "" || $pass == "" || $title == "" || $imgs == "" || $imgs == "[]" || $transportRating == "" || $isPaid == "" || $isPaid == "true" && $paymentText == "" || $lat == "" || $lon == "")
        throw new Exception('wrong params');
    
    $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_users` where login='$login' and pass='$pass';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $user = $count->fetch_array(MYSQLI_ASSOC);
    if ($user["count"] == 0)
        throw new Exception('denied');
    $user = $user["id"];
    
    if($isPaid != "true" && $isPaid != "false")
        throw new Exception('isPaid error');
    else{
        if($isPaid == "true")
            $isPaid = "1";
        else
            $isPaid = "0";
    }
        
    $imgs = json_decode($imgs);
    if(count($imgs) == 0)
        throw new Exception('zero imgs');
        
    $imgForShortCut = $imgs[0];
    $byf = $mysqli->query("insert into `cs_imgs` (img) values ('$imgForShortCut');");
    if($byf == 0)
        throw new Exception('sql error 5');
    $shortCutId = $mysqli->query("SELECT LAST_INSERT_ID() as imgId;")->fetch_array(MYSQLI_ASSOC)["imgId"];
    
    $water = 'NULL';
    $spring = 'NULL';
    $shower = 'NULL';
    $playground = 'NULL';
    $cafe = 'NULL';
    $trash = 'NULL';
    $toilet = 'NULL';
    $socket = 'NULL';
    $shadow = 'NULL';
    $surfspot = 'NULL';
    $lake = 'NULL';
    $waterfall = 'NULL';
    $altitude = 'NULL';
    $forest = 'NULL';
    $viewpoint = 'NULL';
    $fishing = 'NULL';
    $sea = 'NULL';

    $infrastructures = json_decode($infrastructures);
    for ($i = 0; $i < count($infrastructures); $i++) {
        if($infrastructures[$i] == "water") $water = true;
        if($infrastructures[$i] == "spring") $spring = true;
        if($infrastructures[$i] == "shower") $shower = true;
        if($infrastructures[$i] == "playground") $playground = true;
        if($infrastructures[$i] == "cafe") $cafe = true;
        if($infrastructures[$i] == "trash") $trash = true;
        if($infrastructures[$i] == "toilet") $toilet = true;
        if($infrastructures[$i] == "socket") $socket = true;
        if($infrastructures[$i] == "shadow") $shadow = true;
        if($infrastructures[$i] == "surfspot") $surfspot = true;
        if($infrastructures[$i] == "lake") $lake = true;
        if($infrastructures[$i] == "waterfall") $waterfall = true;
        if($infrastructures[$i] == "altitude") $altitude = true;
        if($infrastructures[$i] == "forest") $forest = true;
        if($infrastructures[$i] == "viewpoint") $viewpoint = true;
        if($infrastructures[$i] == "fishing") $fishing = true;
        if($infrastructures[$i] == "sea") $sea = true;
    }


    $result = $mysqli->query(
        "insert into `cs_posts` (id, createdBy, createdDate, title, text, transportRating, isPaid, paymentText, avgStars, lat, lon, avatar".
        ", f_water, f_spring, f_shower, f_playground, f_cafe, f_trash, f_toilet, f_socket, f_shadow, f_surfspot, f_lake, f_waterfall, f_altitude, f_forest, f_viewpoint, f_fishing, f_sea".
        ") values (NULL, '$user', NULL, '$title', '$text', '$transportRating', '$isPaid', '$paymentText', 0, '$lat', '$lon', '$shortCutId'".
        ", '$water', '$spring', '$shower', '$playground', '$cafe', '$trash', '$toilet', '$socket', '$shadow', '$surfspot', '$lake', '$waterfall', '$altitude', '$forest', '$viewpoint', '$fishing', '$sea'".
        ");");
    if($result == 0)
        throw new Exception('sql error 6');
        
    $newPostId = $mysqli->query("SELECT LAST_INSERT_ID() as newPostId;")->fetch_array(MYSQLI_ASSOC)["newPostId"];

    $byf = $mysqli->query("UPDATE `cs_imgs` SET postId = '$newPostId' WHERE id = '$shortCutId';");
    if($byf == 0)
        throw new Exception('sql error 5');
    
    for ($i = 1; $i < count($imgs); $i++) {
        $byf = $mysqli->query("insert into `cs_imgs` (img, userId, postId, commentId) values ('$imgs[$i]', NULL, '$newPostId', NULL);");
        if($byf == 0)
            throw new Exception('sql error 5');
    }
    
    echo json_encode(array("error"=>"", "result"=>$result));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>