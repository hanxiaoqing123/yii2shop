<?php

namespace backend\controllers;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\User;
use common\models\Profile;
use Yii;

class UserController extends Controller
{
    public function actionUsers()
    {
        $model = User::find()->joinWith('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        $this->layout = "layout1";
        return $this->render('users', ['users' => $users, 'pager' => $pager]);
    }

    public function actionReg()
    {
        $this->layout = "layout1";
        $model = new User;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }
        $model->userpass = '';
        $model->repass = '';
        return $this->render("reg", ['model' => $model]);
    }

    public function actionDel()
    {
       //保持一致性：先删除profile表再删除user表，其中采用事务处理
        try{
            $userid=(int)Yii::$app->request->get("userid");
            if(!$userid){
                throw new \Exception();
            }
            //开启事务
            $trans=Yii::$app->db->beginTransaction();
            //删除profile表
            $pObj=Profile::findOne(['userid'=>$userid]);
            if($pObj){
                $res=Profile::deleteAll(['userid'=>$userid]);
                if(!$res){
                    throw new \Exception();
                }
            }
            //删除user表
            $res1=User::deleteAll(['userid'=>$userid]);
            if(!$res1){
                throw new \Exception();
            }

            //提交
            $trans->commit();
        }catch (\Exception $e){
           if(Yii::$app->db->getTransaction()){
               $trans->rollBack();
           }
        }
        $this->redirect(['user/users']);
    }

}
