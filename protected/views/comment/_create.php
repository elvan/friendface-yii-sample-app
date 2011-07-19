<div class="form">
  <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comment-form',
    'enableAjaxValidation'=>false,
  )); ?>

  <div class="row">
    <?php echo $form->textArea($comment,'content',array('rows'=>3, 'cols'=>80)); ?>
  </div>

  <div class="row buttons">
    <?php echo CHtml::submitButton('Submit'); ?>
  </div>

<?php $this->endWidget(); ?>

</div>
