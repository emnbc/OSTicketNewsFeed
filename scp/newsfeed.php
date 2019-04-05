<?php 
require('staff.inc.php');
require_once(INCLUDE_DIR.'class.faq.php');
require_once(INCLUDE_DIR.'class.newsfeed.php');
require_once(STAFFINC_DIR.'header.inc.php'); 
?>

<div class="newsfeed-staff">

<?php 

if(!empty($_POST['nftokenadd'])) {
    if(!empty($_POST['nftitle']) && !empty($_POST['nfshortnews']) && !empty($_POST['nfnews'])) {
        Newsfeed::addNews($_POST['nftitle'], $_POST['nfshortnews'], $_POST['nfnews'], $thisstaff->getFirstName());
        echo '<p class="nf-alert-green">Success!</p>';
    }
    else {
        echo '<p class="nf-alert-red">You must complete all fields.</p>';
    }
}

if(!empty($rem = $_GET['rem'])) {
    $news = Newsfeed::getNews($rem);
    ?>
    <form action="newsfeed.php" method="post">
        <p class="nf-alert-red">   
            Вы действительно хотите удалить запись "<?php echo $news['title']; ?>"?
            <?php csrf_token(); ?>
            <input type="hidden" name="nfdelete" value="<?php echo $rem; ?>">
            <input type="submit" value="Удалить"> 
            <input type="button" value="Отмена" onclick="location.href='newsfeed.php'">
        </p>
    </form>
    <?php 
}

if(!empty($_POST['nfdelete']) && (int)$_POST['nfdelete'] > 0) {
    Newsfeed::removeNews($_POST['nfdelete']);
}


// NEWS EDITING BEGIN /////////////

if(!empty($_GET['edit']) && $_GET['edit'] > 0) {
    if(!empty($_POST['nftokenedit'])) {
        if(!empty($_POST['nftitle']) && !empty($_POST['nfshortnews']) && !empty($_POST['nfnews'])) {
            Newsfeed::editNews($_GET['edit'], $_POST['nftitle'], $_POST['nfshortnews'], $_POST['nfnews']);
            echo '<p class="nf-alert-green">Success!</p>';
        }
        else {
            echo '<p class="nf-alert-red">You must complete all fields.</p>';
        }
    }
    $news = Newsfeed::getNews($_GET['edit']);
    ?>
    <form action="" method="post">
    <?php csrf_token(); ?>
        <input type="hidden" name="nftokenedit" value="true">
        <h2>Редактировать новость</h2><br>
        <table width="940" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td valign="top" class="required">Заголовок:<span class="error">*</span> </td>
                    <td>
                        <input type="text" size="100" name="nftitle" value="<?php echo $news['title']; ?>">
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="required">Новость коротко:<span class="error">*</span> </td>
                    <td>
                            <textarea cols="21" rows="5" name="nfshortnews"><?php echo $news['shortnews']; ?></textarea>
                    </td>
                </tr>
                <tr>
                        <td valign="top" class="required">Новость:<span class="error">*</span> </td>
                        <td>
                            <textarea cols="21" rows="10" name="nfnews"><?php echo $news['news']; ?></textarea>
                    </td>
                </tr>
                <tr>
                        <td valign="top" class="required">Автор: </td>
                        <td><?php echo $news['author']; ?></td>
                </tr>
                <tr>
                        <td valign="top" class="required"><br /><input type="submit" value="Редактировать"></td>
                        <td></td>
                </tr>
            </tbody>
        </table>
    </form>
    <p><a href="/scp/newsfeed.php">К списку новостей</a></p>
    <hr>
    <h2>Комментарии</h2>

    <?php 

    if(!empty($_POST['nfdeletecomment']) && (int)$_POST['nfdeletecomment'] > 0) {
        Newsfeed::removeComment($_POST['nfdeletecomment']);
    }

    $comments = Newsfeed::getNewsComments($_GET['edit'], 30);

    if(!empty($remComment = $_GET['remcomment'])) {
        $comment = Newsfeed::getOneComment($remComment);
        ?>
        <form action="newsfeed.php?edit=<?php echo $news['id']; ?>" method="post">
            <p class="nf-alert-red">   
                Вы действительно хотите удалить комментарий от <?php echo $comment['date']; ?> ?
                <?php csrf_token(); ?>
                <input type="hidden" name="nfdeletecomment" value="<?php echo $remComment; ?>">
                <input type="submit" value="Удалить"> 
                <input type="button" value="Отмена" onclick="location.href='newsfeed.php?edit=<?php echo $news['id']; ?>'">
            </p>
        </form>
    <?php
    }

    if(!empty($comments)) {
        foreach($comments as $comment) { 
    ?>
        <div class="comment">
            <h4><?php echo $comment['author']; ?></h4>
            <div class="comment-body"><?php echo $comment['comment']; ?></div>
            <p><i><?php echo $comment['date']; ?></i> - <a style="color: red" href="newsfeed.php?edit=<?php echo $news['id']; ?>&remcomment=<?php echo $comment['id']; ?>">[Удалить]</a></p>
        </div>
    <?php 
        }
    }
    else {
        echo '<div class="comment">(Комментариев пока нет)</div>';
    }
    echo '<hr>';
}

// NEWS EDITING END /////////////

// NEWS ADDING BEGIN /////////////

else {
?>
<form action="" method="post">
<?php csrf_token(); ?>
<input type="hidden" name="nftokenadd" value="true">
    <h2>Добавить новость</h2><br>
    <table width="940" cellspacing="0" cellpadding="0" border="0">
       <tbody>
           <tr>
               <td valign="top" class="required">Заголовок:<span class="error">*</span> </td>
               <td>
                   <input type="text" size="100" name="nftitle" value="">
               </td>
           </tr>
           <tr>
               <td valign="top" class="required">Новость коротко:<span class="error">*</span> </td>
               <td>
                    <textarea cols="21" rows="5" name="nfshortnews"></textarea>
               </td>
           </tr>
           <tr>
                <td valign="top" class="required">Новость:<span class="error">*</span> </td>
                <td>
                    <textarea cols="21" rows="10" name="nfnews"></textarea>
               </td>
           </tr>
           <tr>
                <td valign="top" class="required">Автор: </td>
                <td><?php echo $thisstaff->getFirstName(); ?></td>
           </tr>
           <tr>
                <td valign="top" class="required"><br /><input type="submit" value="Добавить новость"></td>
                <td></td>
           </tr>
        </tbody>
   </table>
</form>
<hr>
<?php 

// NEWS ADDING END /////////////

// NEWS FEED BEGIN /////////////

echo '<h2>Новости</h2>';
$newsfeed = Newsfeed::getNewsfeed(20);
foreach($newsfeed as $news) { ?>

    <h4><?php echo $news['title']; ?></h4>
    <p><?php echo $news['shortnews']; ?></p>
    <p><i><?php echo $news['date']; ?>, <?php echo $news['author']; ?></i> - <a href="newsfeed.php?edit=<?php echo $news['id']; ?>">[Редактировать]</a> <a style="color: red" href="newsfeed.php?rem=<?php echo $news['id']; ?>">[Удалить]</a></p>

<?php  
} }

// NEWS FEED END /////////////

?>
</div>
<?php
require_once(STAFFINC_DIR.'footer.inc.php');
?>
