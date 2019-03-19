<?php 
require('client.inc.php');
require(CLIENTINC_DIR.'header.inc.php'); 

class Newsfeed {
    var $length;
    function Newsfeed($value) {
        $this->length = $value*3;
    }
    function getValue($value) {
        $res = $value*5;
        return $res;
    }
    function getNews($id) {
        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        if ( !$result  =  mysqli_query($link,  "SELECT * FROM newsfeed WHERE id=$id") ) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }

        $news = mysqli_fetch_array($result);
        return $news;
    }
    function getNewsfeed($quantity) {
        $newsfeed = array();

        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        if ( !$result  =  mysqli_query($link,  "SELECT * FROM newsfeed ORDER BY id DESC LIMIT $quantity") ) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }
    
        while ( $str = mysqli_fetch_array($result) ) {
            $newsfeed[] = $str;
        }

        return $newsfeed;
    }
}

?>

<h1>Новости</h1>
<hr>
<?php 

mysqli_set_charset( $link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8" );
if ( !$link )  die("Error MySQL");

if(!empty($id = $_GET['id'])) {
 
    // $news = mysqli_fetch_array(mysqli_query( $link,  "SELECT * FROM newsfeed WHERE id=$id" )); 

    $news = Newsfeed::getNews($id); ?>

    <h3><?php echo $news['name']; ?></h3>
    <p><?php echo $news['body']; ?></p>
    <p><i><?php echo $news['date']; ?>, <?php echo $news['topicstarter']; ?></i></p>
    <p><a href="/newsfeed.php">К списку новостей</a></p>

<?php 
}
else {

    // if ( !$result  =  mysqli_query( $link,  "SELECT * FROM newsfeed ORDER BY id DESC LIMIT 20" ) ) {
    //     echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
    // }

    // while ( $str = mysqli_fetch_array($result) ) {
    //     $newsfeed[] = $str;
    // }

    $newsfeed = Newsfeed::getNewsfeed(20);

    foreach ($newsfeed as $news) {
?>

    <h3><?php echo $news['name']; ?></h3>
    <p><?php echo $news['shortbody']; ?></p>
    <p><a href="/newsfeed.php?id=<?php echo $news['id']; ?>">Читать дальше...</a></p>
    <p><i><?php echo $news['date']; ?>, <?php echo $news['topicstarter']; ?></i></p><br>

<?php } } ?>

<hr>

<?php 

$nf = new Newsfeed(13);

echo $nf->length;

?>
<br />
<?php 

echo Newsfeed::getValue(5);

?>

<div class="clear"></div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>