<?php

namespace Social\Commands;

use Social\Entity\Attendance;
use Social\Entity\EmployeeRoles;
use Social\Entity\Employees;
use Social\Social;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * CLI command to install the mini social.
 */
class Install extends Command {


  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('social:install')
      ->setDescription('Install Mini social')
      ->setHelp('Set up the mini social stuff');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $db = Social::getDb();

    $io = new SymfonyStyle($input, $output);
    $io->success('Installating the DB');
    $db->createDb();

    $entities = [new Attendance(), new EmployeeRoles(), new Employees()];

    foreach ($entities as $entity) {
      $entity->createTable();
    }

    $io->success('All the entities exists.');

    $employee = new Employees();
    $role = new EmployeeRoles();
    $objects = json_decode('[{"id":"88bca104-3ee8-43b4-a2a4-d7ed3431635e","name":"Noy"},{"id":"36c2e694-c133-4cb1-9b0f-96f2f2fd3733","name":"Steve"},{"id":"40f6f323-ef2e-409e-b9ca-4e0deb75d8c4","name":"Guy"},{"id":"b9d60115-5f0c-49ed-89af-995dc09ee4f4","name":"Bill"},{"id":"3fc907db-d563-4450-b271-81eac2e8ba2c","name":"David"},{"id":"f24a6f65-a5e2-4277-bd33-90949a7075f2","name":"Tim"}]');
    foreach ($objects as $object) {
      $co = $employee->save((array) $object);

      $role->save(
        [
          "EmployeeId" => $co['id'],
          "role" =>  "something " . microtime(),
          "enabled" => "true",
          "description" => "another thing" . microtime()
        ]
      );
    }
  }

}
