<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'/post/_view',
  'template'=>"{items}\n{pager}",
)); ?>
