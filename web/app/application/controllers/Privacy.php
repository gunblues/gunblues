<?php
/**
 * @name PrivacyController
 * @author gunblues
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */

class PrivacyController extends BaseController 
{

    public function indexAction() {
         $this->display("../privacy/index" . $this->mobile);

        return false;
	}
}
