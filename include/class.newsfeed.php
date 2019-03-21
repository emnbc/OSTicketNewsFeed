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

    function addNews($title, $shortnews, $news, $author) {

        mysqli_set_charset($link = mysqli_connect( DBHOST, DBUSER, DBPASS, DBNAME ), "utf8");

        $date = date("d.m.Y H:i:s");

        $sql = "INSERT INTO newsfeed (id, important, date, title, author, shortnews, news) VALUES ('', '', '" . $date . "', '" . $title . "', '" . $author . "', '" . $shortnews . "', '" . $news . "')";

        if(!$result  =  mysqli_query($link, $sql)) {
            echo "Произошла ошибка запроса MySQL: "  .  mysqli_error();
        }

    }

}

?>