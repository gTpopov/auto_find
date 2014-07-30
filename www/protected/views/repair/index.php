<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/repair/default.css');

$this->pageTitle = Yii::app()->name.' | '.Yii::t('repairPage','Recover password');
?>


<script type="text/javascript"> $(function(){ $(".btn").click(function(){ $(this).val('<?php echo Yii::t('repairPage','Waiting...'); ?>'); }); }); </script>


<h3><?php echo Yii::t('repairPage','Recover password'); ?></h3>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'enter-form',
    'action'=>Yii::app()->createUrl('//repair/index'),
    'enableAjaxValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    )
)); ?>

<?php if(Yii::app()->user->hasFlash('success-repair')): ?>
    <div class="alert text-center alert-success">
        <p class="alert-message"><?php echo Yii::app()->user->getFlash('success-repair'); ?></p>
        <span aria-hidden="true" data-dismiss="alert" class="close alert-close">×</span>
    </div>

<?php elseif(Yii::app()->user->hasFlash('failed-repair')): ?>
    <div class="alert text-center alert-error">
        <p class="alert-message"><?php echo Yii::app()->user->getFlash('failed-repair'); ?></p>
        <span aria-hidden="true" data-dismiss="alert" class="close alert-close">×</span>
    </div>
<?php endif; ?>

<div class="row">
    <?php echo $form->labelEx($model,'email'); ?>
    <?php echo $form->textField($model,'email',array('class'=>'field','placeholder'=>'email@example.com')); ?>
    <?php echo $form->error($model,'email'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton(Yii::t('repairPage','Sign in'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>
<img src="/images/shadow-bottom-img.png" width="320" id="shadow">