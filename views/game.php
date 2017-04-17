<div>
    <h1>Salut <?= $_SESSION['email']; ?> ! Trouve le mot en moins de <?= MAX_TRIALS; ?> coups !</h1>
</div>
<div>
    <p>Le mot à deviner compte <?= $_SESSION['lettersCount']; ?>
        lettres&nbsp;: <?= $_SESSION['replacementString']; ?></p>
</div>
<div>
    <img src="images/pendu<?= $_SESSION['trials']; ?>.gif"
         alt="">
</div>
<div>
    <p>Voici les lettres que tu as déjà essayées&nbsp;: <?= $_SESSION['triedLetters']; ?></p>
</div>
<?php if ($_SESSION['wordFound']
): ?>
    <div>
        <p class="bg-success lead">Bravo&nbsp;! Tu as trouvé le mot
            «&nbsp;<b><?= $_SESSION['word']; ?></b>&nbsp;». <a href="<?= $_SERVER['PHP_SELF']; ?>">Recommence&nbsp;!</a>
        </p>
    </div>
    <?php include('views/partials/_gamesCount.php'); ?>
<?php elseif ($_SESSION['remainingTrials'] == 0): ?>
    <div>
        <p class="bg-danger lead">OOOps&nbsp;! Tu sembles bien mort&nbsp;! Le mot à trouver était
            «&nbsp;<b><?= $_SESSION['word']; ?></b>&nbsp;». <a href="<?= $_SERVER['PHP_SELF']; ?>">Recommence&nbsp;!</a>
        </p>
    </div>
    <?php include('views/partials/_gamesCount.php'); ?>
<?php else: ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>"
          method="post">
        <fieldset>
            <legend>Il te reste <?= $_SESSION['remainingTrials']; ?> essais pour sauver ta peau
            </legend>
            <div>
                <label for="triedLetter">Choisis ta lettre</label>
                <select name="triedLetter"
                        id="triedLetter">
                    <?php foreach ($_SESSION['lettersArray'] as $letter => $status): ?>
                        <?php if ($status): ?>
                            <option value="<?= $letter; ?>"><?= $letter; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="r" value="game">
                <input type="hidden" name="a" value="play">
                <input type="submit"
                       value="essayer cette lettre">
            </div>
        </fieldset>
    </form>
<?php endif; ?>
