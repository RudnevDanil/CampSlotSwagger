<?php 
$props = json_decode(file_get_contents('php://input'), true);

include("dbconnect.php");

$postId = $props['postId'];

try {
    
    if($postId == "")
        throw new Exception('wrong params');

    $post = $mysqli->query("SELECT  id, ".
                                    "title, ".
                                    "text, ".
                                    "createdDate, ".
                                    "(select login from `cs_users` as u where u.id = p.createdBy limit 1) as creatorName,".
                                    "(select img from `cs_imgs` as im where im.userId = p.createdBy and im.postId IS NULL and im.commentId IS NULL limit 1) as creatorAvatar,".
                                    "createdBy as creatorId,".
                                    "transportRating,".
                                    "isPaid,".
                                    "avgStars,".
                                    "paymentText,".
                                    "(select count(id) from `cs_comments` as c where c.postId = p.id) as commentsAmount,".
                                    "(select count(id) from `cs_imgs` as im where im.userId IS NULL and im.postId = p.id and im.commentId IS NULL) as imgsOrigAm,".
                                    "(select count(id) from `cs_imgs` as im where im.userId IS NULL and im.postId = p.id and im.commentId IS NOT NULL) as imgsFromComAm, ".
                                    "f_water as water, " .
                                    "f_spring as spring, " .
                                    "f_shower as shower, " .
                                    "f_playground as playground, " .
                                    "f_cafe as cafe, " .
                                    "f_trash as trash, " .
                                    "f_toilet as toilet, " .
                                    "f_socket as socket, " .
                                    "f_shadow as shadow, " .
                                    "f_surfspot as surfspot, " .
                                    "f_lake as lake, " .
                                    "f_waterfall as waterfall, " .
                                    "f_altitude as altitude, " .
                                    "f_forest as forest, " .
                                    "f_viewpoint as viewpoint, " .
                                    "f_fishing as fishing, " .
                                    "f_sea as sea  " .
                            "FROM `cs_posts` as p where id='$postId';");
    
    if(!$post)
        throw new Exception('sql error 1');
    
    $post = $post->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode(array("error"=>"", "post"=>$post));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>