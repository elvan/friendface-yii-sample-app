<?php
$this->menu=array(
  array('label' => 'Change Email', 'url' => array('changeEmail')),
  array('label' => 'Change Password', 'url' => array('changePassword')),
);
?>

<div class="flash-success">
  <?php echo Yii::app()->user->getFlash('user'); ?>
</div>

<h1>
  <?php echo $model->profile->first_name; ?>
</h1>
