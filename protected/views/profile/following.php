<h2>Following</h2>

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'_following',
  'template'=>"{items}\n{pager}",
)); ?>
