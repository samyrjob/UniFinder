<?php
require_once 'includes/session.php';
require_once 'includes/auth.php';
require_once 'includes/search.php';
require_once 'includes/save_uni.php';
require_once 'includes/delete_uni.php';
require_once 'includes/get_list_saved_unis.php';
?>



    <!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="UTF-8">
        <title>University Finder</title>
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
       
       
       
        <!--THE LOGIN LOGIC HERE :-->
    <div class= "login_or_signUp">
        
         <?php if (!isset($_SESSION['user_id'])) { ?>
               <!-- Toggle between login and sign up-->
            <div class="toggle-buttons">
                <button onclick="showLogin()">Login</button>
                <button onclick="showSignUp()">Sign Up</button>
            </div>
         <?php } ?>
        
        
        <div class="login-section" id="login-section">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <p><strong>Current User:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?>
                    <a href="?logout=1">
                        <button> Log out </button>
                    </a>
                </p>
            <?php } else { ?>
                <form method="post" action="">
                    <label for="user_id">Login:</label>
                    
                    
                     <label for="user_id">Username:</label>
                    <input type="text" name="username" id="user_id" required>
                    
                    
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="login_password" required>
                    
                    <button type="submit" name="login">Login</button>
                  
                </form>
                <?php if (!empty($loginMessage)) { ?>
                    <p style="color: red;"><?php echo htmlspecialchars($loginMessage); ?></p>
                <?php } ?>
            <?php } ?>
        </div>
       
        <?php if (!isset($_SESSION['user_id'])) { ?>
            <div class="signUp-section"  id="signUp-section" style="display: none;">
                 <form method="post" action="">
                        <label for="user_id">Register</label>
                        
                         <label for="username">Username:</label>
                        <input type="text" name="create_user" id="user_id" required>
                        
                        
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="register_password" required>
                        
                        
                        
                        
                        <button type="submit" name="sign_up">Sign up</button>
                    </form>
                    <?php if (!empty($alreadyUsed)) { ?>
                        <p style="color: red;"><?php echo htmlspecialchars($alreadyUsed); ?></p>
                    <?php } ?>
            </div>
         <?php  } ?>
    </div>
   
    <div>
        <div>
            <h2>Search for Universities</h2>
            <form method="get" action="">
                <input type="text" name="search_uni" placeholder="University name" >
                <label for="more filter"></label>
                <input type="text" name="search_country" placeholder="Country">
                <button type="submit">Search</button>
            </form>
        </div>
       
       
        <?php if (isset($_SESSION['user_id'])) { ?>
            <div>
                <a href="list_saved_unis.php">
                     <button>View my list of Universities</button>  
                </a>
                 
            </div>
        <?php } ?>

    </div>

   
   
   
    <?php if (!empty($results)) { ?>
        <h3>Results:</h3>
        <?php foreach ($results as $uni) { ?><!--16/7 check this loop-->
       
            <?php if (isset($_SESSION['user_id'])) { ?>
                <?php
                    $alreadySaved = false;
                        foreach ($savedUnis as $saved) {
                            if ($saved['name'] === $uni['name']) {
                                $alreadySaved = true;
                                break;
                            }
                    }
                ?>
            <?php } ?>
           
            <div class="university-record"><!--each row-->
                <strong><?php echo htmlspecialchars($uni['name']) ?></strong><br>
               
                Country: <?php echo htmlspecialchars($uni['country']) ?><br>
               
                <?php if (!empty($uni['web_pages'])) { ?>
                    Website: <a href="<?php echo htmlspecialchars($uni['web_pages'][0]) ?>" target="_blank">
                        <?php echo htmlspecialchars($uni['web_pages'][0]) ?>
                    </a>
                <?php } ?>
               
                <?php if (isset($_SESSION['user_id'])) { ?>
               
                     <?php if (!$alreadySaved) { ?>
                        <!-- check when CSS compelete-->
                        <form method="post" action="">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($uni['name']) ?>">
                            <input type="hidden" name="website" value="<?php echo htmlspecialchars($uni['web_pages'][0]) ?>">
                            <button type="submit" name="save_university">Save</button>
                        </form>
                    <?php } else { ?>
                        <p style="color: green;"><em>Already saved</em></p>
                    <?php } ?>
                <?php } else { ?>
                    <!-- check when CSS compelete-->
                       <button onclick="alert('Please log in to save a university.')">Save</button>
                <?php } ?>
               
            </div>
            <hr>
        <?php } ?><!--end loop-->
    <?php } ?>
    <!--check here after any additional section-->
    </body>
</html>


