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
    }
    else {
        echo '<p class="nf-alert">You must complete all fields</p>';
    }
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
    <p><i><?php echo $news['date']; ?>, <?php echo $news['author']; ?></i> - <a href="#">[Редактировать]</a> <a style="color: red" href="#">[Удалить]</a></p>

<?php  
} ?>
</div>
<?php
require_once(STAFFINC_DIR.'footer.inc.php');
?>
