<?php 
$props = json_decode(file_get_contents('php://input'), true);
include("dbconnect.php");
$login = $props['login'];
$pass = $props['pass'];
$postId = $props['postId'];
$imgs = $props['imgs'];
$posText = $props['posText'];
$negText = $props['negText'];
$neuText = $props['neuText'];
$stars = $props['stars'];

try {
    if($login == "" || $pass == "" || $postId == "" || $stars == "" )
        throw new Exception('wrong params');
    
    $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_users` where login='$login' and pass='$pass';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $user = $count->fetch_array(MYSQLI_ASSOC);
    if ($user["count"] == 0)
        throw new Exception('denied');
    $user = $user["id"];
    
    
    $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_posts` where id='$postId';");
    if(!$count)
        throw new Exception('sql error 2');
        
    $postData = $count->fetch_array(MYSQLI_ASSOC);
    if ($postData["count"] == 0)
        throw new Exception('no post with that id');

    $result = $mysqli->query(
        "insert into `cs_comments` (id, createdBy, createdDate, postId, stars, posText, negText, neuText".
        ") values (NULL, '$user', NULL, '$postId', '$stars', '$posText', '$negText', '$neuText');");
    if($result == 0)
        throw new Exception('sql error 3');
    $commentId = $mysqli->query("SELECT LAST_INSERT_ID() as commentId;")->fetch_array(MYSQLI_ASSOC)["commentId"];

    $imgs = json_decode($imgs);
    for ($i = 0; $i < count($imgs); $i++) {
        $byf = $mysqli->query("insert into `cs_imgs` (img, userId, postId, commentId) values ('$imgs[$i]', NULL, '$postId', '$commentId');");
        if($byf == 0)
            throw new Exception('sql error 4');
    }
    echo "UPDATE `cs_posts` SET avg_stars = (select avg(stars) from `cs_comments` as c where c.postId = $postId) WHERE id = $postId;";
    $result = $mysqli->query("UPDATE `cs_posts` SET avgStars = (select avg(stars) from `cs_comments` as c where c.postId = $postId) WHERE id = $postId;");
    if($result == 0)
        throw new Exception('sql error 4');
        
    echo json_encode(array("error"=>"", "result"=>$result));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>