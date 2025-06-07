<?php

namespace App\Command;

use App\Entity\Game;
use App\Entity\Review;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:add-review',
    description: 'Add review to game.',
)]
class AddReviewCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('game_id', InputArgument::REQUIRED, 'Game identifier.')
            ->addArgument('review_content', InputArgument::REQUIRED, 'Content of the review.')
            ->addArgument('review_rating', InputArgument::REQUIRED, 'Content of the review.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $gameId = $input->getArgument('game_id');

        if ($gameId) {
            /** @var Game $game */
            $game = $this
                ->entityManager
                ->getRepository(Game::class)
                ->findOneBy(['id' => $gameId])
            ;
        } else {
            $io->error('`game_id` is required.');
            return Command::FAILURE;
        }

        $review = new Review();
        $review->setContent($input->getArgument('review_content'));
        $review->setRating($input->getArgument('review_rating'));
        $errors = $this
            ->validator
            ->validate($review);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $io->error($error->getMessage());
            }

            return Command::FAILURE;
        }

        $this->entityManager->persist($review);

        $game->addReview($review);

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
