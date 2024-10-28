<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['message']; ?>
        <?php unset($_SESSION['message']); // Clear the message after displaying ?>
    </div>
<?php endif; ?>
