<?php
/**
 * @name IndexController
 * @author gunblues
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */

class IndexController extends BaseController 
{

    public function indexAction() {

        if ($this->mobileIndex === 1) {
            $stock = "http://stockm.gunblues.com";
        }
        else {
            $stock = "http://stock.gunblues.com";
        }

        $this->getView()->stock= $stock;
        $this->renderPage('index', 'main');

        return false;
	}
}
