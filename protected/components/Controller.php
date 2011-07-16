<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {
  /**
   * @var string the default layout for the controller view. Defaults to '//layouts/column1',
   * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
   */
  public $layout='//layouts/column1';
  /**
   * @var array context menu items. This property will be assigned to {@link CMenu::items}.
   */
  public $menu=array();
  /**
   * @var array the breadcrumbs of the current page. The value of this property will
   * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
   * for more details on how to specify this property.
   */
  public $breadcrumbs=array();
  public $pageTitle = '';

  protected $_model;

  public function actions() {
    return array(
      'captcha'=>array(
        'class'=>'CCaptchaAction',
        'backColor'=>0xFFFFFF,
        'fixedVerifyCode' => YII_DEBUG ? 'abcdef' : null,
      ),
    );
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   */
  public function loadModel() {
    if($this->_model===null) {
      if(isset($_GET['id'])) {
        $this->_model=User::model()->findbyPk($_GET['id']);
      }
      if($this->_model===null) {
        throw new CHttpException(404,'The requested page does not exist.');
      }
    }
    return $this->_model;
  }
}
