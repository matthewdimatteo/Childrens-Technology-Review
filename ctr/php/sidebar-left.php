<!-- SIDEBAR -->
<div class = "sidebar" id = "left-sidebar">

    <!-- EDCHOICE, ETHICAL-->
    <div class = "sidebar-heading">Search filters:</div>
    <?php
        $filters = array();
        array_push($filters, array('edchoice', 'search-reviews-edchoice', true, 'Editor\'s Choice', 'searchReviewsEdChoice', 'edchoice'));
        array_push($filters, array('ethical', 'search-reviews-ethical', true, 'Ethical', 'searchReviewsEthical', 'ethical'));
        foreach($filters as $filter)
        {
            $filterID = $filter[0];
            $inputID  = $filter[1];
            $param    = $filter[2];
            $label    = $filter[3];
            $var      = $filter[4];
            $inputName= $filter[5];
            $function = 'addCheckbox(\''.$filterID.'\', \''.$inputID.'\', \''.$param.'\')';
            echo '<div class = "filter" id = "filter-'.$filterID.'" onclick = "'.$function.'">';
                echo '<input type = "checkbox" name = "'.$filterID.'" id = "'.$filterID.'" onchange = "'.$function.'" ';
                    if($$var == $param) { echo 'checked'; }
                echo '/> '.$label;
            echo '</div>'; // /.filter
        } // end foreach $filter
        echo '<div class = "mb-20"></div>';
    ?>

    <!-- AGE RANGE -->
    <div class = "sidebar-heading">Filter by age range:</div>
    <?php
    $filters = array();
    if($searchReviewsAge != NULL) { array_push($filters, array('clear', 'search-reviews-age', '', 'Clear', 'searchReviewsAge', 'age')); }
    array_push($filters, array('baby', 'search-reviews-age', 'B', 'Baby', 'searchReviewsAge', 'age'));
    array_push($filters, array('toddler', 'search-reviews-age', 'T', 'Toddler', 'searchReviewsAge', 'age'));
    array_push($filters, array('preschool', 'search-reviews-age', 'P', 'Preschool', 'searchReviewsAge', 'age'));
    array_push($filters, array('kindergarten', 'search-reviews-age', 'K', 'Kindergarten', 'searchReviewsAge', 'age'));
    array_push($filters, array('early-elementary', 'search-reviews-age', 'E', 'Early Elementary', 'searchReviewsAge', 'age'));
    array_push($filters, array('upper-elementary', 'search-reviews-age', 'U', 'Upper Elementary', 'searchReviewsAge', 'age'));
    array_push($filters, array('middle-high-school', 'search-reviews-age', 'M', 'Middle/High School', 'searchReviewsAge', 'age'));
    foreach($filters as $filter)
    {
        $filterID = $filter[0];
        $inputID  = $filter[1];
        $param    = $filter[2];
        $label    = $filter[3];
        $var      = $filter[4];
        $inputName= $filter[5];
        $function = 'addRadio(\''.$filterID.'\', \''.$inputID.'\', \''.$param.'\')';
        if($$var == $param) { $function = 'clearRadio(\''.$filterID.'\', \''.$inputID.'\', \''.$param.'\')'; }
        echo '<div class = "filter" id = "filter-'.$filterID.'" onclick = "'.$function.'">';
            echo '<input type = "radio" name = "age" id = "'.$filterID.'" value = "'.$param.'" onchange = "'.$function.'" ';
                if($$var == $param) { echo 'checked'; }
            echo '/> '.$label;
        echo '</div>'; // /.filter
    } // end foreach $filter
    ?>
    <br/>

    <!-- PLATFORM -->
    <div class = "sidebar-heading">Filter by platform:</div>
    <?php
    $filters = array();
    if($searchReviewsPlatform != NULL) { array_push($filters, array('clear', 'search-reviews-platform', '', 'Clear', 'searchReviewsPlatform', 'platform')); }
    array_push($filters, array('android', 'search-reviews-platform', 'Android', 'Android', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('apple-tv', 'search-reviews-platform', 'Apple TV', 'Apple TV', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('internet', 'search-reviews-platform', 'Internet', 'Internet', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('iPad', 'search-reviews-platform', 'iPad', 'iOS', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('kindle', 'search-reviews-platform', 'Kindle', 'Kindle', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('mac', 'search-reviews-platform', 'Mac', 'Mac', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('nintendo', 'search-reviews-platform', 'Nintendo', 'Nintendo', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('playstation', 'search-reviews-platform', 'Playstation', 'Playstation', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('smart-toy', 'search-reviews-platform', 'Smart Toy', 'Smart Toy', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('steam', 'search-reviews-platform', 'Steam', 'Steam', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('xbox', 'search-reviews-platform', 'Xbox', 'Xbox', 'searchReviewsPlatform', 'platform'));
    array_push($filters, array('windows', 'search-reviews-platform', 'Windows', 'Windows', 'searchReviewsPlatform', 'platform'));
    foreach($filters as $filter)
    {
        $filterID = $filter[0];
        $inputID  = $filter[1];
        $param    = $filter[2];
        $label    = $filter[3];
        $var      = $filter[4];
        $inputName= $filter[5];
        $function = 'addRadio(\''.$filterID.'\', \''.$inputID.'\', \''.$param.'\')';
        if($$var == $param) { $function = 'clearRadio(\''.$filterID.'\', \''.$inputID.'\', \''.$param.'\')'; }
        echo '<div class = "filter" id = "filter-'.$filterID.'" onclick = "'.$function.'">';
            echo '<input type = "radio" name = "platform" id = "'.$filterID.'" value = "'.$param.'" onchange = "'.$function.'" ';
                if($$var == $param) { echo 'checked'; }
            echo '/> '.$label;
        echo '</div>'; // /.filter
    } // end foreach $filter
    ?>
    <br/>

    <!-- SUBJECT -->
    <div class = "sidebar-heading">Filter by subject:</div>
    <?php
    $filters = array();
    if($searchReviewsSubject != NULL) { array_push($filters, array('clear', 'search-reviews-subject', '', 'Clear', 'searchReviewsSubject', 'subject')); }
    array_push($filters, array('art', 'search-reviews-subject', 'Art', 'Art', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('creativity', 'search-reviews-subject', 'Creativity', 'Creativity', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('health', 'search-reviews-subject', 'Health', 'Health', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('history', 'search-reviews-subject', 'History', 'History', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('logic', 'search-reviews-subject', 'Logic', 'Logic', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('math', 'search-reviews-subject', 'Math', 'Math', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('music', 'search-reviews-subject', 'Music', 'Music', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('peripheral', 'search-reviews-subject', 'Peripheral', 'Peripheral', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('photography', 'search-reviews-subject', 'Photography', 'Photography', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('pe', 'search-reviews-subject', 'Physical', 'PE', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('programming', 'search-reviews-subject', 'Programming', 'Programming', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('reading', 'search-reviews-subject', 'Reading', 'Reading', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('science', 'search-reviews-subject', 'Science', 'Science', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('spanish', 'search-reviews-subject', 'Spanish', 'Spanish', 'searchReviewsSubject', 'subject'));
    array_push($filters, array('utility', 'search-reviews-subject', 'Utility', 'Utility', 'searchReviewsSubject', 'subject'));
    foreach($filters as $filter)
    {
        $filterID = $filter[0];
        $inputID  = $filter[1];
        $param    = $filter[2];
        $label    = $filter[3];
        $var      = $filter[4];
        $inputName= $filter[5];
        $function = 'addRadio(\''.$filterID.'\', \''.$inputID.'\', \''.$param.'\')';
        if($$var == $param) { $function = 'clearRadio(\''.$filterID.'\', \''.$inputID.'\', \''.$param.'\')'; }
        echo '<div class = "filter" id = "filter-'.$filterID.'" onclick = "'.$function.'">';
            echo '<input type = "radio" name = "subject" id = "'.$filterID.'" value = "'.$param.'" onchange = "'.$function.'" ';
                if($$var == $param) { echo 'checked'; }
            echo '/> '.$label;
        echo '</div>'; // /.filter
    } // end foreach $filter
    ?>
    <br/>
</div><!-- /.sidebar -->