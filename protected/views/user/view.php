<?php
$this->menu=array(
  array('label' => 'Change Email', 'url' => array('changeEmail')),
  array('label' => 'Change Password', 'url' => array('changePassword')),
);
?>

<?php if (Yii::app()->user->getFlash('user')): ?>
  <div class="flash-success">
    <?php echo Yii::app()->user->getFlash('user'); ?>
  </div>
<?php endif; ?>

<h2>
  <?php echo $user->profile->fullName; ?>
</h2>
<div class="row">Email: <?php echo $user->email; ?></div>
<div class="row">Password: (hidden)</div>
