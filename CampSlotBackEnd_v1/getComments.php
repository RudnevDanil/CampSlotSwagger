<?php 
$props = json_decode(file_get_contents('php://input'), true);

include("dbconnect.php");

$postId = $props['postId'];
$limit = $props['limit'];
$offset = $props['offset'];

try {
    
    if($postId == "")
        throw new Exception('wrong params');
    
    $queryAdd = "LIMIT $limit OFFSET $offset";
    
    $comments = $mysqli->query("SELECT ".
                                "id, ".
                                "(select login from `cs_users` where id = comment.createdBy) as createdByName, ".
                                "(select img from `cs_imgs` where userId = comment.createdBy and postId IS NULL and commentId IS NULL) as createdAvatar, ".
                                "createdDate, ".
                                "stars, ".
                                "(select count(id) from `cs_imgs` where userId IS NULL and postId = $postId and commentId = comment.id) as imgsAm, ".
                                "posText, ".
                                "negText, ".
                                "neuText ".
                                " FROM `cs_comments` as comment where postId='$postId' " . (($limit != "" && $offset != "") ? $queryAdd : "") . ";");

    
    if(!$comments)
        throw new Exception('sql error 1');
    
    $comments = $comments->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode(array("error"=>"", "comments"=>$comments));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>