<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'User Profile');
?>
<div class="site-login">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">You can change your username:</h3>
                </div>

                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'profile-form',

                    ]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <hr>

                    <?= $form->field($model, 'email')->textInput(['readonly' => true]) ?>
                    <?= $form->field($model, 'balance')->textInput(['readonly' => true]) ?>
                    <?= $form->field($model, 'auth_key')->textInput(['readonly' => true]) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>


</div>
