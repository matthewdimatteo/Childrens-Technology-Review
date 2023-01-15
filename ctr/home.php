<?php
require_once 'php/autoload.php';
require_once 'php/find-reviews.php';
?>

<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review</title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
		
        <div id = "content">
			
            <?php require_once 'php/sidebar-left.php';?>
            
            <!-- RESULTS -->
            <div class = "results">
			
                <!-- SUMMARY -->
                <div class = "results-summary"><?php echo $resultsSummary;?></div>
                
                <!-- SEARCH OPTIONS -->
                <div id = "search-options">
                    <div class = "search-option-item"><img src = "images/reset.png" width = "24" height = "24" onclick = "clearReviews()"/></div>
                    <div class = "search-option-item"><button type = "button" onclick = "sortReviews('new')">New</button></div>
                    <div class = "search-option-item"><button type = "button" onclick = "sortReviews('old')">Old</button></div>
                    <div class = "search-option-item"><button type = "button" onclick = "sortReviews('best')">Best</button></div>
                    <div class = "search-option-item"><button type = "button" onclick = "sortReviews('abc')">ABC</button></div>
                    <div class = "search-option-item"><button type = "button" onclick = "sortReviews('zyx')">ZYX</button></div>
                    <?php
					// EXPORT (SUBSCRIBERS ONLY)
					if($subscriber == true or $temp == true or $license == true or $freeMode == true or ($publisher == true and $searchReviewsCompany == $publisherName))
					{
						echo '<div class = "search-option-item hide-tablet"><button type="button" onclick = "exportReviews(\'tab\')">Export .tab</button></div>';
						echo '<div class = "search-option-item hide-tablet"><button type="button" onclick = "exportReviews(\'csv\')">Export .csv</button></div>';
					} // end if $subscriber
					
					// INCLUDE OLDER RESULTS
					if($searchReviewsNumParams < 1 or $searchReviewsWayBack == true)
					{
                        echo '<div class = "search-option-item-wayback" onclick = "wayBack()" title = "Search all 13,000 reviews dating back to 1980 (this may impact page loading times)">';
                            echo '<input type = "checkbox" name = "wayback" id = "wayback" '; if($searchReviewsWayBack == true) { echo 'checked'; }
                            echo 'onchange = "wayBack()">';
                            $wayBackLabel = 'Include older entries';
                            if($searchReviewsSort == 'old') { $wayBackLabel = 'Search all 13,000 reviews'; }
                            echo $wayBackLabel;
                        echo '</div>'; // /.search-option-item-wayback
					} // end if > 1 param or already searching wayback
					?>
                </div><!-- /#search-options -->
                
				<?php
				//if($subscriber == true or ($publisher == true and $searchReviewsCompany == $publisherName)) { require 'php/pagenav.php'; }
				if($publisher == true)
				{
					if($searchReviewsCompany != $publisherName)
					{
						echo '<h3 class = "center"><a href = "home.php?company='.$publisherName.'">See all of your products reviewed by CTR</a></h3>';
					}
					else
					{
						echo '<h3 class = "center">Your products reviewed by CTR:</h3>';
					}
				}
				?>
            
                <!-- RESULTS -->
                <div id = "results-list">
                <?php
                $n = 0;
                foreach($records as $record)
                {
                    $n += 1;
                    $reviewID   = $record->getField('reviewnumber');
                    $reviewURL  = 'review.php?id='.$reviewID;
                    $title      = $record->getField('Title');
                    $thumbData  = $record->getField('thumbData');
                    $thumbnail  = $record->getField('thumbnail');
                    
                    $copyright  = $record->getField('Copyright Date');
                    $company    = $record->getField('Company');
                    $companyID  = $record->getField('Producers::Company Name');
                    $website    = $record->getField('websiteParsed');
                    
                    $platform   = $record->getField('platform text');
                    $ages       = $record->getField('Age Range');
                    $subject    = $record->getField('teaches text');
                    
                    $rating     = $record->getField('standardScore');
                    $edChoice   = $record->getField('edChoice');
                    $ethical    = $record->getField('ethical');
                    
                    echo '<div class = "result-item">';
                    
                        // IMAGE
                        echo '<div class = "result-image">';
                            echo '<a href = "'.$reviewURL.'" title = "Read the CTR Review">';
                                if($thumbnail != NULL and $thumbData != '?')
                                {
                                    echo '<img src = "img.php?-url='.urlencode($thumbnail).'" alt = "Image not available"><br/>';
                                }
                                else
                                {
                                    echo '<div class = "no-image">';
                                        echo '<div class = "no-image-text">Image not available</div>';
                                    echo '</div>';
                                }
                            echo '</a>';
                        echo '</div>'; // /.result-image
                    
                        // TEXT
                        echo '<div class = "result-text">';
                    
                            // TITLE
                            echo '<a href = "'.$reviewURL.'" title = "Read the CTR Review">';
                                echo '<div class = "result-title">';
                                    echo $title;
                                echo '</div>'; // /.title
                            echo '</a>';
                    
                            // COMPANY
                            if($company != NULL)
                            {
                                echo '<div class = "result-company">';
                                  if($copyright != NULL) { echo '&copy; '.$copyright.' '; }
                                  if($website != NULL) 
                                  { 
                                      echo '<a href = "http://'.$website.'" target = "_blank" title = "View '.$company.' website (external link)">'; 
                                  }
                                  echo $company;
                                  if($website != NULL) { echo '</a>'; }
                                echo '</div>'; // /.result-company
                            } // end if $company
                            
                            // PRODUCT INFO
                            echo '<a href = "'.$reviewURL.'" title = "Read the CTR Review">';
                                echo '<div class = "result-info">';
                                    if($platform != NULL)   { echo $platform.'<br/>'; }
                                    if($ages != NULL)       { echo 'Ages: '.$ages.'<br/>'; }
                                    if($subject != NULL)    { echo 'Teaches: '.$subject.'<br/>'; }
                                echo '</div>'; // /.result-info
                            echo '</a>';
                    
                            // RATING
                            if($rating != NULL and $rating != '?')
                            {
                                echo '<div class = "result-rating">';
                                    if($subscriber == true or $temp == true or $license == true or $freeMode == true or ($publisher == true and $searchReviewsCompany == $publisherName))
                                    { 
                                        echo 'CTR Rating: '.$rating.'%';
                                        if($edChoice != NULL) { echo '<div class = "seal"><img src = "images/seal.png" width = "24" height = "24" title = "CTR Editor\'s Choice Award recipient"/></div>'; }
                                        if($ethical != NULL)  { echo '<div class = "seal"><img src = "images/ethical32.png" width = "24" height = "24" title = "CTR Ethical Seal of Approval recipient"/></div>'; }
                                    } // end if $login
                                    else { echo '<a class = "no-print" href = "subscribe.php?redirect='.$reviewURL.'">Log in as a subscriber to view the CTR Rating</a>'; }
                                echo '</div>';
                            } // end if $rating
                    
                        echo '</div>'; // /.result-text
                    echo '</div>'; // /.result-item
                } // end foreach record
                ?>
                </div><!-- /#results-list -->
                
                <?php
				if($subscriber == true or $temp == true or $license == true or $freeMode == true or ($publisher == true and $searchReviewsCompany == $publisherName)) { require 'php/pagenav.php'; }
				else
				{
					echo '<div id = "more-results" class = "center mt-20">';
						echo '<button type = "button" onclick = "openURL(\'subscribe.php?redirect='.urlencode($thisURL).'\')">Log in as a subscriber for more results</button>';
					echo '</div>';
				}
				?>
                
            </div><!-- /#results -->
            <?php require_once 'php/sidebar-right.php';?>
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>