<?php
$socialMediaLinks = array
(
    array('facebook32.png'	, 'https://www.facebook.com/childtech', 'Find us on Facebook'),
    array('twitter32.png'	, 'https://twitter.com/childtech', 'Find us on Twitter'),
    array('youtube32.png'	, 'https://www.youtube.com/user/childrenstech/videos', 'Find us on YouTube'),
    array('android32.png'	, 'https://play.google.com/store/apps/collection/promotion_familysafe_30017a3_ExpertPicks_CTR_Home', 'View our Editor\'s Choice picks for Android apps on Google Play'),
    array('google32.png'	, 'https://www.google.com/search?q=children%27s+technology+review', 'See our latest Google News results'),
);
foreach($socialMediaLinks as $socialMediaLink)
{
    $smLinkImg 		= $socialMediaLink[0];
    $smLinkURL 		= $socialMediaLink[1];
    $smLinkHover	= $socialMediaLink[2];
    echo '<div class = "btn-col-20">';
        echo '<a href = "'.$smLinkURL.'" target = "_blank" title = "'.$smLinkHover.'"><img src = "images/'.$smLinkImg.'"/></a>';
    echo '</div>'; // /.inline left-10 right-10
}
?>