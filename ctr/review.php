<?php
require_once 'php/autoload.php';
$redirect = $reviewSearchURL;
if(isset($_GET['id'])) { require_once 'php/find-review.php'; } else { require_once 'redirect.php'; exit(); } // redirect home if form not set
?>
<!doctype html>
<html>
<head>
<?php require_once 'php/head.php';?>
<title>CTR Review<?php if($title != NULL) { echo ' - '.$title; } ?></title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "review">
            <?php;
                // IF NOT PUBLISHED, DISPLAY A MESSAGE AND LINK HOME, STOP LOADING THE PAGE
                if($published == NULL)
                {
                    echo '<div class = "error-message center">This review has not been published. <a href = "'.$reviewSearchURL.'">Return home</a></div>';
                    exit();
                } // end if !$published
                
                if($imgCount > 0 or $video != NULL) { echo '<div class = "review-body">'; }
                
                // TITLE
                if($title != NULL)
                {
                    echo '<div class = "review-title">';
                        echo $title;
                    echo '</div>';
                } // end if $title
                
                // COPYRIGHT, COMPANY
                if($copyright != NULL or $company != NULL)
                {
                    echo '<div class = "review-company">';
                        if($copyright != NULL) { echo '&copy; '.$copyright.' '; }
                        if($company != NULL)
                        {
                            if($website != NULL)
                            { 
                                echo '<a href = "http://'.$website.'" target = "_blank" title = "View '.$company.' website (external link)">';
                            }
                            echo $company;
                            if($website != NULL) { echo '</a>'; }
                        } // end if $company
                    echo '</div>';
                } // end if $copyright or $company
                
                // DOWNLOAD LINKS
                if($numDownloadLinks > 0)
                {
                    echo '<div class = "download-links">';
                        foreach($downloadLinks as $link)
                        {
                            $storeName = $link[0];
                            $linkURL   = $link[1];
                            $icon = 'images/'.$storeName.'32.png';
                            echo '<div class = "download-link">';
                                echo '<a href = "'.$linkURL.'" target = "_blank" title = "View in app store (external link)">';
                                    echo '<img src = "'.$icon.'" width = "24" height = "24" />';
                                echo '</a>';
                            echo '</div>';
                        } // end foreach $downloadLink
                        echo '<div class = "download-link-disclaimer">External app store. CTR has no commerical connections.</div>';
                    echo '</div>'; // /.download-links
                } // end if $downloadLinks
                
                // PRODUCT INFO
                if($price != NULL)      { echo '<div class = "review-info">'.$price.'</div>'; }
                if($platform != NULL)   { echo '<div class = "review-info">'.$platform.'</div>'; }
                if($ages != NULL)       { echo '<div class = "review-info">Ages: '.$ages.'</div>'; }
                if($subject != NULL)    { echo '<div class = "review-info">Teaches: '.$subject.'</div>'; }
                
                // CTR REVIEW
                if($reviewText != NULL or $rating != NULL)
                {
                    $reviewTextParsed 	= parseLinks($reviewText);
	                $reviewTextParsed 	= nl2br($reviewTextParsed);
                    if($subscriber != true and $temp!= true and $license != true and $freeMode != true and $publisherAccess != true)
					{ $reviewTextParsed = substr($reviewTextParsed, 0, 280).'...'; }
                    echo '<div class = "review-heading">CTR Review</div>';
                    if($dateEntered != NULL) { echo '<div class = "review-date">'.$dateEntered.'</div>'; }
                    
                    // CTR RATING
                    if(($subscriber == true or $temp == true or $license == true or $freeMode == true or $publisherAccess == true) and ($rating != NULL and $rating != '?'))
                    {
                        echo '<div class = "review-rating">';
                            echo 'CTR Rating: '.$rating.'%';
                        
                            // TOGGLE QA
                            echo '<div class = "seal pointer">';
                                echo '<div id = "qa-toggle-down" onclick = "showItem(\'qa-toggle-down\', \'qa-toggle-up\', \'rating-qa\')" title = "Show individual criteria">&#9660</div>';
                                echo '<div id = "qa-toggle-up" class = "hide" onclick = "hideItem(\'qa-toggle-down\', \'qa-toggle-up\', \'rating-qa\')" title = "Hide individual criteria">&#9650</div>';
                            echo '</div>'; // /.seal
                        
                            // SEALS
                            if($edChoice != NULL) { echo '<div class = "seal"><img src = "images/seal.png" width = "24" height = "24" title = "CTR Editor\'s Choice Award recipient"/></div>'; }
                            if($ethical != NULL)  { echo '<div class = "seal"><img src = "images/ethical32.png" width = "24" height = "24" title = "CTR Ethical Seal of Approval recipient"/></div>'; }
                            
                        echo '</div>'; // /.review-rating
                        
                        // RATING QA
                        echo '<div id = "rating-qa" class = "hide">';
                            echo '<div class = "rating-qa">';
                                echo '<div class = "qa-row">';
                                    echo '<div class = "qa-name">Ease of Use:</div>';
                                    echo '<div class = "qa-value">'.$rating1.'/10</div>';
                                echo '</div>'; // /.qa-row
                                echo '<div class = "qa-row">';
                                    echo '<div class = "qa-name">Educational:</div>';
                                    echo '<div class = "qa-value">'.$rating2.'/10</div>';
                                echo '</div>'; // /.qa-row
                                echo '<div class = "qa-row">';
                                    echo '<div class = "qa-name">Entertaining:</div>';
                                    echo '<div class = "qa-value">'.$rating3.'/10</div>';
                                echo '</div>'; // /.qa-row
                                echo '<div class = "qa-row">';
                                    echo '<div class = "qa-name">Design Features:</div>';
                                    echo '<div class = "qa-value">'.$rating4.'/10</div>';
                                echo '</div>'; // /.qa-row
                                echo '<div class = "qa-row-last">';
                                    echo '<div class = "qa-name">Value:</div>';
                                    echo '<div class = "qa-value">'.$rating5.'/10</div>';
                                echo '</div>'; // /.qa-row
                                echo '<div class = "qa-row-total">';
                                    echo '<div class = "qa-name">Total:</div>';
                                    echo '<div class = "qa-value">'.$rating.'%</div>';
                                echo '</div>'; // /.qa-row
                            echo '</div>'; // /.rating-qa
                        echo '</div>'; // /#rating-qa /.hide
                    } // end if $rating
                    
                    // REVIEW TEXT
                    echo '<div class = "review-text">'.$reviewTextParsed.'</div>';
					
					// LOG IN FOR MORE BTN
                    if($subscriber != true and $temp != true and $license != true and $freeMode != true and $publisherAccess != true)
                    {
                        echo '<div class = "review-velvet-rope">';
                            echo '<button type = "button" class = "no-print" onclick = "openURL(\'subscribe.php?redirect='.$thisURL.'\')">Log in as a subscriber to see the full review</button>';
                        echo '</div>';
                    } // end if !$subscriber
					
					// EXPORT BTNS (SUBSCRIBERS ONLY)
					else
					{
						echo '<div class = "mt-20"></div>';
						echo '<form name = "export-marc-form" id = "export-marc-form" method = "GET" action = "export.php" target = "_blank">';
							/*
							echo '<input type = "hidden" name = "title" 	value = "'.$title.'" />';
							
							echo '<input type = "hidden" name = "copyright" value = "'.$copyright.'" />';
							echo '<input type = "hidden" name = "publisher" value = "'.$company.'" />';
							echo '<input type = "hidden" name = "price" 	value = "'.$price.'" />';
							echo '<input type = "hidden" name = "platform"  value = "'.$platform.'" />';
							echo '<input type = "hidden" name = "ages" 		value = "'.$ages.'" />';
							echo '<input type = "hidden" name = "subject" 	value = "'.$subject.'" />';
							echo '<input type = "hidden" name = "date" 		value = "'.$dateEntered.'" />';
							echo '<input type = "hidden" name = "review" 	value = "'.$reviewTextParsed.'" />';
							echo '<input type = "hidden" name = "rating" 	value = "'.$rating.'" />';
							echo '<input type = "hidden" name = "rating1" 	value = "'.$rating1.'" />';
							echo '<input type = "hidden" name = "rating2" 	value = "'.$rating2.'" />';
							echo '<input type = "hidden" name = "rating3" 	value = "'.$rating3.'" />';
							echo '<input type = "hidden" name = "rating4" 	value = "'.$rating4.'" />';
							echo '<input type = "hidden" name = "rating5" 	value = "'.$rating5.'" />';
							echo '<input type = "hidden" name = "edchoice" 	value = "'.$edChoice.'" />';
							echo '<input type = "hidden" name = "ethical" 	value = "'.$ethical.'" />';
							*/
							echo '<input type = "hidden" name = "id"  		value = "'.$reviewID.'" />';
							echo '<input type = "hidden" name = "validation"value = "true" />';
							echo '<input type = "hidden" name = "scope" 	value = "marc" />';
							echo '<input type = "hidden" name = "format" 	id = "export-marc-format" />';
							echo '<button type = "button" onclick = "exportMarc(\'tab\')">Export .tab</button> ';
							echo '<button type = "button" onclick = "exportMarc(\'csv\')">Export .csv</button>';
						echo '</form>'; // /.export-marc-form
					} // end else $subscriber
                } // end if $reviewText or $rating
				
				// LEAVE A COMMENT
				if($subscriber == true or $temp == true or $license == true or $publisherAccess == true)
				{
					if($subscriber == true or $temp == true) { $userID = $subscriberID; }
					if($publisher == true)  { $userID = $publisherID; }
					if($license == true)	{ $userID = $licenseName; }
					echo '<h2 class = "no-print">Leave a comment:</h2>';
					echo '<form class = "no-print" id = "comment" name = "comment-form" method = "POST" action = "comment-process.php">';
                        if($subscriber == true or $temp == true)
						{
							echo '<input type = "text" name = "name" required placeholder = "Sign your name..." />';
						}
                        echo '<textarea required name = "comment" rows = "5" placeholder = "Leave a comment..."></textarea>';
                        
						if($publisher != true)
						{
                            echo '<div class = "leave-score">';
                                echo '<div class = "thirds left mt-10">(Optional) Provide a rating:</div>';
                                echo '<div class = "thirds center mt-10">';
                                    echo '<input type = "range" name = "score" id = "score-range" min = "0" max = "100" step = "1" onchange = "updateScoreNum()"/>';
                                echo '</div>'; // /.inline mr-10
                                echo '<div class = "thirds right">';
                                    echo '<input type = "number" name = "score-num" id = "score-num" min = "0" max = "100" onchange = "updateScoreRange()"/> % ';
                                    echo '<button type = "button" onclick = "clearScore()">Clear</button>';
                                echo '</div>'; // /.inline
                            echo '</div>'; // /.leave-score
						} // end if !$publisher
						
						echo '<div class = "form-row-submit">';
                            echo '<input type = "hidden" name = "validation" value = "true" />';
							echo '<input type = "hidden" name = "userID" value = "'.$userID.'" />';
							echo '<input type = "hidden" name = "type" value = "create" />';
							echo '<input type = "hidden" name = "reviewID" value = "'.$reviewID.'" />';
							echo '<input type = "hidden" name = "redirect" value = "'.$thisURL.'#comment" />';
                            echo '<input type = "submit" name = "submit" value = "Post Comment" />';
                        echo '</div>';
                    echo '</form>'; // /#comment
				
                    // COMMENTS
                    if($commentCount > 0)
                    {
                        echo '<div class = "review-heading">'.$commentCount.' Comment'; if($commentCount > 1) { echo 's'; } echo '</div>';
                        $n = 0;
                        $posts = $record->getRelatedSet('comments');
                        foreach($posts as $post)
                        {
                            $n += 1;
                            $commentID = $post->getField('comments::commentID');
                            $commenter = $post->getField('comments::commenter');
                            $usertype  = $post->getField('comments::usertype');
                            $comment   = $post->getField('comments::comment');
                            $score     = $post->getField('comments::rating');
                            $date      = $post->getField('comments::date');
                            $time      = $post->getField('comments::time');
                            if($subscriber == true or $temp == true)  { $commenterID = $post->getField('comments::userID'); }
                            if($publisher == true) { $commenterID = $post->getField('comments::publisherID'); }
                            if($license == true)   { $commenterID = $post->getField('comments::orgName'); }
                            if($userID == $commenterID and $userID != NULL) { $canEdit = true; }
                            if($canEdit == true)
                            {
                                // UPDATE COMMENT FORM
                                echo '<form name = "comment-edit-form" method = "POST" action = "comment-process.php" class = "comment-edit no-print">';
                                    if($subscriber == true or $temp == true)
									{
										echo '<input type = "text" name = "name" required placeholder = "Sign your name..." value = "'.$commenter.'" />';
									}
                                    echo '<textarea required name = "comment" rows = "5" placeholder = "Leave a comment...">'.$comment.'</textarea>';
                                    echo '<div class = "edit-score">';
									
										if($publisher != true)
										{
                                            echo '<div class = "inline mt-10 mr-10 mobile-hide">(Optional) Provide a rating:</div>';
                                            echo '<div class = "inline mr-10 mobile-hide">';
                                                echo '<input type = "number" name = "score-num" min = "0" max = "100" value = "'.$score.'"/> % ';
                                            echo '</div>'; // /.inline
										} // end if !$publisher
										
                                        echo '<div class = "inline mt-10 mr-10">';
                                            echo '<input type = "hidden" name = "validation" value = "true" />';
                                            echo '<input type = "hidden" name = "type" value = "edit" />';
                                            echo '<input type = "hidden" name = "commentID" value = "'.$commentID.'" />';
                                            echo '<input type = "hidden" name = "redirect" value = "'.$thisURL.'#comment" />';
                                            echo '<input type = "submit" name = "submit" value = "Update" class = "no-print"/>';
                                        echo '</div>'; // /.inline
                                        echo '<div class = "inline mt-10 mr-10 delete">';
                                            echo '<button type = "button" onclick = "submitForm(\'comment-delete-form-'.$n.'\')">Delete</button>';
                                        echo '</div>'; // /.inline
                                    echo '</div>'; // /.edit-score
                                echo '</form>';

                                // (HIDDEN) DELETE COMMENT FORM
                                echo '<div class = "hide no-print">';
                                    echo '<form name = "comment-delete-form" id = "comment-delete-form-'.$n.'" method = "POST" action = "comment-process.php">';
                                        echo '<input type = "hidden" name = "validation" value = "true" />';
                                        echo '<input type = "hidden" name = "type" value = "delete" />';
                                        echo '<input type = "hidden" name = "commentID" value = "'.$commentID.'" />';
                                        echo '<input type = "hidden" name = "redirect" value = "'.$thisURL.'#comment" />';
                                    echo '</form>';
                                echo '</div>';
								
								// PRINT-ONLY
								echo '<div class = "print-only comment">';
                                    echo '<div class = "review-date">';
                                        echo '<div class = "inline halves left">'.$commenter.':</div>';
                                        echo '<div class = "inline halves right">'.$date.' '.$time.'</div>';
                                    echo '</div>'; // /.comment-authorship
                                    if($score != NULL) { echo '<div class = "review-rating">Rating: '.$score.'%</div>'; }
                                    echo '<div class = "review-text">'.$comment.'</div>';
                                echo '</div>'; // /.comment
                            } // end else can edit
                            else
                            {
                                echo '<div class = "comment">';
                                    echo '<div class = "review-date">';
                                        echo '<div class = "inline halves left">'.$commenter.':</div>';
                                        echo '<div class = "inline halves right">'.$date.' '.$time.'</div>';
                                    echo '</div>'; // /.comment-authorship
                                    if($score != NULL) { echo '<div class = "review-rating">Rating: '.$score.'%</div>'; }
                                    echo '<div class = "review-text">'.$comment.'</div>';
                                echo '</div>'; // /.comment
                            } // end else can't edit
                        } // end foreach $post
                    } // end if $commentCount > 0
				} // end if can comment
                
                // IMAGES
                if($imgCount > 0 or $video != NULL)
                {
                    echo '</div>'; // /.review-body
                    
                    echo '<div class = "review-images">';
                    
                        // FIRST IMAGE INFOCUS
                        echo '<div class = "review-image-infocus" id = "review-image-infocus-1">';
                            if($subscriber == true or $temp == true or $license == true or $freeMode == true or $publisherAccess == true)
							{ $zoomHover = 'View full-size image'; }
                            else { $zoomHover = 'Log in as a subscriber to view full-size image'; }
                            if($img1 != NULL)
                            {
                                if($subscriber == true or $temp == true or $license == true or $freeMode == true or $publisherAccess == true)
								{ $zoomLink1 = 'zoom.php?id='.$reviewID.'&image=1'; }
                                else { $zoomLink1 = 'subscribe.php?redirect='.urlencode('zoom.php?id='.$reviewID.'&image=1'); }
                                echo '<a href = "'.$zoomLink1.'" title = "'.$zoomHover.'">';
                                    echo '<img src = "img.php?-url='.urlencode($img1).'" alt = "Image not available">';
                                echo '</a>';
                            }
                        echo '</div>'; // /.review-image-infocus /#review-image-infocus-1
                    
                        // IMAGE 2 HIDDEN
                        if($img2 != NULL)
                        {
                            echo '<div class = "hide" id = "review-image-infocus-2">';
                                if($subscriber == true or $temp == true or $license == true or $freeMode == true or $publisherAccess == true)
								{ $zoomLink2 = 'zoom.php?id='.$reviewID.'&image=2'; }
                                else { $zoomLink2 = 'subscribe.php?redirect='.urlencode('zoom.php?id='.$reviewID.'&image=2'); }
                                echo '<a href = "'.$zoomLink2.'" title = "'.$zoomHover.'">';
                                    echo '<img src = "img.php?-url='.urlencode($img2).'" alt = "Image not available">';
                                echo '</a>';
                            echo '</div>'; // /.review-image-infocus /#image-infocus-2
                        } // end if $img2
                        
                        // IMAGE 3 HIDDEN
                        if($img3 != NULL)
                        {
                            echo '<div class = "hide" id = "review-image-infocus-3">';
                                if($subscriber == true or $temp == true or $license == true or $freeMode == true or $publisherAccess == true)
								{ $zoomLink3 = 'zoom.php?id='.$reviewID.'&image=3'; }
                                else { $zoomLink3 = 'subscribe.php?redirect='.urlencode('zoom.php?id='.$reviewID.'&image=3'); }
                                echo '<a href = "'.$zoomLink3.'" title = "'.$zoomHover.'">';
                                    echo '<img src = "img.php?-url='.urlencode($img3).'" alt = "Image not available">';
                                echo '</a>';
                            echo '</div>'; // /.review-image-infocus /#image-infocus-3
                        } // end if $img3
                    
                        // GALLERY
                        if($imgCount > 1)
                        {
                            echo '<div class = "review-image-gallery">';
                                
                                if($img1 != NULL)
                                {
                                    echo '<div class = "review-image-gallery-item-selected" id = "image1">';
                                        echo '<img src = "img.php?-url='.urlencode($img1).'" alt = "Image not available" onclick = "imgToggle(1)">';
                                    echo '</div>';
                                } // end if $img1
                                
                                if($img2 != NULL)
                                {
                                    echo '<div class = "review-image-gallery-item" id = "image2">';
                                        echo '<img src = "img.php?-url='.urlencode($img2).'" alt = "Image not available" onclick = "imgToggle(2)">';
                                    echo '</div>';
                                } // end if $img2
                                
                                if($img3 != NULL)
                                {
                                    echo '<div class = "review-image-gallery-item" id = "image3">';
                                        echo '<img src = "img.php?-url='.urlencode($img3).'" alt = "Image not available" onclick = "imgToggle(3)">';
                                    echo '</div>';
                                } // end if $img3
                                
                            echo '</div>'; // /.review-images-gallery
                        } // end if $imgCount > 1
                    
                        // VIDEO
                        if($video != NULL)
                        {
                            echo '<div class = "review-video">';
                                echo '<iframe src = "'.$vidURL.'"></iframe>';
                            echo '</div>'; // /.review-video
                        } // end if $video
                        
                    echo '</div>'; // /.review-images
                } // end if $imgCount or $video
            ?>
            </div><!-- /.review -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>