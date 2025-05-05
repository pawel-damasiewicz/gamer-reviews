<?php

namespace App\Command;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'app:create-game')]
class CreateGameCommand extends Command
{
    public function __construct(
        private GameRepository $gameRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper */
        $helper = $this->getHelper('question');
        $question = new Question('Provide game name:');
        $gameName = $helper->ask($input, $output, $question);

        $game = new Game();
        $game->setName($gameName);

        $this->gameRepository->save($game, true);

        return Command::SUCCESS;
    }
}
