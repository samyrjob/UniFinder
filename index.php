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
        
        
    <header role="banner">
        <h1>University Finder</h1>
    </header>
       
       
       
        <!--THE LOGIN LOGIC HERE :-->
    <div class= "login_or_signUp">
        
        
         <!-- Toggle between login and sign up-->
         <?php if (!isset($_SESSION['user_id'])) { ?>
        
            <div class="toggle-buttons">
                <button onclick="showLogin()">Login</button>
                <button onclick="showSignUp()">Sign Up</button>
            </div>
         <?php } ?>
        
        
        <div class="login-section" id="login-section">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <p>Welcome dear <strong> <?php echo htmlspecialchars($_SESSION['username']); ?><strong> !
                
                <a href="?logout">
                    <div class="btn-logout">
                            <button> Log out </button>
                    </div>
                </a>
              
                 
                </p>
                  
                <div>
                    <a href="list_saved_unis.php">
                         <button>View my list of Universities</button>  
                    </a>
                     
                </div>
     
            <?php } else { ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                   
                    
                    
                     <label for="user_id">Username:</label>
                    <input type="text" id="user_id" name="username" required>
                    
                    
                    <label for="login_password">Password:</label>
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
                 <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                      
                        
                         <label for="username">Username:</label>
                        <input type="text" id="username" name="create_user" required>
                        
                        
                        <label for="register_password">Password:</label>
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
            <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="search_uni">Name</label>
                <input type="text" id="search_uni" name="search_uni" placeholder="University name" >
                <label for="more_filter">Country</label>
                <input type="text" id="more_filter" name="search_country" placeholder="Country">
                <button type="submit">Search</button>
            </form>
              <?php if (!empty($noContent)) { ?>
                <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($noContent); ?></p>
            <?php } ?>
        </div>
    

    </div>

   
   
   
    <?php if (!empty($results)  && is_array($results) && count($results) > 0 && !in_array("No filter request", $results)) { ?>
        <h3>Results:</h3>
        <?php foreach ($results as $uni) { ?>
       
            <?php if (isset($_SESSION['user_id']) ) { ?>
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
                <?php if (!empty($uni['name'])) { ?>
                    <strong><?php echo htmlspecialchars($uni['name']) ?></strong>
                <?php } ?>
                
                <br>
                 <?php if (!empty($uni['name'])) { ?>
                     <span style="font-weight: normal;"><?php echo htmlspecialchars($uni['country']) ?></span>
                <?php } ?>
                     
                     <br>
               
                <?php if (!empty($uni['web_pages'])) { ?>
                    <a href="<?php echo htmlspecialchars($uni['web_pages'][0]) ?>" target="_blank">
                        <?php echo htmlspecialchars($uni['web_pages'][0]) ?>
                    </a>
                <?php } ?>
               
                <?php if (isset($_SESSION['user_id'])) { ?>
               
                     <?php if (!$alreadySaved && !empty($uni['name'])) { ?>
                        <!-- check when CSS compelete-->
                        <form method="post" action="">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($uni['name']) ?>">
                            <input type="hidden" name="website" value="<?php echo htmlspecialchars($uni['web_pages'][0]) ?>">
                             <input type="hidden" name="country" value="<?php echo htmlspecialchars($uni['country']) ?>">
                            <button type="submit" class="save-btn" name="save_university">Save</button>
                        </form>
                    <?php } else { ?>
                        <p style="color: green;">Saved !</p>
                    <?php } ?>
                <?php } elseif  (!empty($uni['name'])) { ?>
                
                    <div class="save-btn-logged-out">
                        <button  type="button"  onclick="alert('Please log in to save a university.')">Save</button>
                    </div>
                       
                <?php } ?>
               
            </div>
            <hr>
        <?php } ?>
    <?php } ?>
  
    </body>
</html>


