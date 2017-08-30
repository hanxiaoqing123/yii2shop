<?php

namespace frontend\controllers;
use common\models\Address;
use common\models\Cart;
use common\models\Order;
use common\models\OrderDetail;
use common\models\Product;
use common\models\User;
use Yii;

class OrderController extends CommonController
{
    public function actionIndex()
    {
        $this->layout='layout2';
        return $this->render('index');
    }
    //收银台页面
    public function actionCheck()
    {

        if(\Yii::$app->session['isLogin']!=1){
            return $this->redirect(['member/auth']);
        }
        $orderid=Yii::$app->request->get('orderid');
        $status = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one()->status;
        if ($status != Order::CREATEORDER && $status != Order::CHECKORDER) {
            return $this->redirect(['order/index']);
        }
        $loginname = Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        $addresses =Address::find()->where('userid = :uid', [':uid' => $userid])->asArray()->all();
        $details = OrderDetail::find()->where('orderid = :oid', [':oid' => $orderid])->asArray()->all();
        $data = [];
        foreach($details as $detail) {
            $model = Product::find()->where('productid = :pid' , [':pid' => $detail['productid']])->one();
            $detail['title'] = $model->title;
            $detail['cover'] = $model->cover;
            $data[] = $detail;
        }
        $express = Yii::$app->params['express'];
        $expressPrice = Yii::$app->params['expressPrice'];
        $this->layout='layout1';
        return $this->render('check',['express' => $express, 'expressPrice' => $expressPrice, 'addresses' => $addresses, 'products' => $data]);
    }
    //结算订单
    public function actionAdd()
    {
         if(\Yii::$app->session['isLogin']!=1){
            return $this->redirect(['member/auth']);
         }
         //生成订单，事务处理
        $transaction=\Yii::$app->db->beginTransaction();
         try{
             if(Yii::$app->request->isPost){
                 $post=Yii::$app->request->post();
                 $ordermodel=new Order();
                 $ordermodel->scenario='add';
                 $usermodel = User::find()->where('username = :name or useremail = :email', [':name' => Yii::$app->session['loginname'], ':email' => Yii::$app->session['loginname']])->one();
                 if(!$usermodel){
                     throw new  \Exception();
                 }
                 $userid=$usermodel->userid;
                 $ordermodel->userid=$userid;
                 $ordermodel->status=Order::CREATEORDER;
                 $ordermodel->createtime=time();
                 //保存订单
                 if(!$ordermodel->save()){
                     throw new  \Exception();
                 }
                 $orderid = $ordermodel->getPrimaryKey();
                 //写入订单详情表
                 foreach ($post['OrderDetail'] as $product) {
                     $model = new OrderDetail();
                     $product['orderid'] = $orderid;
                     $product['createtime'] = time();
                     $data['OrderDetail'] = $product;
                     if (!$model->add($data)) {
                         throw new \Exception();
                     }
                     //下单后清除购物车中该商品
                     Cart::deleteAll('productid = :pid', [':pid' => $product['productid']]);
                     //商品相应库存减少
                     Product::updateAllCounters(['num' => -$product['productnum']], 'productid = :pid', [':pid' => $product['productid']]);
                 }
             }
             $transaction->commit();

         }catch (\Exception $e){
                 $transaction->rollBack();
                 return $this->redirect(['cart/index']);
         }
        return $this->redirect(['order/check', 'orderid' => $orderid]);
    }

}
