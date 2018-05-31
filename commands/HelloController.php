<?php
/**
 * 管理员权限
 */

namespace app\commands;

use Yii;

class HelloController extends \yii\web\Controller
{
    /**
     * 访问前
     * @param type $action
     */
    public function beforeAction($action) {
        
        if( Yii::$app->user->isGuest && !in_array(strtolower($action->id), ["login"])){
            $this->redirect(Yii::$app->urlManager->createUrl([""]));
            Yii::$app->end();
        }
        $identity = Yii::$app->user->getIdentity();
           
        if( !in_array($identity->role, ["admin", "salary"]) && !in_array(strtolower($action->id), ["logout", "changepwd"])){
            return Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl("site/nopermission"));
        }
        return $action;
    }
    
    static function packJson($data){
        exit(json_encode($data));
        Yii::$app->end();
    }
}
