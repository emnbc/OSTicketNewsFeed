<?php 
require('staff.inc.php');
require_once(INCLUDE_DIR.'class.faq.php');
require_once(INCLUDE_DIR.'class.newsfeed.php');
require_once(STAFFINC_DIR.'header.inc.php'); 
?>

<div class="newsfeed-staff">

<?php 

if(!empty($_POST['nftoken'])) {
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

?>
<form action="" method="post">
<?php csrf_token(); ?>
<input type="hidden" name="nftoken" value="true">
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
echo '<h2>Новости</h2>';
$newsfeed = Newsfeed::getNewsfeed(20);
foreach($newsfeed as $news) { ?>

    <h4><?php echo $news['title']; ?></h4>
    <p><?php echo $news['shortnews']; ?></p>
    <p><i><?php echo $news['date']; ?>, <?php echo $news['author']; ?></i> - <a href="#">[Редактировать]</a> <a style="color: red" href="newsfeed.php?rem=<?php echo $news['id']; ?>">[Удалить]</a></p>

<?php  
} ?>
</div>
<?php
require_once(STAFFINC_DIR.'footer.inc.php');
?>
