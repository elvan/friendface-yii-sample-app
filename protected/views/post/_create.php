<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
  'id'=>'post-form',
  'enableAjaxValidation'=>false,
)); ?>

  <div class="field">
    <label for="Post_content">Share something</label>
    <?php echo $form->textArea($post,'content',array('cols'=>60, 'rows' => 4, 'maxlength'=>1024)); ?>
    <?php echo $form->hiddenField($post,'recipient_id'); ?>
  </div>

  <div class="actions">
    <?php echo CHtml::ajaxSubmitButton('Share', '', array(
      'update' => 'label[for=Post_content]',
    )); ?>
  </div>

<?php $this->endWidget(); ?>

</div>
