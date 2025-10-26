<?php
$sessionId = $_GET['session_id'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cashfree Payment</title>
<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>
<body>
  <h2>Redirecting to Cashfree Payment...</h2>
  <div id="cashfree-dropin"></div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      if ("<?php echo $sessionId; ?>" === "") {
        alert("Session ID missing!");
        return;
      }

      const cashfree = Cashfree({ mode: "sandbox" });

      cashfree.checkout({
        paymentSessionId: "<?php echo $sessionId; ?>",
        redirectTarget: "_self" // or "_blank" if you want new tab
      });
    });
  </script>
</body>
</html>
