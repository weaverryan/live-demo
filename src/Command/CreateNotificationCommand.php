<?php

namespace App\Command;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateNotificationCommand extends Command
{
    protected static $defaultName = 'create:notification';
    protected static $defaultDescription = 'Add a short description for your command';

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            ->addArgument('message', InputArgument::REQUIRED, 'Notification message')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $notification = new Notification();
        $notification->setMessage($input->getArgument('message'));

        $this->em->persist($notification);
        $this->em->flush();

        $io->success('Added notification!');

        return Command::SUCCESS;
    }
}
