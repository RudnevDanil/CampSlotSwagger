<?php 
$props = json_decode(file_get_contents('php://input'), true);

include("dbconnect.php");

$lat = $props['lat'];
$lon = $props['lon'];
$dist = $props['dist'];
$minTransportRating = $props['minTransportRating'];
$minStarRating = $props['minStarRating'];
$limit = $props['limit'];
$offset = $props['offset'];
$login = $props['login'];
$pass = $props['pass'];
$infrastructureArr = $props['infrastructureArr'];

$minTransportRating = $minTransportRating == "" ? "0" : $minTransportRating;
$minStarRating = $minStarRating == "" ? "0" : $minStarRating;
$dist = $dist == "" ? "1.0" : $dist;

try {
    
    if($lat == "" || $lon == "")
        throw new Exception('wrong params');
        
    $userId = null;
    if($login != "" && $pass != ""){
        $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_users` where login='$login' and pass='$pass';");
        if(!$count)
            throw new Exception('sql error 1');
            
        $user = $count->fetch_array(MYSQLI_ASSOC);
        if ($user["count"] == 0)
            throw new Exception('denied');
        $userId = $user["id"];
    }

    $infArr = json_decode($infrastructureArr);
    $infrQuery = "";
    for ($i = 0; $i < count($infArr); $i++) {
        if( $infArr[$i] == "water"    || $infArr[$i] == "spring"   || $infArr[$i] == "shower"    || $infArr[$i] == "playground" || 
            $infArr[$i] == "cafe"     || $infArr[$i] == "trash"    || $infArr[$i] == "toilet"    || $infArr[$i] == "socket"     || 
            $infArr[$i] == "shadow"   || $infArr[$i] == "surfspot" || $infArr[$i] == "lake"      || $infArr[$i] == "waterfall"  || 
            $infArr[$i] == "altitude" || $infArr[$i] == "forest"   || $infArr[$i] == "viewpoint" || $infArr[$i] == "fishing"    || 
            $infArr[$i] == "sea"
        ){
            $infrQuery = $infrQuery . " and " . "f_" . $infArr[$i] . " = '1' ";
        }
    }
    
    $query = "SELECT  id, ".
                                    "title, ".
                                    "lat, ".
                                    "lon, ".
                                    "avgStars, ".
                                    "(select count(id) from `cs_markedPosts` as m where m.postId = p.id and userId = $userId) as isMarked ".
                            "FROM `cs_posts` as p ".
                            "WHERE ".
                                "transportRating>='$minTransportRating' and ".
                                "avgStars>='$minStarRating' ".
                                (($infrQuery == "") ? "" : $infrQuery).
                                " and (2 * 6373 * ASIN(SQRT(POW(SIN(($lat - p.lat) * Pi() / 360), 2) + COS($lat * Pi() / 180)*COS(p.lat * Pi() / 180)*POW(SIN(($lon - p.lon) * Pi() / 360), 2) ))) <= '$dist' ".
                            "LIMIT $limit OFFSET $offset".
                            ";";

    $posts = $mysqli->query($query);
    
    if(!$posts)
        throw new Exception('sql error 1');
    
    $posts = $posts->fetch_all(MYSQLI_ASSOC);
    echo json_encode(array("error"=>"", "posts"=>$posts));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>