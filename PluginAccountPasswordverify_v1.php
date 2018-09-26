<?php
class PluginAccountPasswordverify_v1{
  private $settings = null;
  function __construct() {
    wfPlugin::enable('form/form_v1');
    wfPlugin::enable('wf/yml');
    wfPlugin::enable('wf/array');
    wfPlugin::includeonce('wf/yml');
    wfPlugin::includeonce('wf/array');
    $this->settings = new PluginWfArray(wfPlugin::getModuleSettings('account/passwordverify_v1'));
    if(!$this->settings->get('seconds')){
      $this->settings->set('seconds', 30);
    }
  }
  /**
   * Including js in head document.
   */
  public function widget_include(){
    $element = new PluginWfYml('/plugin/account/passwordverify_v1/element/include.yml');
    wfDocument::renderElement($element->get());
  }
  /**
   * Widget to demonstrate how it works.
   */
  public function widget_demo(){
    $element = new PluginWfYml('/plugin/account/passwordverify_v1/element/demo.yml');
    $time = $this->getTime();
    $seconds = $this->getSeconds();
    if($this->validateTime()){
      $validate_time = 'True';
    }else{
      $validate_time = 'False';
    }
    $element->setByTag(array('time' => $time, 'seconds' => $seconds, 'validate_time' => $validate_time));
    wfDocument::renderElement($element->get());
  }
  /**
   * Call this page in a bootstrap modal.
   */
  public function page_verify(){
    $element = new PluginWfYml('/plugin/account/passwordverify_v1/element/verify.yml');
    wfDocument::renderElement($element->get());
  }
  /**
   * This should be called from the form.
   */
  public function page_verify_capture(){
    $element = new PluginWfYml('/plugin/account/passwordverify_v1/element/verify_capture.yml');
    wfDocument::renderElement($element->get());
  }
  /**
   * Form capture method.
   */
  public function form_capture_verify($form){
    $form = new PluginWfArray($form);
    $user = wfUser::getSession();
    $sql = "select password from account where id='".$user->get('user_id')."';";
    $rs = new PluginWfArray($this->runSQL($sql)->get('0'));
    $password = $form->get('items/password/post_value');
    $result = wfCrypt::isValid($password, $rs->get('password'));
    if($result){
      $this->setTime();
    }
    return array("PluginAccountPasswordverify_v1.verify_capture(".$result.");");
  }
  private function setTime(){
    $_SESSION = wfArray::set($_SESSION, 'plugin/account/passwordverify_v1/time', date('Y-m-d H:i:s'));
  }
  private function unsetTime(){
    $_SESSION = wfArray::set($_SESSION, 'plugin/account/passwordverify_v1/time', null);
  }
  private function getTime(){
    return wfArray::get($_SESSION, 'plugin/account/passwordverify_v1/time');
  }
  private function getSeconds(){
    $time = $this->getTime();
    wfPlugin::includeonce('calc/date_v1');
    $calc = new PluginCalcDate_v1();
    return $calc->calcSeconds($time);
  }
  /**
   * Validate session time parameter.
   * This should return true if called directly after verifying password.
   * This is to be used of other plugins to check if user has enter correct password.
   * Return true only once for each verifying.
   * @return boolean
   */
  public function validateTime(){
    $return = false;
    if($this->getTime()){
      $seconds = $this->getSeconds();
      if($seconds > $this->settings->get('seconds')){
        $return = false;
      }else{
        $return = true;
      }
    }else{
      $return = false;
    }
    $this->unsetTime();
    return $return;
  }
  /**
   * SQL.
   */
  private function runSQL($sql){
    wfPlugin::includeonce('wf/mysql');
    $mysql = new PluginWfMysql();
    $mysql->open($this->settings->get('mysql'));
    $test = $mysql->runSql($sql);
    return new PluginWfArray($test['data']);
  }
}
