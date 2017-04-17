<?php
namespace Controllers;

class Game
{
    public $ModelGame = null;
    public $ModelPlayer = null;
    public function __construct() {
        $this->ModelGame = new \Models\Game();
        $this->ModelPlayer = new \Models\Player();
    }

    public function init()
    {
        $_SESSION['email'] = $_SESSION['email']??'';

        return ['view' => 'views/player.php'];
    }

    public function play()
    {
        if ($this->ModelGame->is_letter($_POST['triedLetter'])) {
            $this->ModelGame->increaseAttempt();
            $triedLetter = $_POST['triedLetter'];
        } else {
            header('Location: ' . HARDCODED_URL . 'errors/error_main.php');
            exit;
        }

        $this->ModelGame->updateTriedLettersString($triedLetter);
        $this->ModelGame->updateLettersArray($triedLetter);

        if (!$this->ModelGame->is_letterInWord($triedLetter)) {
            $this->ModelGame->increaseTrials();
        } else {
            $_SESSION['wordFound'] = $this->ModelGame->is_wordFound();
        }

        $this->ModelGame->updateRemainingTrials();

        $gamesCount = $gamesWon = '';
        if ($_SESSION['email']) {
            if ($_SESSION['wordFound'] || !$_SESSION['remainingTrials']) {
                $this->ModelGame->saveGame();
                $gamesCount = $this->ModelPlayer->getGamesCount();
                if ($gamesCount) {
                    $gamesWon = $this->ModelPlayer->getGamesWon();
                }
            }
        }

        $view = 'views/game.php';

        return compact('view', 'gamesCount', 'gamesWon');
    }
}