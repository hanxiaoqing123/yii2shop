<?php

namespace backend\controllers;
use Yii;
use common\models\Admin;

class PublicController extends \yii\web\Controller
{
    public function actionLogin()
    {
       // session_start();
       // var_dump($_SESSION);
       $this->layout=false;
       //如果已经登录 直接跳转到后台首页
       if(Yii::$app->session['admin']['isLogin']){
            $this->redirect(['default/index']);
       }
       $model=new Admin;
       if(Yii::$app->request->isPost){
          $data=Yii::$app->request->post();
          if($model->login($data)){
             $this->redirect(['default/index']);
             Yii::$app->end();
          }
       }
       return $this->render('login',['model'=>$model]);
    }

    public function actionLogout()
    {
        Yii::$app->session->removeAll();
        if(!isset(Yii::$app->session['admin']['isLogin'])){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        $this->goBack();
    }

}
