<div>
  Name: <?php echo $profile->fullName; ?><br />
  <?php if ($profile->home_town): ?>
    Home Town: <?php echo $profile->home_town;?><br />
  <?php endif; ?>
  <?php if ($profile->current_town): ?>
    Current Town: <?php echo $profile->current_town;?><br />
  <?php endif; ?>
  Date of Birth: <?php echo date('F j, Y', strtotime($profile->date_of_birth));?><br />
</div>
<div class="clear line"></div>
<div>
  Followers: <?php echo CHtml::link($profile->followersCount, Yii::app()->baseUrl . '/profile/' . $profile->id . '/followers'); ?><br />
  Following: <?php echo CHtml::link($profile->followingCount, Yii::app()->baseUrl . '/profile/' . $profile->id . '/following'); ?>
</div>
