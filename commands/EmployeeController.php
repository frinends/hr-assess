<?php
/**
 * 员工权限
 */

namespace app\commands;

use Yii;

class EmployeeController extends \yii\web\Controller
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
        return $action;
    
    }
    
    static function packJson($data){
        exit(json_encode($data));
        Yii::$app->end();
    }
}
