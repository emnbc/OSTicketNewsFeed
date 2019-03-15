<?php 
require('client.inc.php');
require(CLIENTINC_DIR.'header.inc.php'); 
?>

<h1>Новости</h1>
<hr>
<?php 

define('DBHOST','localhost');
define('DBNAME','osticket');
define('DBUSER','osticket');
define('DBPASS','918611984Ost');

mysqli_set_charset( $link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8" );

if ( !$link )  die("Error MySQL");

$result  =  mysqli_query( $link,  "SELECT * FROM newsfeed ORDER BY id DESC LIMIT 20" );

if ( !$result ) echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();

while ( $str = mysqli_fetch_array($result) ) {
    $newsfeed[] = $str;
}

foreach ($newsfeed as $news) {
?>

    <h3><?php echo $news['name']; ?></h3>
    <p><?php echo $news['body']; ?></p>
    <p><i><?php echo $news['date']; ?>, <?php echo $news['topicstarter']; ?></i></p><br>

<?php 
}

mysqli_close($link); 
?>
<hr>
<div class="clear"></div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>