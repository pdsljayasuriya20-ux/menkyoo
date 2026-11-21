<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require __DIR__ . '/includes/config.php';

$error = "";
$notice = "";

// ඊමේල් එක සෙෂන් එකේ නැත්නම් රෙජිස්ටර් පිටුවට හරවා යැවීම
if (!isset($_SESSION['verify_email'])) {
    header("Location: register.php");
    exit;
}

$email = $_SESSION['verify_email'];

// User asked to resend the OTP
if (isset($_GET['resend'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $otp = generateOtp();
        $otpExpiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $upd = $pdo->prepare("UPDATE users SET otp_code = ?, otp_expiry = ? WHERE email = ?");
        $upd->execute([$otp, $otpExpiry, $email]);
        sendOtpEmail($email, $existingUser['name'], $otp);
    }
    header("Location: verify-otp.php?sent=1");
    exit;
}

if (isset($_GET['sent'])) {
    $notice = "අලුත් OTP කේතයක් ඔබේ ඊමේල් එකට යවා ඇත.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = trim($_POST['otp'] ?? '');

    if (empty($enteredOtp)) {
        $error = "කරුණාකර OTP කේතය ඇතුළත් කරන්න.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // OTP එක සහ කාල සීමාව (විනාඩි 10) පරීක්ෂා කිරීම
            if ($user['otp_code'] === $enteredOtp && strtotime($user['otp_expiry']) > time()) {

                // OTP නිවැරදියි! ගිණුම Verify කර Active කිරීම
                $update = $pdo->prepare("UPDATE users SET is_verified = 1, otp_code = NULL, otp_expiry = NULL WHERE email = ?");
                $update->execute([$email]);

                // ස්වයංක්‍රීයව Login කිරීම සඳහා Sessions සැකසීම
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['subscription_status'] = $user['subscription_status'] ?? 'inactive';
                $_SESSION['plan_type']  = $user['plan_type'] ?? 'free';

                unset($_SESSION['verify_email']); // තාවකාලික සෙෂන් එක ඉවත් කිරීම

                // කෙළින්ම Dashboard එකට යැවීම
                header("Location: dashboard.php");
                exit;

            } else {
                $error = "වලංගු නොවන හෝ කල් ඉකුත් වූ OTP කේතයකි. කරුණාකර නැවත උත්සාහ කරන්න.";
            }
        } else {
            $error = "පරිශීලකයා හමු නොවීය.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify OTP - Japan Driving License Practice</title>
<meta name="robots" content="noindex, follow">
<?php include __DIR__ . '/includes/theme.php'; ?>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<?php $headerLinkHref = null; include __DIR__ . '/includes/auth-header.php'; ?>

<main class="grid-texture flex-grow flex items-center justify-center px-4 py-10 sm:py-16">
  <div class="max-w-md w-full">
    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-black/5">
      <h2 class="font-display text-2xl font-bold text-ink mb-1">Verify OTP <span class="font-body font-normal text-ink/40">/ තහවුරු කරන්න</span></h2>
      <p class="text-ink/50 text-sm mb-6">
        <?php echo htmlspecialchars($email); ?> වෙත ලැබුණු අංක 6 ක OTP කේතය මෙහි ඇතුළත් කරන්න.
      </p>

      <?php if (!empty($notice)): ?>
        <div class="mb-4 p-3 bg-go/10 border border-go/30 text-go rounded-xl text-sm font-medium">
          <?php echo $notice; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="mb-4 p-3 bg-stop/10 border border-stop/30 text-stop rounded-xl text-sm font-medium">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <form method="POST" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-ink/60 mb-1" for="otp">Enter 6-digit OTP</label>
          <input id="otp" type="text" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus placeholder="123456"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl text-center tracking-widest text-2xl font-mono focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3.5 rounded-xl transition shadow-lg text-sm">
          Verify &amp; Go to Dashboard →
        </button>
      </form>

      <p class="text-center text-xs text-ink/50 mt-6">
        කේතය ලැබුණේ නැද්ද?
        <a href="verify-otp.php?resend=1" class="text-primary font-semibold hover:underline">Resend OTP</a>
      </p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>

</body>
</html>