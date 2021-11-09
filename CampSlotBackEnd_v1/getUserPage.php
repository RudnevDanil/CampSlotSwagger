<?php 
$props = json_decode(file_get_contents('php://input'), true);

include("dbconnect.php");

$userId = $props['userId'];

try {
    
    if($userId == "")
        throw new Exception('wrong params');
    
    $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_users` where id='$userId';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $user = $count->fetch_array(MYSQLI_ASSOC);
    if ($user["count"] == 0)
        throw new Exception('no user with such id');
    
    $count = $mysqli->query("SELECT count(id) as count FROM `cs_markedPosts` where userId='$userId' and postId='$postId';");
    if(!$count)
        throw new Exception('sql error 2');
    $markCount = $count->fetch_array(MYSQLI_ASSOC)["count"];
    
    $count = $mysqli->query("SELECT count(id) as count FROM `cs_posts` where createdBy='$userId';");
    if(!$count)
        throw new Exception('sql error 3');
    $postsCount = $count->fetch_array(MYSQLI_ASSOC)["count"];
    
    $count = $mysqli->query("SELECT count(id) as count FROM `cs_comments` where createdBy='$userId';");
    if(!$count)
        throw new Exception('sql error 4');
    $commentsCount = $count->fetch_array(MYSQLI_ASSOC)["count"];
    
    $userInfo = $mysqli->query("SELECT id, transportRating, transportName FROM `cs_users` where id='$userId';");
    if(!$count)
        throw new Exception('sql error 5');
    $userInfo  = $userInfo->fetch_array(MYSQLI_ASSOC);
    $transportRating = $userInfo["transportRating"];
    $transportName = $userInfo["transportName"];
    
    $count = $mysqli->query("SELECT img FROM `cs_imgs` where userId='$userId' limit 1;");
    if(!$count)
        throw new Exception('sql error 6');
    $avatar = $count->fetch_array(MYSQLI_ASSOC)["img"];
    
    
    echo json_encode(array("error"=>"", 
        "userId"=>$userId, 
        "markCount"=>$markCount, 
        "postsCount"=>$postsCount, 
        "commentsCount"=>$commentsCount, 
        "transportRating"=>$transportRating, 
        "transportName"=>$transportName, 
        "avatar"=>$avatar,
    ));
    

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>