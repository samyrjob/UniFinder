<?php
require_once 'includes/session.php';
require_once 'includes/delete_uni.php';
require_once 'includes/get_list_saved_unis.php';
?>



<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="UTF-8">
        <title>Saved Universities</title>
        <link rel="stylesheet" href="style.css">
       
    </head>
    <body>
        
    <header role="banner">
        <h1>My Saved Universities</h1>
    </header>


    <button type="button" onclick="window.location.href='index.php'">← Back</button>
    
    <?php if (!empty($saveUni)) { ?>
        <p style="color: blue;"><?php echo htmlspecialchars($saveUni); ?></p>
    <?php } ?>
    
    <br>
    <br>
    
    
    <?php if (!empty($savedUnis)) { ?>
        <?php foreach ($savedUnis as $uni) { ?>
            <div class="university-record">
                <strong><?php echo htmlspecialchars($uni['name']); ?></strong> <br>
                <a href="<?php echo htmlspecialchars($uni['website']); ?>" target="_blank">
                    <?php echo htmlspecialchars($uni['website']); ?>
                </a><br>
               <span style="font-weight: normal;"><?php echo htmlspecialchars($uni['country']) ?></span><br>
                 <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="uni_name" value="<?php echo htmlspecialchars($uni['name']); ?>">
                    <button type="submit" name="delete_university" class="delete-btn"
                        onclick="return confirm('Confirm you want to remove this university?')">Delete</button>
                </form><br>
                
                
                
            </div>
            <hr>
        <?php } ?>
    <?php } else { ?>
        <p>No universities saved.</p>
    <?php } ?>
    
    
        </body>
</html>


