<?php 

class Newsfeed {

    function getNews($id) {
        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        if( !$result  =  mysqli_query($link,  "SELECT * FROM newsfeed WHERE id=$id") ) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }

        $news = mysqli_fetch_array($result);
        return $news;
    }

    function getNewsfeed($quantity) {
        
        $newsfeed = array();

        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        $sql = "SELECT * FROM newsfeed ORDER BY id DESC LIMIT " . $quantity;

        if( !$result  =  mysqli_query($link, $sql) ) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }
    
        while( $str = mysqli_fetch_array($result) ) {
            $newsfeed[] = $str;
        }

        return $newsfeed;
    }

    function addNews($_title, $_shortnews, $_news, $_author) {

        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        $title = mysqli_real_escape_string($link, $_title);
        $shortnews = mysqli_real_escape_string($link, $_shortnews);
        $news = mysqli_real_escape_string($link, $_news);
        $author = mysqli_real_escape_string($link, $_author);

        $date = date("d.m.Y H:i:s");

        $sql = "INSERT INTO newsfeed (id, important, date, title, author, shortnews, news) VALUES ('', '', '" . $date . "', '" . $title . "', '" . $author . "', '" . $shortnews . "', '" . $news . "')";

        if(!$result  =  mysqli_query($link, $sql)) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }

    }

    function removeNews($_rem) {
        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        $rem = mysqli_real_escape_string($link, $_rem);

        $sql = "DELETE FROM newsfeed WHERE id = '".$rem."'";

        if(!$result  =  mysqli_query($link, $sql)) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }

    }

    function getNewsComments($id, $quantity) {
        
        $comments = array();

        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        $sql = "SELECT * FROM newsfeed_comment WHERE newsId = '" . $id . "' ORDER BY id LIMIT " . $quantity;

        if( !$result  =  mysqli_query($link, $sql) ) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }
    
        while( $str = mysqli_fetch_array($result) ) {
            $comments[] = $str;
        }

        return $comments;
    }

    function addComment($_news, $_author, $_comment) {

        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        $news = mysqli_real_escape_string($link, $_news);
        $author = mysqli_real_escape_string($link, $_author);
        $comment = mysqli_real_escape_string($link, $_comment);

        $date = date("d.m.Y H:i:s");

        $sql = "INSERT INTO newsfeed_comment (id, newsId, comment, author, date) VALUES ('', '" . $news . "', '" . $comment . "', '" . $author . "', '" . $date . "')";

        if(!$result  =  mysqli_query($link, $sql)) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }

    }

}

?>