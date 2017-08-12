<?php

namespace backend\controllers;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout='layout1';
        return $this->render('index');
    }

}
