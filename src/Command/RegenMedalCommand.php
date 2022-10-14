<?php

namespace App\Command;

use App\Repository\UserMedalsRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'regen:medal',
    description: 'Add a short description for your command',
)]
class RegenMedalCommand extends Command
{
    private $em;
    private $medals;
    public function __construct(EntityManagerInterface $em, UserMedalsRepository $medals)
    {
        $this->em = $em;
        $this->medals = $medals->findAll();
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->em;
        $medals = $this->medals;
        foreach ($medals as $medal) {
            $medal->setGold(true)->setSilver(true)->setBronze(true);
            $em->persist($medal);
            $em->flush();
        }

        return Command::SUCCESS;
    }
}
