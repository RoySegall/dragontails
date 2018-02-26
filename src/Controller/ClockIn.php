<?php

namespace Social\Controller;

use Social\ControllerBase;
use Social\Entity\Attendance;
use Social\Entity\EmployeeRoles;
use Social\Entity\User;
use Social\Social;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ClockIn extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function response() {
    $attendance = new Attendance();
    $er = new EmployeeRoles();
    $payload = $this->processPayload();

    $filter = [
      'id' => $payload->roleId,
      'EmployeeId' => $payload->employeeId,
      'enabled' => 'true',
    ];

    if (!$results = $er->getTable()->filter($filter)->run($er->getConnection())->toArray()) {
      $this->badRequest('There is no user with that role or it might be in active');
    }

    $object = $attendance->save((array)$payload + ['actionTime' => date("m/D/y H:i", time())]);

    unset($object['time'], $object['id']);

    return $object;
  }

}
