<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleAsset\SimpleAssetManager;
use application\assets\BootstrapAsset;

BootstrapAsset::add();
SimpleAssetManager::printCss();
$User = Config::getObject('core.user.class');
?>
<!DOCTYPE html>
<html>
    <?php include('includes/main/admin/head.php'); ?>
    <body> 
        <?php include('includes/admin-main/nav.php'); ?>
        <div class="container">
            <?= $CONTENT_DATA ?>
        </div>
        <?php include('includes/main/admin/footer.php'); ?>
    </body>
</html>

