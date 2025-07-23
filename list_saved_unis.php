<?php
require_once 'includes/session.php';
require_once 'includes/delete_uni.php';
require_once 'includes/get_list_saved_unis.php';
?>


<a href="index.php">
    <button type="button">← Back to Search</button>
</a>

<?php if (!empty($saveUni)) { ?>
    <p style="color: blue;"><?php echo htmlspecialchars($saveUni); ?></p>
<?php } ?>

<h2>My Saved Universities</h2>

<?php if (!empty($savedUnis)) { ?>
    <?php foreach ($savedUnis as $uni) { ?>
        <div class="university-record">
            <strong><?php echo htmlspecialchars($uni['name']); ?></strong>
            <form method="post" action="">
                <input type="hidden" name="uni_name" value="<?php echo htmlspecialchars($uni['name']); ?>">
                <button type="submit" name="delete_university" class="delete-btn"
                    onclick="return confirm('Confirm you want to remove this university?')">Delete</button>
            </form><br>
            Website: <a href="<?php echo htmlspecialchars($uni['website']); ?>" target="_blank">
                <?php echo htmlspecialchars($uni['website']); ?>
            </a>
        </div>
        <hr>
    <?php } ?>
<?php } else { ?>
    <p>No universities saved.</p>
<?php } ?>


