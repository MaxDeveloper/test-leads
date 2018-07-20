<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
?>
<div class="site-login">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please fill out email to get auth link:</h3>
                </div>

                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',

                    ]); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Get auth link email', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
