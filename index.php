<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Form With V3 Recaptcha</title>
  <link rel="stylesheet" href="assets/styles/styles.css">
</head>

<body>

  <?php

  // Configuration file.
  include_once("includes/config.php");

  // Initialize All The Variables.
  $submitStatusMsg = "";
  $name = "";
  $email = "";
  $message = "";

  // When submit the form.
  if (isset($_POST['submit'])) {

    // Include the functions file.
    include_once("includes/functions.php");

    // Call Recaptcha Validation Functions.
    $recaptchaValidationStatus = getRecaptchaValidationStatus($_POST['g-recaptcha-response']);

    if (isset($recaptchaValidationStatus['status']) && $recaptchaValidationStatus['status'] == 1) {
      // customize success message in function.php page
      $submitStatusMsg = $recaptchaValidationStatus['msg'];
      $statusClass = "success";
    } else {
      // customize error message in function.php page
      $submitStatusMsg = $recaptchaValidationStatus['msg'];
      $statusClass = "error";
      //Store user submitted information.
      $name = $_POST['name'];
      $email = $_POST['email'];
      $message = $_POST['message'];
    }
  }

  ?>

  <div class="form-container">
    <h2>Contact Us</h2>

    <!-- Display message based on the validation status. -->
    <?php if (!empty($submitStatusMsg)) : ?>

      <p class="status status--<?php echo $statusClass; ?>"><?php echo $submitStatusMsg; ?></p>

    <?php endif; ?>

    <form action="index.php" method="post">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required value="<?php echo $name; ?>">

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required value="<?php echo $email; ?>">

      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="4" required><?php echo $message; ?></textarea>
      <input type="hidden" name="g-recaptcha-response" id="gRecaptchaResponse" />
      <input type="submit" value="Submit" name="submit">
    </form>

  </div>

  <!-- Include the following JavaScript File -->
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo GRC_SITE_KEY; ?>"></script>
  <script>
    grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo GRC_SITE_KEY; ?>', {
        action: 'submit'
      }).then(function(token) {
        var recaptchaResponse = document.getElementById('gRecaptchaResponse');
        recaptchaResponse.value = token;
      });
    });
  </script>
</body>

</html>