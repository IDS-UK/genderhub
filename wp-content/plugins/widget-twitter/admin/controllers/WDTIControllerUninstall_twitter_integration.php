<?php

class WDTIControllerUninstall_twitter_integration {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function execute() {
    $task = ((isset($_POST['task'])) ? esc_html(stripslashes($_POST['task'])) : '');
    if (method_exists($this, $task)) {
      $this->$task();
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_WDTI_DIR . "/admin/models/WDTIModelUninstall_twitter_integration.php";
    $model = new WDTIModelUninstall_twitter_integration();

    require_once WD_WDTI_DIR . "/admin/views/WDTIViewUninstall_twitter_integration.php";
    $view = new WDTIViewUninstall_twitter_integration($model);
    $view->display();
  }

  public function uninstall() {
    require_once WD_WDTI_DIR . "/admin/models/WDTIModelUninstall_twitter_integration.php";
    $model = new WDTIModelUninstall_twitter_integration();

    require_once WD_WDTI_DIR . "/admin/views/WDTIViewUninstall_twitter_integration.php";
    $view = new WDTIViewUninstall_twitter_integration($model);
    $view->uninstall();
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}