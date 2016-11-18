<!-- Footer -->
<div id="footer">Copyright <?php echo htmlentities(date("Y")) ?>, Ludi Corp.</div>

</body>
</html>
<?php
    // Close database connection if opened
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>