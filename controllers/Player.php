<?php
namespace Controllers;

class Player
{
    public $ModelGame = null;
    public $ModelPlayer = null;
    public function __construct() {
        $this->ModelGame = new \Models\Game();
        $this->ModelPlayer = new \Models\Player();
    }

    public function register()
    {
        $view = 'views/game.php';
        $_SESSION['errors'] = [];

        if (empty($_POST['email'])) {
            $_SESSION['email'] = '';
            $this->ModelGame->initGame();
        } else {
            $_SESSION['email'] = $_POST['email'];
            if ($this->ModelPlayer->is_validEmail($_POST['email'])) {
                $this->ModelGame->initGame();
            } else {
                $_SESSION['errors'] = [
                    'email' => $_POST['email'] . ' ne semble pas être une adresse email valide',
                ];
                $view = 'views/player.php';
            }
        }

        return compact('view');
    }
}