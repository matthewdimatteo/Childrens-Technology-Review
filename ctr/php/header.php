<header>
    
    <!-- LEFT (BACK, MENU) -->
    <div class = "thirds left" id = "header-left">
        
        <!-- BACK -->
        <div class = "back-btn">
            <?php
			if($thisPage != 'home.php')
			{
				if ($thisPage == 'issue.php' or $thisPage == 'weekly.php')
				{
					echo '<a href = "'.$archiveSearchURL.'">< Back to Archive</a>';
				}
				else
				{
					echo '<a href = "'.$reviewSearchURL.'">< Back to Reviews</a>';
				}
			} // end if not on home page
			else { echo '&nbsp;'; }
			?>
        </div><!-- /.back-btn -->
		
		<div class = "back-btn-mobile">
			<?php if($thisPage != 'home.php') { echo '<a href = "'.$reviewSearchURL.'">< Back</a>'; } else { echo '&nbsp;'; } ?>
		</div><!-- /.back-btn -->
        
        <!-- MENU -->
        <div class = "menu-btn">
            <div id = "menu-show" class = "block" title = "Open the menu">
                <img src = "images/menu.png" id = "menu-btn-show" onclick = "showItem('menu-show', 'menu-hide', 'menu-container')" width = "32" height = "32"/>
            </div><!-- /#menu-show -->
            <div id = "menu-hide" class = "hide" title = "Close the menu">
                <img src = "images/menu.png" id = "menu-btn-hide" onclick = "showItem('menu-show', 'menu-hide', 'menu-container')" width = "32" height = "32" />
            </div><!-- /#menu-hide -->
        </div><!-- /.menu-btn -->
        
    </div><!-- /.thirds left /#header-left -->

    <!-- CENTER (LOGO, SEARCH) -->
    <div class = "thirds center" id = "header-center">
        
        <!-- LOGO -->
        <div id = "logo">
            <a href = "home.php" title = "Home" onMouseOver="logoHover()" onMouseOut="logoIdle()">
                <div id = "logo-idle"><img src = "images/ctr-logo-white.png" width = "300" height = "81" /></div>
				<div id = "logo-hover" class = "hide"><img src = "images/ctr-logo-color.png" width = "300" height = "81" /></div>
            </a>
			<a href = "home.php" title = "Home" class = "mobile-only">
				<div id = "logo-mobile"><img src = "images/ctr-logo-white.png" width = "150" height = "40" /></div>
			</a>
        </div><!-- /#logo -->
        
        <!-- SEARCHBAR -->
        <div id = "searchbar">
            <form id = "search-reviews-form" name = "search-reviews-form" method = "GET" action = "home.php">
                <input type = "search" name = "keyword"     id = "search-reviews-keyword" placeholder = "Search..." value = "<?php echo $searchReviewsKeyword;?>"/>
                <input type = "hidden" name = "sort"        id = "search-reviews-sort"        value = "<?php echo $searchReviewsSort;?>" />
                <input type = "hidden" name = "age"         id = "search-reviews-age"         value = "<?php echo $searchReviewsAge;?>" />
                <input type = "hidden" name = "subject"     id = "search-reviews-subject"     value = "<?php echo $searchReviewsSubject;?>" />
                <input type = "hidden" name = "platform"    id = "search-reviews-platform"    value = "<?php echo $searchReviewsPlatform;?>" />
                <input type = "hidden" name = "category"    id = "search-reviews-topic"       value = "<?php echo $searchReviewsTopic;?>" />
                <input type = "hidden" name = "list"        id = "search-reviews-list"        value = "<?php echo $searchReviewsList;?>" />
                <input type = "hidden" name = "company"     id = "search-reviews-company"     value = "<?php echo $searchReviewsCompany;?>" />
                <input type = "hidden" name = "monthly"     id = "search-reviews-monthly"     value = "<?php echo $searchReviewsMonthly;?>" />
                <input type = "hidden" name = "weekly"      id = "search-reviews-weekly"      value = "<?php echo $searchReviewsWeekly;?>" />
                <input type = "hidden" name = "award"       id = "search-reviews-award"       value = "<?php echo $searchReviewsAward;?>" />
                <input type = "hidden" name = "year"        id = "search-reviews-year"        value = "<?php echo $searchReviewsYear;?>" />
                <input type = "hidden" name = "latest"      id = "search-reviews-latest"      value = "<?php echo $searchReviewsLatest;?>" />
                <input type = "hidden" name = "edchoice"    id = "search-reviews-edchoice"    value = "<?php echo $searchReviewsEdChoice;?>" />
                <input type = "hidden" name = "ethical"     id = "search-reviews-ethical"     value = "<?php echo $searchReviewsEthical;?>" />
                <input type = "hidden" name = "wayback"     id = "search-reviews-wayback"     value = "<?php echo $searchReviewsWayBack;?>" />
                <input type = "hidden" name = "page"        id = "search-reviews-page"        value = "<?php echo $searchReviewsPage;?>" />
            </form>
			<form id = "export-reviews-form" name = "export-reviews-form" method = "GET" action = "export.php" target = "_blank">
                <input type = "hidden" name = "keyword"     id = "export-reviews-keyword"     value = "<?php echo $searchReviewsKeyword;?>"/>
                <input type = "hidden" name = "sort"        id = "export-reviews-sort"        value = "<?php echo $searchReviewsSort;?>" />
                <input type = "hidden" name = "age"         id = "export-reviews-age"         value = "<?php echo $searchReviewsAge;?>" />
                <input type = "hidden" name = "subject"     id = "export-reviews-subject"     value = "<?php echo $searchReviewsSubject;?>" />
                <input type = "hidden" name = "platform"    id = "export-reviews-platform"    value = "<?php echo $searchReviewsPlatform;?>" />
                <input type = "hidden" name = "category"    id = "export-reviews-topic"       value = "<?php echo $searchReviewsTopic;?>" />
                <input type = "hidden" name = "list"        id = "export-reviews-list"        value = "<?php echo $searchReviewsList;?>" />
                <input type = "hidden" name = "company"     id = "export-reviews-company"     value = "<?php echo $searchReviewsCompany;?>" />
                <input type = "hidden" name = "monthly"     id = "export-reviews-monthly"     value = "<?php echo $searchReviewsMonthly;?>" />
                <input type = "hidden" name = "weekly"      id = "export-reviews-weekly"      value = "<?php echo $searchReviewsWeekly;?>" />
                <input type = "hidden" name = "award"       id = "export-reviews-award"       value = "<?php echo $searchReviewsAward;?>" />
                <input type = "hidden" name = "year"        id = "export-reviews-year"        value = "<?php echo $searchReviewsYear;?>" />
                <input type = "hidden" name = "latest"      id = "export-reviews-latest"      value = "<?php echo $searchReviewsLatest;?>" />
                <input type = "hidden" name = "edchoice"    id = "export-reviews-edchoice"    value = "<?php echo $searchReviewsEdChoice;?>" />
                <input type = "hidden" name = "ethical"     id = "export-reviews-ethical"     value = "<?php echo $searchReviewsEthical;?>" />
                <input type = "hidden" name = "wayback"     id = "export-reviews-wayback"     value = "<?php echo $searchReviewsWayBack;?>" />
                <input type = "hidden" name = "page"        id = "export-reviews-page"        value = "<?php echo $searchReviewsPage;?>" />
				<input type = "hidden" name = "validation"  id = "export-reviews-validation"  value = "true" />
				<input type = "hidden" name = "scope"  		id = "export-reviews-scope"  	  value = "search" />
				<input type = "hidden" name = "format"  	id = "export-reviews-format" />
            </form>
        </div><!-- /#searchbar -->
    </div><!-- /.thirds center /#header-center -->
    
    <!-- RIGHT (LOGIN) -->
    <div class = "thirds right" id = "header-right">
    <?php
    // LOGIN / LOGOUT
    if($login != true)
    {
        if($velvetRopeRedirect != NULL) { $redirect = $velvetRopeRedirect; } else { $redirect = $thisURL; }
        echo
			'<div class = "mb-10 mobile-hide" id = "login-note">Log in for unlimited access</div>
            <form name = "login-form" class = "mobile-hide" method = "POST" action = "login.php">
                <div class = "login-form-row"><input type = "text" name = "username" required placeholder = "username" /></div>
                <div class = "login-form-row"><input type = "password" name = "password" required placeholder = "password" /></div>
				<div class = "login-form-row">
					<div class = "inline"><input type = "checkbox" name = "publisher" id = "login-as-publisher" /></div>
					<div class = "inline" id = "publisher-login-label" onclick = "toggleCheckmark(\'login-as-publisher\')">Log in as publisher</div>
				</div>
                <div class = "login-form-row">
                    <input type = "hidden"   name = "redirect" value = "'.$redirect.'" />
                    <input type = "submit"   name = "submit"            value = "Log In" />
                    <button type = "button" onclick = "openURL(\'subscribe.php\')"/>Subscribe</button>
                </div>
            </form>';
		if($thisPage != 'subscribe.php')
		{
            echo
				'<div class = "mobile-only" id = "mobile-login">
                    <div>&nbsp;</div>
                    <div><button type = "button" onclick = "openURL(\'subscribe.php\')">Log In</button></div>
                </div>';
		} // end if $thisPage != 'subscribe.php'
    } // end if $login != true
    else
    {
		echo '<div class = "mobile-hide">';
		if($subscriber == true)
		{
        	echo 'Logged in as <a href = "account.php" title = "Manage your account">'.$subscriberUsername.'</a><br/>';
        	echo '<a href = "logout.php">Log Out</a><br/>';
		}
		if($temp == true)
		{
        	echo 'Logged in as '.$subscriberUsername.'<br/>';
        	echo '<a href = "logout.php">Log Out</a><br/>';
		}
		if($license == true)
        {
            echo 'Logged in as '.$licenseName.'<br/>';
            echo '<a href = "logout.php">Log Out</a><br/>';
        }
		if($publisher == true)
		{
			echo 'Logged in as <a href = "publisher.php" title = "Manage your account">'.$publisherName.'</a><br/>';
        	echo '<a href = "logout.php">Log Out</a><br/>';
		}
		echo '</div>'; // /.mobile-hide
    } // end if $login == true
    ?>
    </div><!-- /. thirds right /#header-right -->
</header>

<!-- MENU -->
<div id = "menu-container">
    <div id = "menu">
    	<?php
        $menuItems = array();
        array_push($menuItems, array('home.php', 'Home'));
        array_push($menuItems, array('about.php', 'About'));
        array_push($menuItems, array('archive.php', 'Archive'));
        //array_push($menuItems, array('awards.php', 'Award Programs'));
        //array_push($menuItems, array('about.php#contact', 'Contact'));
		array_push($menuItems, array('contact.php', 'Contact'));
        array_push($menuItems, array('corrections.php', 'Corrections'));
        array_push($menuItems, array('about.php#disclaimer', 'Disclaimer and Copyright'));
        array_push($menuItems, array('calendar.php', 'Editorial Calendar'));
        array_push($menuItems, array('guidelines.php', 'Editorial Guidelines'));
        array_push($menuItems, array('editor.php', 'Editor\'s Page'));
        array_push($menuItems, array('faq.php', 'FAQ'));
        array_push($menuItems, array('philosophy.php', 'Our Philosophy'));
        array_push($menuItems, array('press.php', 'Press Resources'));
        array_push($menuItems, array('publishers.php', 'Publisher Accounts'));
        array_push($menuItems, array('ratings.php', 'Rating Method'));
        array_push($menuItems, array('password.php', 'Recover a Password'));
        array_push($menuItems, array('licenses.php', 'Site Licenses'));
        array_push($menuItems, array('social-media.php', 'Social Media'));
        //array_push($menuItems, array('staff.php', 'Staff'));
        array_push($menuItems, array('submit.php', 'Submit a Product for Review'));
        array_push($menuItems, array('subscribe.php', 'Subscriptions'));
		$menuN = -1;
		foreach($menuItems as $menuItem)
		{
			$menuN += 1;
			$itemLink 	= $menuItem[0];
			$itemLabel 	= $menuItem[1];
			echo '<a href = "'.$itemLink.'" id = "menu-item-'.$menuN.'"><div class = "menu-line">'.$itemLabel.'</div></a>';
		}
		?>
    </div><!-- menu -->
</div><!-- /#menu-container -->

<!-- FOR DEBUG OUTPUT -->
<div id = "debug" class = "center t-12"></div>

<?php
// FREE MODE INDICATOR
if($freeMode == true and $subscriber != true and $temp != true and $license != true)
{
	echo '<div class = "free-mode">';
		echo '&#9734; &#9734; &#9734; Open House &#9734; &#9734; &#9734;<br/>';
		if($publisher == true) { echo 'You may currently browse with full access'; }
		else { echo 'You are logged in as our guest'; }
	echo '</div>';
} // end if $freeMode

// TEMP PASSWORD INDICATOR
/*
if($temp == true)
{
	echo '<div class = "free-mode">';
		echo 'Logged in with instant access account '.$subscriberUsername;
	echo '</div>';
} // end if $temp
*/

// MOBILE LOGIN INDICATOR
if($subscriber == true or $temp == true or $license == true or $publisher == true)
{
	echo '<div class = "free-mode mobile-only">';
		if($subscriber == true)
		{
        	echo 'Logged in as <a href = "account.php" title = "Manage your account">'.$subscriberUsername.'</a><br/>';
        	echo '<a href = "logout.php">Log Out</a><br/>';
		}
		if($temp == true)
		{
			echo 'Logged in as '.$subscriberUsername.'<br/>';
        	echo '<a href = "logout.php">Log Out</a><br/>';
		}
		if($license == true)
        {
            echo 'Logged in as '.$licenseName.'<br/>';
            echo '<a href = "logout.php">Log Out</a><br/>';
        }
		if($publisher == true)
		{
			echo 'Logged in as <a href = "publisher.php" title = "Manage your account">'.$publisherName.'</a><br/>';
        	echo '<a href = "logout.php">Log Out</a><br/>';
		}
	echo '</div>'; // /.free-mode mobile-only
} // end if $freeMode

// ERROR MESSAGE
$error = $_SESSION['error'];
$_SESSION['error'] = '';
if($error == true)
{
    $errorMessage = $_SESSION['error-message'];
    $_SESSION['error-message'] = '';
    if($errorMessage != NULL)
    {
        echo '<div class = "error-message">';
            echo $errorMessage;
        echo '</div>';
    } // end if $errorMessage
} // end if $error

// CONFIRMATION MESSAGE
$confirmation = $_SESSION['confirmation'];
$_SESSION['confirmation'] = '';
if($confirmation == true)
{
    $confirmationMessage = $_SESSION['confirmation-message'];
    $_SESSION['confirmation-message'] = '';
    if($confirmationMessage != NULL)
    {
        echo '<div class = "confirmation-message">';
            echo $confirmationMessage;
        echo '</div>';
    } // end if $confirmationMessage
} // end if confirmation

// BROWSER NOTE
$userAgent = $_SERVER['HTTP_USER_AGENT'];
if(substr_count($userAgent, 'Chrome') < 1) { echo '<div class = "caption italic center" id = "browser-note">Please note: this website is best viewed using Google Chrome</div>'; }
//else { echo '<div class = "caption center">Ah, I see you\'re using Chrome. Good choice.</div>'; }

?>