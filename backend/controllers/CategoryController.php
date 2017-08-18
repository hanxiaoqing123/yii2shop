<?php

namespace backend\controllers;

use common\models\Category;
use Yii;

class CategoryController extends \yii\web\Controller
{
    public function actionAdd()
    {
        $this->layout='layout1';
        $model=new Category();
        $list=$model->getOptions();
        if(Yii::$app->request->isPost){
            $data=Yii::$app->request->post();
            if($model->add($data)){
                Yii::$app->session->setFlash('info','添加成功');
            }
        }
        return $this->render('add',['list'=>$list,'model'=>$model]);
    }

    public function actionList()
    {
        $this->layout='layout1';
        $model=new Category();
        $cates=$model->getTreeList();
        return $this->render('cates',['cates'=>$cates]);
    }

    public function actionMod()
    {
        $this->layout='layout1';
        $cateid=Yii::$app->request->get("cateid");
        $model=Category::findOne($cateid);
        $list=$model->getOptions();
        if(Yii::$app->request->isPost){
            $data=Yii::$app->request->post();
            if($model->load($data) && $model->save()){
                Yii::$app->session->setFlash('info','修改成功');
            }
        }
        return $this->render('add',['list'=>$list,'model'=>$model]);
    }

    public function actionDel()
    {
        try{
            //参数错误
            $cateid=Yii::$app->request->get("cateid");
            if(empty($cateid)){
                throw  new \Exception("参数错误");
            }
            // 该分类下有子类，不允许删除
            $res=Category::find()->where(['parentid'=>$cateid])->all();
            if($res){
                throw  new \Exception("该分类下有子类，不允许删除");
            }
            //删除失败
            if(!Category::deleteAll(['cateid'=>$cateid])){
                throw  new \Exception("删除失败");
            }

        }catch (\Exception $e){
            Yii::$app->session->setFlash('info',$e->getMessage());
        }
        return $this->redirect(['category/list']);

    }
}
