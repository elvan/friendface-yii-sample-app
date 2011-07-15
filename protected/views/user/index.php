<div class="flash-success">
  <?php echo Yii::app()->user->getFlash('user'); ?>
</div>

<table class="profile" summary="Profile information">
<tr>
<td class="main">
<h1>
  <?php echo $profile->first_name; ?>
</h1>
</td>
<td class="sidebar round">
<strong>Name</strong> <?php echo $profile->first_name ?><br />
<strong>URL</strong> <?php echo CHtml::link('user/' . $user->id, Yii::app()->baseUrl . '/user/' . $user->id); ?>
</td>
</tr>
</table>
