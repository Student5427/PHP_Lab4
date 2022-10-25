<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'login-form', 'options' =>['class' => 'horizontal'], 'method' => 'post']);

?>
//Поле формы, чтобы в БД поменять у записи поле 'name'
<?= $form->field($image, 'name')->textInput()?>

<?= $form->field($image, 'caption')->textInput()?>

<?= Html::submitButton('Save', ['class' => 'btn btn-primary'])?>

<?php ActiveForm::end() ?>
