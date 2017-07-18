<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php
$form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => '<div class="field-row">{label}{input}</div>{error}',
    ],
]);
echo $form->field($model,'username')->textInput(['value'=>$model->username]);
echo $form->field($model,'useremail')->textInput(['value'=>$model->useremail]);
echo $form->field($model,'useremail')->textInput(['value'=>$model->useremail]);

?>

<?php
ActiveForm::end();
?>


