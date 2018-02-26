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
  }

}
