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
echo $form->field($model,'username')->textInput();
echo $form->field($model,'useremail')->textInput();
echo $form->field($model->profile,'truename')->textInput();


?>

<?php
ActiveForm::end();
?>


