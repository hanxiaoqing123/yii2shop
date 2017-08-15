<?php

namespace backend\controllers;
use common\models\Admin;
use Yii;
use yii\data\Pagination;

class ManageController extends \yii\web\Controller
{
    public function actionMailchangepass()
    {
        $this->layout=false;
        $time=Yii::$app->request->get('timestamp');
        $adminuser=Yii::$app->request->get('adminuser');
        $token=Yii::$app->request->get('token');
        $model=new Admin();
        $myToken=$model->createToken($adminuser,$time);
        if(($token!=$myToken)  ||  (time()-$time>300)){
           $this->redirect(['public/login']);
           Yii::$app->end();
        }
        if(Yii::$app->request->isPost){
            $post=Yii::$app->request->post();
            if($model->changePass($post)){
                Yii::$app->session->setFlash('info','密码修改成功');
            }
        }
        $model->adminuser=$adminuser;
        return $this->render('mailchangepass',['model'=>$model]);
    }

    public function actionManagers()
    {
        $this->layout='layout1';
        //后台管理员列表分页
        $model=Admin::find();
        $count=$model->count();
        $pageSize=Yii::$app->params['pageSize']['manage'];
        $pager=new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $managers=$model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('managers',['managers'=>$managers,'pager'=>$pager]);
    }

    public function actionDel()
    {
        $adminid = (int)Yii::$app->request->get("adminid");
        if (empty($adminid) || $adminid == 1) {
            $this->redirect(['manage/managers']);
            return false;
        }
        $model = new Admin;
        if ($model->deleteAll('adminid = :id', [':id' => $adminid])) {
            Yii::$app->session->setFlash('info', '删除成功');
            $this->redirect(['manage/managers']);
        }
    }
    /*
     * 添加管理员用户
     * */ 
    public function actionReg()
    {
        $this->layout='layout1';
        $model=new Admin;
        if(Yii::$app->request->isPost){
            $data=Yii::$app->request->post();
            if($model->reg($data)){
                Yii::$app->session->setFlash('info', '添加成功');
            }else{
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }
        $model->adminpass='';
        $model->repass='';
        return $this->render('reg',['model'=>$model]);
    }

    public function actionChangeemail()
    {
        $this->layout='layout1';
        $model=Admin::find()->where('adminuser=:user',[':user'=>Yii::$app->session['admin']['adminuser']])->one();
        if(Yii::$app->request->isPost){
            $data=Yii::$app->request->post();
            if($model->changeEmail($data)){
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass="";
        return $this->render('changeemail',['model'=>$model]);

    }

    public function actionChangepass()
    {
        $this->layout='layout1';
        $model=Admin::find()->where('adminuser=:user',[':user'=>Yii::$app->session['admin']['adminuser']])->one();
        if(Yii::$app->request->isPost){
            $data=Yii::$app->request->post();
            if($model->changePass($data)){
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass="";
        $model->repass="";
        return $this->render('changepass',['model'=>$model]);
    }
}
