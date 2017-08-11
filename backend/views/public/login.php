<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
    <title>慕课商城 - 后台管理</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- bootstrap -->
    <link href="shopassets/admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="shopassets/admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="shopassets/admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="shopassets/admin/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="shopassets/admin/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="shopassets/admin/css/icons.css" />

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="shopassets/admin/css/lib/font-awesome.css" />

    <!-- this page specific styles -->
    <link rel="stylesheet" href="shopassets/admin/css/compiled/signin.css" type="text/css" media="screen" />

    <!-- open sans font -->

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>


<div class="row-fluid login-wrapper">
    <a class="brand" href="<?php echo yii\helpers\Url::to(['/index/index']) ?>"></a>
    <!----------------------------创建表单---------------------------->
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '{error}{input}',
        ],
    ]); ?>
    <div class="span4 box">
        <div class="content-wrap">
            <h6>慕课商城 - 后台管理</h6>
            <?php echo $form->field($model, 'adminuser')->textInput(["class" => "span12", "placeholder" => "管理员账号"]); ?>
            <?php echo $form->field($model, 'adminpass')->passwordInput(["class" => "span12", "placeholder" => "管理员密码"]); ?>
            <a href="<?php echo yii\helpers\Url::to(['public/seekpassword']); ?>" class="forgot">忘记密码?</a>
            <?php echo $form->field($model, 'rememberMe')->checkbox([
                'id' => 'remember-me',
                'template' => '<div class="remember">{input}<label for="remember-me">记住我</label></div>',
            ]); ?>
            <?php echo Html::submitButton('登录', ["class" => "btn-glow primary login"]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="span4 no-account">
        <p>没有账户？</p>
        <a href="signup.html">注册</a>
    </div>
</div>

<!-- scripts -->
<script src="shopassets/admin/js/jquery-latest.js"></script>
<script src="shopassets/admin/js/bootstrap.min.js"></script>
<script src="shopassets/admin/js/theme.js"></script>

<!-- pre load bg imgs -->
<script type="text/javascript">
    $(function () {
        // bg switcher
        var $btns = $(".bg-switch .bg");
        $btns.click(function (e) {
            e.preventDefault();
            $btns.removeClass("active");
            $(this).addClass("active");
            var bg = $(this).data("img");

            $("html").css("background-image", "url('img/bgs/" + bg + "')");
        });

    });
</script>

</body>
</html>