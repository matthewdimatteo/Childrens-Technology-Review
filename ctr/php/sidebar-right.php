<div class = "sidebar" id = "sidebar-right">
    <div class = "sidebar-heading">Special Topics:</div>
    <?php
    $filters = array();
    if($searchReviewsTopic != NULL) { array_push($filters, array('clear', 'search-reviews-topic', '', 'Clear', 'searchReviewsTopic', 'category')); }
    array_push($filters, array('alltimebest', 'search-reviews-topic', 'AllTimeBestApps', 'All Time Best', 'searchReviewsTopic', 'category'));
    array_push($filters, array('augmented-reality', 'search-reviews-topic', 'Augmented Reality', 'Augmented Reality', 'searchReviewsTopic', 'category'));
    array_push($filters, array('bologna-ragazzi', 'search-reviews-topic', 'BRDP', 'BolognaRagazzi', 'searchReviewsTopic', 'category'));
    array_push($filters, array('classics', 'search-reviews-topic', 'Pioneer', 'Classics', 'searchReviewsTopic', 'category'));
    array_push($filters, array('coding', 'search-reviews-topic', 'Coding', 'Coding', 'searchReviewsTopic', 'category'));
    array_push($filters, array('coop', 'search-reviews-topic', 'Coop', 'Co-op', 'searchReviewsTopic', 'category'));
    array_push($filters, array('ece', 'search-reviews-topic', 'ECE', 'ECE', 'searchReviewsTopic', 'category'));
    //array_push($filters, array('edchoice', 'search-reviews-edchoice', true, 'Editor\'s Choice', 'searchReviewsEdChoice', 'edchoice'));
    //array_push($filters, array('ethical', 'search-reviews-ethical', true, 'Ethical', 'searchReviewsEthical', 'ethical'));
    array_push($filters, array('fred-rogers', 'search-reviews-topic', 'Fred Rogers', 'Fred Rogers', 'searchReviewsTopic', 'category'));
    array_push($filters, array('kapi', 'search-reviews-topic', 'KAPi', 'KAPi', 'searchReviewsTopic', 'category'));
    array_push($filters, array('library-apps', 'search-reviews-topic', 'Library Apps', 'Library Apps', 'searchReviewsTopic', 'category'));
    array_push($filters, array('library-toys', 'search-reviews-topic', 'Library Toys', 'Library Toys', 'searchReviewsTopic', 'category'));
    array_push($filters, array('library-videogames', 'search-reviews-topic', 'Library Video Games', 'Library Videogames', 'searchReviewsTopic', 'category'));
    array_push($filters, array('maker', 'search-reviews-topic', 'Maker', 'Maker', 'searchReviewsTopic', 'category'));
    array_push($filters, array('montessori', 'search-reviews-topic', 'Montessori', 'Montessori', 'searchReviewsTopic', 'category'));
    array_push($filters, array('social', 'search-reviews-topic', 'Social', 'Social', 'searchReviewsTopic', 'category'));
    array_push($filters, array('starter', 'search-reviews-topic', 'Starter', 'Starter', 'searchReviewsTopic', 'category'));
    array_push($filters, array('stem', 'search-reviews-topic', 'STEM', 'STEM', 'searchReviewsTopic', 'category'));
    array_push($filters, array('tablets', 'search-reviews-topic', 'Tablets', 'Tablets', 'searchReviewsTopic', 'category'));
    array_push($filters, array('virtual-reality', 'search-reviews-topic', 'Virtual Reality', 'Virtual Reality', 'searchReviewsTopic', 'category'));
    array_push($filters, array('wosu', 'search-reviews-topic', 'WOSU', 'WOSU', 'searchReviewsTopic', 'category'));
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
            echo '<input type = "radio" name = "'.$filterID.'" id = "'.$filterID.'" value = "'.$param.'" onchange = "'.$function.'" ';
                if($$var == $param) { echo 'checked'; }
            echo '/> '.$label;
        echo '</div>'; // /.filter
    } // end foreach $filter
    ?>
</div><!-- /#right-sidebar -->