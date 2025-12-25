<?php
namespace application\controllers;

use application\models\Note;
use ItForFree\SimpleMVC\Config;

class NoteController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'main.php';
    
    public function viewAction()
{
    $id = $_GET['id'] ?? null;

    if (!$id) {
        $this->redirect(Config::get('core.router.class')::link(''));
    }

    $noteModel = new Note();
    $article = $noteModel->getById($id);

    if (!$article) {
        $this->view->addVar('message', 'Статья не найдена');
        $this->view->render('error.php');
        return;
    }

    // Увеличиваем счетчики просмотров категории и подкатегории
    if ($article->categoryId) {
        $Category = new \application\models\Category();
        $Category->incrementViews($article->categoryId);
    }
    
    if ($article->subcategoryId) {
        $Subcategory = new \application\models\Subcategory();
        $Subcategory->incrementViews($article->subcategoryId);
    }

/*    $User = Config::getObject('core.user.class');

    if (!empty($User->userName)) {

        $userModel = new \application\models\UserModel();
        $userId = $userModel->getIdByLogin($User->userName);

        if ($userId) {
            $userModel->logArticleView($id, $userId);
        } else {
            error_log("viewAction: userId not found for login {$User->userName}");
        }
    }*/

    $this->view->addVar('viewNotes', $article);
    $this->view->render('note/view-item.php');
}


}