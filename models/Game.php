<?php
namespace Models;

class Game extends Model
{

    public function updateTriedLettersString($letter)
    {
        $_SESSION['triedLetters'] .= $letter;
    }

    public function updateLettersArray($letter)
    {
        $_SESSION['lettersArray'][$letter] = false;
    }

    public function is_letter($userInput)
    {
        return (ctype_alpha($userInput) && strlen($userInput) === 1);
    }

    public function increaseAttempt()
    {
        $_SESSION['attempts']++;
    }

    public function increaseTrials()
    {
        $_SESSION['trials']++;
    }

    public function is_letterInWord($letter)
    {
        $letterFound = false;
        for ($i = 0; $i < $_SESSION['lettersCount']; $i++) {
            $l = substr($_SESSION['word'], $i, 1);
            if ($letter === $l) {
                $letterFound = true;
                $this->updateReplacementString($letter, $i, 1);
            }
        }

        return $letterFound;
    }

    public function updateReplacementString($letter, $position, $length)
    {
        $_SESSION['replacementString'] = substr_replace($_SESSION['replacementString'], $letter, $position, $length);
    }

    public function updateRemainingTrials()
    {
        $_SESSION['remainingTrials'] = MAX_TRIALS - $_SESSION['trials'];
    }

    public function is_wordFound()
    {
        return $_SESSION['word'] === $_SESSION['replacementString'];
    }

    public function getReplacementString($lettersCount)
    {
        return str_pad('', $lettersCount, REPLACEMENT_CHAR);
    }

    public function initGame()
    {
        $_SESSION['wordFound'] = false;
        $_SESSION['remainingTrials'] = MAX_TRIALS;
        $_SESSION['trials'] = 0;
        $_SESSION['triedLetters'] = '';
        $_SESSION['lettersArray'] = $this->getLettersArray();
        $_SESSION['word'] = $this->getWord();
        $_SESSION['lettersCount'] = strlen($_SESSION['word']);
        $_SESSION['replacementString'] = $this->getReplacementString($_SESSION['lettersCount']);
        $_SESSION['attempts'] = 0;
    }

    public function saveGame()
    {
        $pdo = $this->connectDB();
        if ($pdo) {
            $sql = 'INSERT INTO pendu.games(`username`,`trials`,`word`,`attempts`) VALUES (:email,:trials,:word,:attempts)';
            try {
                $pdoSt = $pdo->prepare($sql);
                $pdoSt->execute([
                    ':email' => $_SESSION['email'],
                    ':trials' => $_SESSION['trials'],
                    ':word' => $_SESSION['word'],
                    ':attempts' => $_SESSION['attempts']
                ]);
            } catch (\PDOException $exception) {
                die('Quelque chose a posé problème lors de l’enregistrement');
            }
        } else {
            die('Quelque chose a posé problème lors de l’enregistrement');
        }
    }

    public function getLettersArray()
    {
        return [
            'a' => true,
            'b' => true,
            'c' => true,
            'd' => true,
            'e' => true,
            'f' => true,
            'g' => true,
            'h' => true,
            'i' => true,
            'j' => true,
            'k' => true,
            'l' => true,
            'm' => true,
            'n' => true,
            'o' => true,
            'p' => true,
            'q' => true,
            'r' => true,
            's' => true,
            't' => true,
            'u' => true,
            'v' => true,
            'w' => true,
            'x' => true,
            'y' => true,
            'z' => true,
        ];
    }

    public function getWordFromFile()
    {
        $wordsArray
            = @file(BACKUP_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        if ($wordsArray) {

            return strtolower($wordsArray[rand(0, count($wordsArray) - 1)]);
        } else {
            header('Location: ' . HARDCODED_URL . 'errors/error_main.php');
            exit;
        }
    }

    function getWord()
    {
        $pdo = $this->connectDB();
        if ($pdo) {
            $sql = 'SELECT word FROM pendu.words ORDER BY RAND()';
            try {
                $pdoSt = $pdo->query($sql);

                return strtolower($pdoSt->fetchColumn());
            } catch (\PDOException $exception) {

                return $this->getWordFromFile();
            }
        } else {

            return $this->getWordFromFile();
        }
    }
}
