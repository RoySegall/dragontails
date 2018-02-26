<?php

namespace Social\Controller;

use Social\ControllerBase;
use Social\Entity\Employees;
use Social\Entity\User;
use Social\Social;

class GetEmployeeList extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function response() {
    $employee = new Employees();

    return array_map(function($item) {
      return $item;
    }, $employee->loadMultiple());
  }

}
