<?php 
require('client.inc.php');
require(CLIENTINC_DIR.'header.inc.php'); 
require_once(INCLUDE_DIR.'class.newsfeed.php');
?>
<div class="newsfeed-client">
<h1>Новости</h1>
<hr>
<?php 

mysqli_set_charset( $link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8" );
if(!$link) die("Error MySQL");

if(!empty($id = $_GET['id'])) {

    $news = Newsfeed::getNews($id); ?>

    <h3><?php echo $news['title']; ?></h3>
    <p><?php echo $news['news']; ?></p>
    <p><i><?php echo $news['date']; ?>, <?php echo $news['author']; ?></i></p>
    <p><a href="/newsfeed.php">К списку новостей</a></p>

    <hr>

<?php 

    echo '<h3>Комментарии:</h3><br>';

    if(!empty($_POST['nftoken'])) {
        if(!empty($_POST['nfcomment'])) {
            Newsfeed::addComment($id, $thisclient->getName(), $_POST['nfcomment']);
            echo '<p class="nf-alert-green">Success!</p>';
        }
        else {
            echo '<p class="nf-alert-red">You must complete all fields.</p>';
        }
    } 

    $comments = Newsfeed::getNewsComments($id, 30);

    if(!empty($comments)) {
        foreach($comments as $comment) { 
?>
        <div class="comment">
            <h4><?php echo $comment['author']; ?></h4>
            <div class="comment-body"><?php echo $comment['comment']; ?></div>
            <p><i><?php echo $comment['date']; ?></i></p>
        </div>
<?php 
        }
    }
    else {
        echo '<div class="comment">(Комментариев пока нет)</div>';
    }
?>

    <hr>
    <h3>Добавить комментарий:</h3><br>

<?php if ($thisclient && is_object($thisclient) && $thisclient->isValid() && !$thisclient->isGuest()) {

?>

<form action="" method="post">
<?php csrf_token(); ?>
<input type="hidden" name="nftoken" value="true">
    <table width="940" cellspacing="0" cellpadding="0" border="0">
       <tbody>
            <tr>
                <td>От: <strong><?php echo $thisclient->getName(); ?></strong></td>
           </tr>
           <tr>
                <td>
                    <textarea cols="21" rows="8" name="nfcomment"></textarea>
               </td>
           </tr>
           <tr>
                <td valign="top" class="required"><br /><input type="submit" value="Добавить"></td>
           </tr>
        </tbody>
   </table>
</form>

<?php 
    }
    
    else {
        echo '(Чтобы оставить комментарий, нужно войти)';
    }

}
else {

    $newsfeed = Newsfeed::getNewsfeed(20);

    foreach($newsfeed as $news) {
?>

    <h3><?php echo $news['title']; ?></h3>
    <p><?php echo $news['shortnews']; ?></p>
    <p><a href="/newsfeed.php?id=<?php echo $news['id']; ?>">Читать дальше...</a></p>
    <p><i><?php echo $news['date']; ?>, <?php echo $news['author']; ?></i></p><br>

<?php } } ?>

<hr>

</div>
<div class="clear"></div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>