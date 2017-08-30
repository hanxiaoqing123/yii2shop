<?php

namespace frontend\controllers;
use common\models\Address;
use common\models\User;
use Yii;

class AddressController extends CommonController
{
    //添加收货地址
    public function actionAdd()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $loginname = Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $post['userid'] = $userid;
            $post['address'] = $post['address1'].$post['address2'];
            $data['Address'] = $post;
            $data['createtime'] = time();
            $model = new Address();
            $model->load($data);
            $model->save();
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    //删除收货地址
    public function actionDel()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $loginname = Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        $addressid = Yii::$app->request->get('addressid');
        if (!Address::find()->where('userid = :uid and addressid = :aid', [':uid' => $userid, ':aid' => $addressid])->one()) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        Address::deleteAll('addressid = :aid', [':aid' => $addressid]);
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    //编辑收货地址
    public function actionUpdate()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $loginname = Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model=Address::findOne($post['addid']);
            $post['address'] = $post['address1'].$post['address2'];
            $data['Address'] = $post;
            $model->load($data);
            $model->save();
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

}
