<?php

abstract class Controller
{

  protected function view($view, $data = [], $layout = 'admin')
  {

    if (!empty($data) && is_array($data)) {
      extract($data);
    }

    $viewDir = __DIR__ . '/../views/';
    require_once $viewDir . 'layouts/' . $layout . '_header.php';
    require_once $viewDir . $view . '.php';
    require_once $viewDir . 'layouts/' . $layout . '_footer.php';
  }

  protected function redirect($path)
  {
    header("Location: " . url($path));
  }
}