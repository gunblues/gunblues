<?php
/**
 * @name Base
 * @author gunblues
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */

class BaseController extends Yaf_Controller_Abstract 
{
        
    public $cc;
    public $mobile;
    public $hasAd;
    public $mobileIndex = 0;
    public $para = "";

    public static $allow_locale = array("tw", "us");

    public function init() { //{{{

        $this->mobile = filter_var($this->getRequest()->getQuery('mobile'), FILTER_VALIDATE_INT);

        if (empty($this->mobile)) {
            $this->mobile = filter_var($this->getRequest()->getQuery('m'), FILTER_VALIDATE_INT);
        }

        $mobile_detect = MyUtil::mobileDetect();
        
        if(is_array($mobile_detect)) {
            $this->mobile = 1;
        }

        //always mobile
        if ($this->mobile == 1) {
            $this->mobile = 'Mobile';
            $this->mobileIndex = 1;
        }
        else {
            $this->mobile = 'Mobile';
        }
       
        $this->hasAd = filter_var($this->getRequest()->getQuery('ap'), FILTER_VALIDATE_INT);

        ($this->hasAd == 1) ? $this->hasAd = 'no' : $this->hasAd = 'yes';
 
        $cc = filter_var($this->getRequest()->getQuery('cc'), FILTER_SANITIZE_STRING);

        if ($cc === "") {
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $lang = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
                $cc = substr($lang[0], -2);
            }
        }

        $cc = strtolower($cc);
        
        if(!in_array($cc, self::$allow_locale)) {
            $cc = "tw";
        }

        if (!defined("SITE_NAME")) {
            Yaf_loader::import(dirname(__FILE__) . "/../locale/$cc/trans.php");
        }

        $this->cc = $cc;

        $this->getView()->cc = $this->cc;

        $this->para = "?cc=" . $this->cc;

        if ($this->mobileIndex === 1) {
            $this->para .= "&m=1";
        }

        if ($this->hasAd === 'yes') {
            $this->getView()->ap = false;
        }
        else {
            $this->para .= "&ap=1";
            $this->getView()->ap = true;
        }

        $this->getView()->para = $this->para;

    } //}}}

    public function renderPage($controller = "", $action = "") { //{{{
        
        if ($controller === "") {
            $controller = strtolower($this->getRequest()->getControllerName());
        }

        if ($action === "") {
            $action = $this->getRequest()->getActionName();
        }

        $this->getView()->action = $action;

        $pjax = "/$controller/$action";
        $template = $this->getViewpath() . $pjax . $this->mobile . ".phtml";

        if (file_exists($template) && !isset($this->getView()->mainContentFile)) {
            $this->getView()->mainContentFile = $template;
        }

        if(isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
            $this->display("..$pjax");
        }
        else {
            $this->display("../index/index" . $this->mobile);
        }

    } //}}}
}
