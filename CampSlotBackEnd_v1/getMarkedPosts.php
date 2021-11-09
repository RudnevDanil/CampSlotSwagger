<?php 
$props = json_decode(file_get_contents('php://input'), true);

include("dbconnect.php");

$userId = $props['userId'];
$limit = $props['limit'];
$offset = $props['offset'];

try {
    
    if($userId == "")
        throw new Exception('wrong params');
        
    $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_users` where id='$userId';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $user = $count->fetch_array(MYSQLI_ASSOC);
    if ($user["count"] == 0)
        throw new Exception('no user with such id');
    
    $queryAdd = "LIMIT $limit OFFSET $offset";
    $markedIds = $mysqli->query("SELECT postId FROM `cs_markedPosts` where userId='$userId' " . (($limit != "" && $offset != "") ? $queryAdd : "") . ";");
    
    if(!$markedIds)
        throw new Exception('sql error 2');
    
    $markedIds = $markedIds->fetch_all();
    
    $markedIdsArray = array();
    for ($i = 0; $i < count($markedIds); $i++) {
        $markedIdsArray[$i] = $markedIds[$i][0];
    }
    
    $postsInfo = $mysqli->query("SELECT id, lat, lon, avgStars, title, (SELECT img from `cs_imgs` as im where im.userId IS NULL and im.postId=p.id and im.commentId IS NULL limit 1) as avatar ".
        "FROM `cs_posts` as p where id IN (" . implode(',', $markedIdsArray) . ");");
    if(!$postsInfo)
        throw new Exception('sql error 3');
    
    $postsInfo = $postsInfo->fetch_all(MYSQLI_ASSOC);
    
    
    echo json_encode(array("error"=>"", "markedPosts"=>$postsInfo));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>