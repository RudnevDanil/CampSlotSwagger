<?php 
$props = json_decode(file_get_contents('php://input'), true);

include("dbconnect.php");

$postId = $props['postId'];
$commentsIds = $props['commentsIds'];

try {
    
    if($postId == "" || $commentsIds == "" || $commentsIds == "[]")
        throw new Exception('wrong params');
        
    $commentsIds = json_decode($commentsIds);
    $imgs = $mysqli->query("SELECT img, commentId FROM `cs_imgs` where userId IS NULL and postId='$postId' and commentId IN (" . implode(',', $commentsIds) . ");");
    
    if(!$imgs)
        throw new Exception('sql error 1');
    
    $imgs = $imgs->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode(array("error"=>"", "imgs"=>$imgs));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>