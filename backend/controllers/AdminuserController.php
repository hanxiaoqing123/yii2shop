<?php

namespace backend\controllers;

class AdminuserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout='layout1';
        return $this->render('index');
    }

}
