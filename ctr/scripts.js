// JavaScript Document

// DEBUG
function testAlert()
{
	alert("test");
}
function outputWidth()
{
	var w = window.innerWidth;
	//alert("window.innerWidth = " + w);
	document.getElementById("debug").innerHTML = "window.innerWidth = " + w;
}
//$(window).on('orientationchange', outputWidth);
//$(window).resize(outputWidth);

// OPEN URL
function openURL(url)
{
	window.location.href = url;
}
// OPEN URL IN NEW WINDOW
function openBlank(url)
{
	window.open(url, '_blank');
}

function submitForm(id)
{
	document.getElementById(id).submit();
}

function showItem(showBtn, hideBtn, elem)
{
	document.getElementById(showBtn).style.display 	= "none";
	document.getElementById(hideBtn).style.display 	= "block";
	document.getElementById(elem).style.display 	= "block";
}
function hideItem(showBtn, hideBtn, elem)
{
	document.getElementById(showBtn).style.display 	= "block";
	document.getElementById(hideBtn).style.display 	= "none";
	document.getElementById(elem).style.display 	= "none";
}

// MENU TOGGLE
document.onclick = function(event)
{
	var target = event.target.id;
    //alert("target: " + target);
	
	// MAIN MENU
	if(target === "menu-btn-show")
	{
		//alert("show main menu");
		showItem("menu-show", "menu-hide", "menu-container");
	}
	else
	{
		//alert("hide main menu");
		hideItem("menu-show", "menu-hide", "menu-container");
	}
};

// LOGO HOVER
function logoHover()
{
	document.getElementById("logo-idle").style.display = "none";
	document.getElementById("logo-hover").style.display = "block";
}
function logoIdle()
{
	document.getElementById("logo-hover").style.display = "none";
	document.getElementById("logo-idle").style.display = "block";
}

// SUBMIT THE MAIN SEARCH FORM
function searchReviews()
{
	document.getElementById("search-reviews-form").submit();
}

// SUBMIT THE EXPORT FORM
function exportReviews(format)
{
	document.getElementById("export-reviews-format").value = format;
	document.getElementById("export-reviews-form").submit();
}
function exportMarc(format)
{
	document.getElementById("export-marc-format").value = format;
	document.getElementById("export-marc-form").submit();
}

// CLEAR REVIEW SEARCH
function clearReviews()
{
	window.location.href = "home.php";
}

// SEARCH OPTIONS - SORT, FILTER
function sortReviews(sort)
{
	document.getElementById("search-reviews-sort").value = sort;
	searchReviews();
}

function toggleCheckmark(id)
{
    var isChecked 	= document.getElementById(id).checked;
	if(isChecked) 	{ document.getElementById(id).checked = ""; }
	else 			{ document.getElementById(id).checked = true; }
}

// INCLUDE OLDER REVIEWS (LARGER FOUNDSET, SLOWER)
function wayBack()
{
    var isChecked 	= document.getElementById("wayback").checked;
	if(isChecked)
    {
        document.getElementById("wayback").checked = "";
        document.getElementById("search-reviews-wayback").value = "";
    }
	else
    {
        document.getElementById("wayback").checked = true;
        document.getElementById("search-reviews-wayback").value = "true";
    }
    searchReviews();
}

// ADD/REMOVE SEARCH FILTER (CHECKBOX)
function addCheckbox(checkboxID, inputID, param)
{
    var isChecked = document.getElementById(checkboxID).checked;
    if(isChecked)
    {
        document.getElementById(checkboxID).checked = "";
        document.getElementById(inputID).value = "";
    }
	else
    {
        document.getElementById(checkboxID).checked = true;
        document.getElementById(inputID).value = param;
    }
    searchReviews();
}

// ADD SEARCH FILTER (RADIO BTN)
function addRadio(radio, inputID, param)
{
    // AS RADIO BTNS
    document.getElementById(radio).checked = true;
    document.getElementById(inputID).value = param;
    searchReviews();
}
// REMOVE SEARCH FILTER (RADIO BTN)
function clearRadio(radioID, inputID, param)
{
    document.getElementById(radioID).checked = false;
    document.getElementById(inputID).value = "";
    searchReviews();
}

// SEARCH WITH ENTER KEY
document.addEventListener('DOMContentLoaded', enterKeySearchReviews, false);
function enterKeySearchReviews()
{
	// ALLOW ENTER KEY FROM KEYWORD INPUT TO SUBMIT SEARCH
	var input = document.getElementById("search-reviews-keyword");
	input.addEventListener( "keyup", function(event) { if(event.keyCode === 13) { searchReviews(); } } );
}

function reviewImagesHide()
{
	var n;
	for(n = 1; n < 4; n++)
	{
		var imgID 	  = "review-image-infocus-" + n;
		var thumbID   = "image" + n;
		var imgElem   = document.getElementById(imgID);
		var thumbElem = document.getElementById(thumbID);
		if(imgElem) 	{ document.getElementById(imgID).className = "hide"; }
		if(thumbElem) 	{ document.getElementById(thumbID).className = "review-image-gallery-item"; }
	}
}
function imgToggle(n)
{
	reviewImagesHide();
	var imgID 	= "review-image-infocus-" + n;
	var thumbID = "image" + n;
	document.getElementById(imgID).className = "review-image-infocus";
	document.getElementById(thumbID).className = "review-image-gallery-item-selected";
}
function reviewImageZoom(url)
{
	//alert("triggered");
	var url = url;
	if(url)
	{
		var qPos 	= url.indexOf('.php?');
		var urlPage = url.substring(0, qPos);
		//alert("url = " + url + "\n" + "qPos = " + qPos + "\n" + "urlPage = " + urlPage);
		if(urlPage === "login")		{ window.location.href = url; }
		else if(urlPage === "zoom") { window.open(url); }
	}
}

function updateScoreNum()
{
	var score = document.getElementById("score-range").value;
	document.getElementById("score-num").value = score;
}
function updateScoreRange()
{
	var score   = document.getElementById("score-num").value;
	document.getElementById("score-range").value = score;
}
function clearScore()
{
	document.getElementById("score-range").value = "";
	document.getElementById("score-num").value = "";
}

// PRINT
function printPage()
{
	window.print();
}

function setPageTitle(title)
{
	//alert("setPageTitle() triggered" + "\n" + "title: " + title);
	if(title) { document.title = title; }
}

// HIGHLIGHT
function highlight(id)
{
	document.getElementById(id).select();
}