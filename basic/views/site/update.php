<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'login-form', 'options' =>['class' => 'horizontal'], 'method' => 'post']);

?>
//���� �����, ����� � �� �������� � ������ ���� 'name'
<?= $form->field($image, 'name')->textInput()?>

<?= $form->field($image, 'caption')->textInput()?>

<?= Html::submitButton('Save', ['class' => 'btn btn-primary'])?>

<?php ActiveForm::end() ?>
