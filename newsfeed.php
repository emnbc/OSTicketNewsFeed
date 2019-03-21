<?php 
require('client.inc.php');
require(CLIENTINC_DIR.'header.inc.php'); 
require_once(INCLUDE_DIR.'class.newsfeed.php');
?>

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

<?php 
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

<div class="clear"></div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>