<div class="flash-success">
  <?php echo Yii::app()->user->getFlash('profile'); ?>
</div>

<h1>
  <?php echo $full_name; ?>
</h1>
<div>
<?php if ($profile->home_town): ?>
  Home Town: <?php echo $profile->home_town;?><br />
<?php endif; ?>
<?php if ($profile->current_town): ?>
  Current Town: <?php echo $profile->current_town;?><br />
<?php endif; ?>
Date of Birth: <?php echo date('F j, Y', strtotime($profile->date_of_birth));?><br />
</div>
