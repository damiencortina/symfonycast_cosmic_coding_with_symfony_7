<?php

namespace App\Command;

use App\Repository\StarshipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:ship:remove',
    description: 'Delete a Starship',
)]
class ShipRemoveCommand extends Command
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

        $ship = $this->starshipRepository->findOneBy(['slug' => $slug]);

        if (!$ship) {
            $io->error('Starship not found');
            return Command::FAILURE;
        }

        $io->comment(sprintf('Removing starship: %s', $ship->getName()));

        $this->entityManager->remove($ship);
        $this->entityManager->flush();

        $io->success('Starship removed successfully.');

        return Command::SUCCESS;
    }
}
