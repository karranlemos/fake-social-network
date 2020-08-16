<?php 

class Template {

  private $template_path;
  private $data;

  public function __construct($template_path, $data=null) {
    $this->template_path = $template_path;
    $this->data = [];
    if (is_array($data)) {
      foreach ($data as $key => $value)
        $this->set($key, $value);
    }
  }

  public function get($key) {
    return $this->data[$key];
  }

  public function set($key, $value) {
    $this->data[$key] = $value;
  }

  public function get_page() {
    $data = $this->data;
    ob_start();

    include $this->template_path;

    return ob_get_clean();
  }
}