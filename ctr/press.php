<?php require_once 'php/autoload.php';?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review - Press and Media Resources</title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center">
                <h1>Press and Media Resources</h1>
                <p>
                <?php
                // link label, link url, new tab
                $editorialLinks = array
                (
                    array('CTR in the News'     , 'https://www.google.com/search?q=children%27s+technology+review', true),
                    array('Editorial Calendar'	, 'calendar.php', false),
                    array('Editorial Guidelines', 'guidelines.php', false),
                    array('Disclaimer'			, 'about.php#disclaimer', false)
                );
                foreach($editorialLinks as $editorialLink)
                {
                    $edLinkLabel 	= $editorialLink[0];
                    $edLinkURL 		= $editorialLink[1];
                    $edLinkBlank	= $editorialLink[2];
                    echo '<div class = "btn-col-20">';
                        echo '<button type = "button" ';
                        if($edLinkBlank == true) 	{ echo 'onclick = "openBlank(\''.$edLinkURL.'\')"'; }
                        else 						{ echo 'onclick = "openURL(\''.$edLinkURL.'\')"'; }
                        echo '>'.$edLinkLabel.'</button>';
                    echo '</div>'; // /.inline left-10 right-10
                }
                ?>
                </p>
                <p><?php require_once 'php/social-media-btns.php';?></p>
                <h3>About Children's Technology Review</h3>
                <div class = "paragraph">
                    Children’s Technology Review (CTR) is a continually updated rubric-driven survey of commercial children’s digital media products, for birth to 15-years.  It is designed to start an educational conversation about commercial interactive media products; with the underlying admission that there is no perfect rating system. Designed for teachers, librarians, publishers and parents, CTR is sold as a <a href = "subscribe.php" title = "Read more about subscription details">subscription</a>. Subscribers are granted unlimited access to the <a href = "home.php" title = "Search our review database">online review database</a>. <a href = "about.php">Read more on our About page</a>.
					<h3>Contact Us</h3>
                </div><!-- /.paragraph -->
                <?php require_once 'php/contact-info.php';?>
            </div><!-- /.center -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>