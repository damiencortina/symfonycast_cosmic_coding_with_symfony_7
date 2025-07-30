<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\StarshipRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\StarshipStatusEnum;

#[AsCommand(
    name: 'app:ship:check-in',
    description: 'Check-in a ship',
)]
class ShipCheckInCommand extends Command
{
    public function __construct(
        private StarshipRepository $starshipRepository,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('slug', InputArgument::REQUIRED, 'The slug of the starship to delete');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $ship = $this->starshipRepository->findOneBySlug($slug);

        if (!$ship) {
            $io->error('Starship not found');
            return Command::FAILURE;
        }

        $io->comment(sprintf('Checking-in starship: %s', $ship->getName()));

        $ship->checkIn();

        $this->entityManager->flush();

        $io->success('Starship checked-in.');

        return Command::SUCCESS;
    }
}
