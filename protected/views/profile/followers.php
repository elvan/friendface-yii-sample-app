<h2>Followers</h2>

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'_followers',
  'template'=>"{items}\n{pager}",
)); ?>
