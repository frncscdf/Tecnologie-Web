<?php
    include_once ('sessionManager.php');
    include_once ("User.php");
?>  
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Your profile &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Personal profile page" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="./style/style.css" />
        <link rel="stylesheet" type="text/css" href="./style/print.css" media="print"/>
        <script src="./script/scripts.js"></script>

    </head>

    <body>
        <?php
        include_once('navbar.php');
        SimpleNavbar::printSimpleNavbar();
        ?>
        <div id="registration-form">
        <?php 
            $nickname = unserialize($_SESSION['userInfo'])->nickname;
            if(User::isBanned($nickname)) {
                echo '<div id="login-error-box-zone"></div>
                <div class="regform-main-section">
                <ul class="regform-errorbox">
                                <li>Your account has been suspended, you can\'t leave comments and/or
                                like/dislike any article. In order to get back your features, an admin user
                                have to remove your suspension.</li>
                                </ul>
                            </div>';
            }
        ?>
            <div class="regform-introduction">
                <h1>Welcome back user!</h1>
                <?php 
                    if(isset($_SESSION['email'])) {
                        echo "<p>You are currently logged in as: ".$_SESSION['email']."</p>";
                    } else {
                        header("Location: errore.php?errorCode=paginaNonDisponibile");
                        die();
                    }
                    ?>
                
                <h2>Edit your information</h2>
            </div>
            <div id="profile-error-box-base-data"></div>
            <div class="regform-main-section">
                <?php
                    if(isset($_POST['submitChangeInfo'])) {
                        if(isset($_POST['nickname'])) {
                            $change_nick_result = User::changeNickname($_SESSION['email'], $_POST['nickname']);
                            if($change_nick_result == NULL) {
                                echo '<ul class="regform-successbox"><li>Nickname updated successfully!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                if($change_nick_result->getIsError()) {
                                    echo '<ul class="regform-errorbox">';
                                    echo '<li>' . $change_nick_result->getMessage() . '</li>';
                                    echo '</ul>';
                                }
                            }
                        }
                        
                        if(isset($_POST['name'])) {
                            $change_name_result = User::changeName($_SESSION['email'], $_POST['name']);
                            if($change_name_result == NULL) {
                                echo '<ul class="regform-successbox"><li>Name successfully updated!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                if($change_name_result->getIsError()) {
                                    echo '<ul class="regform-errorbox">';
                                    echo '<li>' . $change_name_result->getMessage() . '</li>';
                                    echo '</ul>';
                                }
                            }
                        }

                        if(isset($_POST['surname'])) {
                            $change_surname_result = User::changeSurname($_SESSION['email'], $_POST['surname']);
                            if($change_surname_result == NULL) {
                                echo '<ul class="regform-successbox"><li>Surname updated successfully!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                if($change_surname_result->getIsError()) {
                                    echo '<ul class="regform-errorbox">';
                                    echo '<li>' . $change_surname_result->getMessage() . '</li>';
                                    echo '</ul>';
                                }
                            }
                        }

                        if(($change_nick_result!=NULL && !$change_nick_result->getIsError()) &&
                            ($change_name_result!=NULL && !$change_name_result->getIsError()) &&
                            ($change_surname_result!=NULL && !$change_surname_result->getIsError())
                        ){
                            echo '<ul class="regform-successbox"><li>Nothing to update!</li></ul>';
                        }
                        
                    }
                ?>
                <form action="profile.php" id="change_basic_data_form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lnickname">Nickname</label>
                            <input class="profile-input" type="text" id="lnickname" name="nickname" pattern=".{1,100}" maxlength="100" required onchange="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->nickname;?>"/>
                        </p>
                        <p>
                            <label for="lname">Name</label>
                            <input class="profile-input" type="text" id="lname" name="name" pattern="^[a-zA-Z0-9_]+( [a-zA-Z0-9_]+)*$" title="Your Name" maxlength="100" required onchange="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->name;?>"/>
                        </p>
                        <p>
                            <label for="lsurname">Surname</label>
                            <input class="profile-input" type="text" id="lsurname" name="surname" pattern="^[a-zA-Z0-9_]+( [a-zA-Z0-9_]+)*$" title="Your surname" maxlength="100" required onchange="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->surname;?>"/>
                        </p>
                        <p><input class="profile-input" name="submitChangeInfo" type="submit" value="Update information" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Change your password</h2>
            </div>
            <div id="profile-error-box-change-pw"></div>
            <div class="regform-main-section">
                <?php 
                    if(isset($_POST['submitChangePassword'])) {
                        $result = User::changePassword($_SESSION['email'], $_POST['old-password'], $_POST['new-password'], $_POST['conf-new-password']);
                        if($result->getIsError()){
                            echo '<ul class="regform-errorbox"><li>'.$result->getMessage().'</li></ul>';
                        }else{
                            echo '<ul class="regform-successbox"><li>'.$result->getMessage().'</li></ul>';
                        }
                        
                    }
                ?>
                <form action="profile.php" id="change_pw_form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lold-password">Current Password</label>
                            <input class="profile-input" type="password" id="lold-password" name="old-password" pattern=".{3,100}" placeholder="Current Password" maxlength="100" required onchange="ProfilePage_HideChangePWError()" />
                        </p>
                        <p>
                            <label for="lnew-password">New password</label>
                            <input class="profile-input" type="password" id="lnew-password" name="new-password" pattern=".{3,100}" placeholder="New password" maxlength="100" required onchange="ProfilePage_HideChangePWError()" />
                        </p>
                        <p>
                            <label for="lconf-new-password">Confirm new password</label>
                            <input class="profile-input" type="password" id="lconf-new-password" name="conf-new-password" pattern=".{3,100}" placeholder="Confirm new password" maxlength="100" required onchange="ProfilePage_HideChangePWError()" />
                        </p>
                        <p><input class="profile-input" name="submitChangePassword" type="submit" value="Change Password" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Delete your account</h2>
            </div>
            <div class="regoform-main-section">
            <form action="confirmDeleteAccount.php" method="POST" >
                <p><input class="profile-input" name="delete_account" type="submit" value="Delete your account" /></p>
            </form>
            </div>
            <?php
            echo '<noscript>';
            SimpleNavbar::printSimpleNavbar(true);
            echo '</noscript>';
            ?>
        </div>
        <?php
        echo '<noscript>';
        SimpleNavbar::printNoJSWarning();
        echo '</noscript>';
        ?>
    </body>
</html>