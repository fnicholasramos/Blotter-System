<?php
session_start();

if (isset($_SESSION['loginAttempts']) && isset($_SESSION['lastFailedAttemptTime'])) {
    $maxAttempts = 3;
    $delaySeconds = 30;

    if ($_SESSION['loginAttempts'] >= $maxAttempts) {
        $timeElapsed = time() - $_SESSION['lastFailedAttemptTime'];
        $remainingDelay = max(0, $delaySeconds - $timeElapsed);
        echo json_encode(['remainingDelay' => $remainingDelay]);
    } else {
        echo json_encode(['remainingDelay' => 0]);
    }
} else {
    echo json_encode(['remainingDelay' => 0]);
}
?>
