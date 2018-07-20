<?php
use yii\helpers\Html;

$authLink = Yii::$app->urlManager->createAbsoluteUrl(['site/auth', 'token' => $token]);
?>
<div class="auth-email">
    <p>Hello</p>

    <p>Follow the link below to authorize your email:</p>

    <p><?= Html::a(Html::encode($authLink), $authLink) ?></p>
</div>
