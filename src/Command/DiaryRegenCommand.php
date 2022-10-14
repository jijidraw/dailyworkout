<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'diary:regen',
    description: 'Add a short description for your command',
)]
class DiaryRegenCommand extends Command
{
    private $em;
    private $users;

    public function __construct(EntityManagerInterface $em, UserRepository $users)
    {
        $this->em = $em;
        $this->users = $users->findAll();
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->users;
        foreach ($users as $user) {
            $user->setIsDiary(true);
            $this->em->persist($user);
            $this->em->flush();
        }
        return Command::SUCCESS;
    }
}
