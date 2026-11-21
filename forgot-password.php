<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require __DIR__ . '/includes/config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot Anti-Spam Check
    if (!empty($_POST['website_hp'])) {
        exit("Spam detected.");
    }

    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = "කරුණාකර ඔබගේ ඊමේල් ලිපිනය ඇතුළත් කරන්න.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "වලංගු නොවන ඊමේල් ලිපිනයකි.";
    } else {
        // Check if user exists in database
        $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userObj = $stmt->fetch();

        if ($userObj) {
            // 1. Unique Token එකක් සහ Expiry (විනාඩි 30ක්) සකස් කිරීම
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

            // 2. Database එකට Token එක save කිරීම
            $updateStmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
            $updateStmt->execute([$token, $expiry, $email]);

            // 3. Reset Link එක සකස් කිරීම (current domain එකෙන්ම, hardcoded නොවී)
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $resetLink = $scheme . $_SERVER['HTTP_HOST'] . "/reset-password.php?token=" . $token;

            // 4. ඊමේල් එක යැවීම
            $subject = "Password Reset - Japan Driving License Practice";
            $htmlBody = "<h3>ආයුබෝවන් " . htmlspecialchars($userObj['name']) . ",</h3>
                <p>ඔබගේ මුරපදය නැවත සැකසීමට පහත බොත්තම ක්ලික් කරන්න:</p>
                <p><a href='" . htmlspecialchars($resetLink) . "' style='display:inline-block;background:#0F2F6E;color:#ffffff;padding:12px 22px;border-radius:8px;text-decoration:none;font-weight:600;'>Reset Password →</a></p>
                <p style='font-size:12px;color:#666;'>Button එක වැඩ නොකළොත්, මේ link එක copy කරලා browser එකට paste කරන්න:<br>" . htmlspecialchars($resetLink) . "</p>
                <p>මෙම ලින්ක් එක විනාඩි 30කින් කල් ඉකුත් වේ.</p>
                <p>ඔබ මෙය ඉල්ලා නොසිටියේ නම්, මෙම ඊමේල් එක නොසලකා හරින්න.</p>
                <br><p>Best regards,<br>Japan License Prep Team</p>";
            $altBody = "ආයුබෝවන් " . $userObj['name'] . ",\n\n"
                . "ඔබගේ මුරපදය නැවත සැකසීමට පහත ලින්ක් එක ක්ලික් කරන්න:\n\n"
                . $resetLink . "\n\n"
                . "මෙම ලින්ක් එක විනාඩි 30කින් කල් ඉකුත් වේ.\n"
                . "ඔබ මෙය ඉල්ලා නොසිටියේ නම්, මෙම ඊමේල් එක නොසලකා හරින්න.";

            $sent = sendAppEmail($email, $userObj['name'], $subject, $htmlBody, $altBody);

            $success = "මුරපදය නැවත සැකසීමේ ලින්ක් එක ඔබගේ ඊමේල් ලිපිනයට එවා ඇත. කරුණාකර ඔබේ Inbox හෝ Spam ෆෝල්ඩරය පරීක්ෂා කරන්න.";

            if (!$sent && defined('APP_DEBUG') && APP_DEBUG) {
                $success .= "<br><br><strong style='color:#D5432E;'>[DEBUG] Email send failed:</strong> "
                    . htmlspecialchars($GLOBALS['last_mail_error'] ?? 'Unknown error');
            }
        } else {
            // ආරක්ෂක හේතූන් මත ඊමේල් එක නැතත් එකම සාර්ථක පණිවිඩය පෙන්වීම සුදුසුය
            $success = "මෙම ඊමේල් ලිපිනයට අදාළ ගිණුමක් ඇත්නම්, මුරපදය නැවත සැකසීමේ ලින්ක් එකක් එවා ඇත.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password - Japan Driving License Practice</title>
<meta name="robots" content="noindex, follow">
<?php include __DIR__ . '/includes/theme.php'; ?>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<?php $headerLinkHref = 'login.php'; $headerLinkText = 'Login'; include __DIR__ . '/includes/auth-header.php'; ?>

<main class="grid-texture flex-grow flex items-center justify-center px-4 py-10 sm:py-16">
  <div class="max-w-md w-full">

    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-black/5 rise-in">
      <h1 class="font-display text-2xl font-bold text-ink mb-1">Forgot Password <span class="font-body font-normal text-ink/40">/ මුරපදය අමතක වුණාද?</span></h1>
      <p class="text-ink/50 text-sm mb-6">ඔබගේ ගිණුමේ ඊමේල් ලිපිනය මෙහි ඇතුළත් කරන්න.</p>

      <?php if (!empty($error)): ?>
        <div class="mb-4 p-3 bg-stop/10 border border-stop/30 text-stop rounded-xl text-sm font-medium">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="mb-2 p-4 bg-go/10 border border-go/30 text-go rounded-xl text-sm font-medium leading-relaxed">
          <?php echo $success; ?>
          <div class="mt-4">
            <a href="login.php" class="inline-block bg-go text-white px-4 py-2 rounded-lg text-xs font-semibold hover:brightness-95 transition">Return to Login →</a>
          </div>
        </div>
      <?php else: ?>

        <form method="POST" class="space-y-4">
          <div style="position:absolute; left:-9999px;" aria-hidden="true">
            <label>Website</label>
            <input type="text" name="website_hp" value="" tabindex="-1" autocomplete="off">
          </div>

          <div>
            <label class="block text-xs font-semibold text-ink/60 mb-1" for="email">Email Address / ඊමේල් ලිපිනය</label>
            <input id="email" type="email" name="email" required autofocus
                   class="w-full p-3 bg-paper border border-black/10 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
          </div>

          <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3.5 rounded-xl transition shadow-lg text-sm mt-2">
            Reset Password / මුරපදය යළි සකසන්න →
          </button>
        </form>

      <?php endif; ?>

      <p class="text-center text-xs text-ink/50 mt-6">
        Remember your password? <a href="login.php" class="text-primary font-semibold hover:underline">Login here</a>
      </p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>

</body>
</html>