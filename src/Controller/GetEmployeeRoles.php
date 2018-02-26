<?php

namespace Social\Controller;

use Social\ControllerBase;
use Social\Entity\EmployeeRoles;
use Social\Entity\User;
use Social\Social;

class GetEmployeeRoles extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function response() {
    $er = new EmployeeRoles();

    $filter = ['enabled' => 'true'];

    if ($this->request->query->get('employeeId')) {
      $filter['EmployeeId'] = $this->request->query->get('employeeId');
    }

    $results = $er->getTable()->filter($filter)->run($er->getConnection())->toArray();

    return $results;
  }

}
