<?php
// contact.php - User Contact / Error Reporting Form
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/includes/config.php';

$success = "";
$error = "";

// Prefill from whichever session is active — a logged-in site user, or (if
// somehow reached from the admin panel) the admin — not admin-only as before.
$prefillName = $_SESSION['user_name'] ?? $_SESSION['admin_name'] ?? '';
$prefillEmail = $_SESSION['user_email'] ?? $_SESSION['admin_email'] ?? '';

const MAX_SCREENSHOT_BYTES = 5 * 1024 * 1024; // 5MB

if (isset($_POST['send_message'])) {
    // Honeypot — real users never fill this
    if (!empty($_POST['website_hp'])) {
        exit("Spam detected.");
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $screenshot_path = null;

    if (empty($email) || empty($message)) {
        $error = "කරුණාකර ඊමේල් ලිපිනය සහ පණිවිඩය ඇතුළත් කරන්න.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "වලංගු නොවන ඊමේල් ලිපිනයකි.";
    } else {
        // Handle Screenshot Upload if provided
        if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['screenshot']['tmp_name'];
            $file_name = $_FILES['screenshot']['name'];
            $file_size = $_FILES['screenshot']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $imageInfo = @getimagesize($file_tmp); // confirms it's actually an image, not just a renamed file

            if (!in_array($file_ext, $allowed_exts) || $imageInfo === false) {
                $error = "කරුණාකර වලංගු රූප සටහනක් (JPG, PNG, GIF, WEBP) පමණක් අප්ලෝඩ් කරන්න.";
            } elseif ($file_size > MAX_SCREENSHOT_BYTES) {
                $error = "රූප සටහන ඉතා විශාලයි (උපරිම 5MB).";
            } else {
                $upload_dir = __DIR__ . '/uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $new_filename = 'err_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
                if (move_uploaded_file($file_tmp, $upload_dir . $new_filename)) {
                    $screenshot_path = 'uploads/' . $new_filename;
                } else {
                    $error = "රූප සටහන අප්ලෝඩ් කිරීමේදී දෝෂයක් ඇති විය.";
                }
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message, screenshot) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $message, $screenshot_path])) {
                $success = "ඔබේ පණිවිඩය සාර්ථකව යවන ලදී! ස්තූතියි.";
            } else {
                $error = "පණිවිඩය යැවීමේදී දෝෂයක් ඇති විය. කරුණාකර පසුව උත්සාහ කරන්න.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Support / Report an Issue - Japan License Prep</title>
<meta name="description" content="Get in touch with Japan License Prep support — report a bug, ask a question, or send feedback.">
<meta name="robots" content="noindex, follow">
<?php include __DIR__ . '/includes/theme.php'; ?>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<?php $headerLinkHref = 'index.php'; $headerLinkText = '← Home'; include __DIR__ . '/includes/auth-header.php'; ?>

<main class="grid-texture flex-grow flex items-center justify-center px-4 py-10 sm:py-16">
  <div class="max-w-lg w-full">

    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-black/5 rise-in">
      <h1 class="font-display text-2xl font-bold text-ink mb-1">Contact Support <span class="font-body font-normal text-ink/40">/ අදාළ කරුණ දන්වන්න</span></h1>
      <p class="text-ink/50 text-sm mb-6">දෝෂයක් වාර්තා කරන්න, ප්‍රශ්නයක් අහන්න, එසේත් නැත්නම් අදහසක් එවන්න.</p>

      <?php if ($success): ?>
        <div class="mb-4 p-3 bg-go/10 border border-go/30 text-go rounded-xl text-sm font-medium"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="mb-4 p-3 bg-stop/10 border border-stop/30 text-stop rounded-xl text-sm font-medium"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <!-- Honeypot -->
        <div style="position:absolute; left:-9999px;" aria-hidden="true">
          <label>Website</label>
          <input type="text" name="website_hp" value="" tabindex="-1" autocomplete="off">
        </div>

        <div>
          <label class="block text-xs font-semibold text-ink/60 mb-1" for="name">Your Name / ඔබේ නම (Optional)</label>
          <input id="name" type="text" name="name" value="<?= htmlspecialchars($prefillName) ?>"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
        <div>
          <label class="block text-xs font-semibold text-ink/60 mb-1" for="email">Email Address / ඊමේල් ලිපිනය *</label>
          <input id="email" type="email" name="email" required value="<?= htmlspecialchars($prefillEmail) ?>"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
        <div>
          <label class="block text-xs font-semibold text-ink/60 mb-1" for="message">Describe the Error or Message / විස්තර *</label>
          <textarea id="message" name="message" rows="4" required placeholder="Describe what went wrong or what you need help with..."
                    class="w-full p-3 bg-paper border border-black/10 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
        </div>
        <div>
          <label class="block text-xs font-semibold text-ink/60 mb-1" for="screenshot">Attach Screenshot / රූප සටහනක් (Optional, max 5MB)</label>
          <input id="screenshot" type="file" name="screenshot" accept="image/png,image/jpeg,image/gif,image/webp"
                 class="w-full text-xs text-ink/50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark">
        </div>
        <button type="submit" name="send_message" class="w-full bg-primary hover:bg-primary-dark text-white p-3 rounded-xl font-semibold transition shadow-lg">
          Send Message / පණිවිඩය යවන්න →
        </button>
      </form>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>

</body>
</html>