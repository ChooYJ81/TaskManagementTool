<?php
session_start();
if (!isset($_SESSION['accountID'])) {
?>
  <script>
    alert("Please login first before accessing the workspace.");
    window.location.href = "./index.php";
  </script>
<?php
  session_destroy();
}
?>