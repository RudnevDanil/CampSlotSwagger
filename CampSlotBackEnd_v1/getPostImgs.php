<?php 
$props = json_decode(file_get_contents('php://input'), true);

include("dbconnect.php");

$postId = $props['postId'];
$fromComments = $props['fromComments'];

try {
    
    if($postId == "" || $fromComments == "")
        throw new Exception('wrong params');
        
    
    $imgs = $mysqli->query("SELECT img FROM `cs_imgs` where userId IS NULL and postId='$postId' and commentId IS NULL;");
    
    if(!$imgs)
        throw new Exception('sql error 1');
    
    $imgs = $imgs->fetch_all();
    
    echo json_encode(array("error"=>"", "imgs"=>$imgs));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>