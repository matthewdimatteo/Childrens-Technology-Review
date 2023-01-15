<?php
require_once 'php/autoload.php';
$productSubmission = $_SESSION['product-submission'];
if($productSubmission != NULL)
{
	$product 	 = $productSubmission[0];
	$description = $productSubmission[1];
	$price 		 = $productSubmission[2];
	$platform 	 = $productSubmission[3];
	$age 		 = $productSubmission[4];
	$dates 		 = $productSubmission[5];
	$link 		 = $productSubmission[6];
	$codes 		 = $productSubmission[7];
	$img1 		 = $productSubmission[8];
	$img2 		 = $productSubmission[9];
	$img3 		 = $productSubmission[10];
	$company 	 = $productSubmission[11];
	$website 	 = $productSubmission[12];
	$address 	 = $productSubmission[13];
	$contact 	 = $productSubmission[14];
	$email 	 	 = $productSubmission[15];
	$phone 		 = $productSubmission[16];
	$fax 		 = $productSubmission[17];
	$facebook 	 = $productSubmission[18];
	$twitter 	 = $productSubmission[19];
	$youtube 	 = $productSubmission[20];
	$info 		 = $productSubmission[21];
} // end if $productSubmission
?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review - Submit Products for Review</title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center" id = "submit-products">
			
				<!-- ABOUT SUBMITTING PRODUCTS FOR REVIEW -->
                <h1>Submit Products for Review</h1>
                <div class = "paragraph">
					We welcome submissions of children’s interactive media from any publisher of any size or part of the world. Any commercial product is "fair game" for a review, with no exceptions. <!-- You might also want to watch "Working With the Press… Do’s and Don’ts"--> CTR considers apps, commercial video games, software, Internet sites, and smart toys for ages birth to 15 years of age. We don’t look at linear media or non-interactive products, and we can’t ensure that we’ll review every product.<br/>
					<br/>
                    <strong>There are no fees associated with submitting products</strong>. Before you send us products, check to make sure that your title is not already listed in the <a href = "home.php">CTR online review database</a>. You might also want to watch <a href = "https://www.youtube.com/watch?v=rwwnDrbMSMQ" target = "_blank" title = "Watch our video 'Working With the Press… Do’s and Don’ts' on YouTube">"Working With the Press… Do’s and Don’ts"</a>.
                </div><!-- /.paragraph -->
				
				<!-- WHAT WE PICK FOR REVIEW -->
				<h1>What We Pick for Review</h1>
				<div class = "paragraph">
					The number of children’s apps far outnumbers our ability to provide comprehensive coverage. In determining how to spread our attention, we consider the following factors:
					<ul>
						<li>Suggestions from readers. We tune into our subscribers and take requests.</li>
						<li>
							"Consumer Risk" – a free product is less likely to be reviewed, simply because you can give it a test to see for yourself. That’s not to say we don’t review all “free” products. We do consider children’s time in this formula. A product with popular characters does increase the chances we’ll have a look.
						</li>
						<li>Lack of PR resources. We especially look for promising products that might fly under the radar of other review services.</li>
						<li>The first of a series. We try to “nip it in the bud” to point out common errors for a planned series. Perhaps the creator can make changes.</li>
						<li>
							Newsworthiness. We’ll have a quick look, but determine it doesn’t merit the review time because it lacks something we call “newsworthiness.” For example, if an app is the second or third in a series, and the design doesn’t vary from others, we’ll make a note of the new product in the start of the original product with a date stamp, and move on.
						</li>
						<li>
							Does it fill the curriculum grid? We’re always looking for interactive products with learning value; worthy of classroom time and resources.
						</li>
					</ul>
				</div><!-- /.paragraph -->
				
				<!-- PRODUCT SUBMISSION FORM -->
				<h1>Product Submission Form</h1>
				<strong><em>* Indicates required field</em></strong>
				<div class = "paragraph">
					
					<form name = "submit-product-form" method = "POST" action = "submit-process.php">
                        
                        <!-- PRODUCT INFORMATION -->
						<div class = "center"><h3>Product Information</h3></div>
                        <div class = "form-row">
                            <div class = "form-label">*Product Name:</div>
                            <div class = "form-field">
								<input type = "text" name = "product" value = "<?php echo $product;?>" placeholder = "Product Name" required />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Description</div>
                            <div class = "form-field">
								<textarea name = "description" placeholder = "Description" rows = "5"><?php echo $description;?></textarea>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">*Price:</div>
                            <div class = "form-field">
								<input type = "text" name = "price" value = "<?php echo $price;?>" placeholder = "Price" required />
								<div class = "field-caption">The suggested retail (or street) price in USD.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">*Platform:</div>
                            <div class = "form-field">
								<input type = "text" name = "platform" value = "<?php echo $platform;?>" placeholder = "Platform" required />
								<div class = "field-caption">Hardware and platform information.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">*Age:</div>
                            <div class = "form-field">
								<input type = "text" name = "age" value = "<?php echo $age;?>" placeholder = "Age" required />
								<div class = "field-caption">The recommended age(s) for the product.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">*Key Dates:</div>
                            <div class = "form-field">
								<input type = "text" name = "dates" value = "<?php echo $dates;?>" placeholder = "Key Dates" required />
								<div class = "field-caption">The street date (ideally we like to see products 30-60 days prior to the street date.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Link:</div>
                            <div class = "form-field">
								<input type = "text" name = "link" value = "<?php echo $link;?>" placeholder = "Link"/>
								<div class = "field-caption">The URL to download the product, or the product website.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Codes:</div>
                            <div class = "form-field">
								<input type = "text" name = "codes" value = "<?php echo $codes;?>" placeholder = "Codes"/>
								<div class = "field-caption">Any required codes for access or downloading, to give us a child's eye view of your product.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<!-- PRODUCT SCREENSHOTS -->
						<div class = "center"><h3>Product Screenshots (Optional)</h3></div>
						
						<div class = "form-info">
                            Don't send images that are promotional in any way; we won't use those images. For apps, we like three images:
                            <ol type = "1">
                                <li>Typical activity</li>
                                <li>Main menu or choice point</li>
                                <li>Another typical activity; we want to show the child's eye view</li>
                            </ol>
                        </div><!-- /.form-info -->
						
						<div class = "form-row">
                            <div class = "form-label">Image 1 URL:</div>
                            <div class = "form-field">
								<input type = "text" name = "img1" value = "<?php echo $img1;?>" placeholder = "Image 1 URL"/>
								<div class = "field-caption">Primary image - what the child does (typical activity).</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Image 2 URL:</div>
                            <div class = "form-field">
								<input type = "text" name = "img2" value = "<?php echo $img2;?>" placeholder = "Image 2 URL"/>
								<div class = "field-caption">Main menu or choice point.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Image 3 URL:</div>
                            <div class = "form-field">
								<input type = "text" name = "img3" value = "<?php echo $img3;?>" placeholder = "Image 3 URL"/>
								<div class = "field-caption">Support image - another typical activity.</div>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<!-- COMPANY CONTACT INFO -->
						<div class = "center"><h3>Company Contact Information</h3></div>
                        <div class = "form-row">
                            <div class = "form-label">*Company Name:</div>
                            <div class = "form-field">
								<input type = "text" name = "company" value = "<?php echo $company;?>" placeholder = "Company Name" required />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Website:</div>
                            <div class = "form-field">
								<input type = "text" name = "website" value = "<?php echo $website;?>" placeholder = "Website" required />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Address</div>
                            <div class = "form-field">
								<textarea name = "address" placeholder = "Address" rows = "5"><?php echo $address;?></textarea>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">*Contact Name:</div>
                            <div class = "form-field">
								<input type = "text" name = "contact" value = "<?php echo $contact;?>" placeholder = "Contact Name" required />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">*Email:</div>
                            <div class = "form-field">
								<input type = "email" name = "email" value = "<?php echo $email;?>" placeholder = "Email" required />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Phone:</div>
                            <div class = "form-field">
								<input type = "text" name = "phone" value = "<?php echo $phone;?>" placeholder = "Phone" />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Fax:</div>
                            <div class = "form-field">
								<input type = "text" name = "fax" value = "<?php echo $fax;?>" placeholder = "Fax" />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Facebook:</div>
                            <div class = "form-field">
								<input type = "text" name = "facebook" value = "<?php echo $facebook;?>" placeholder = "Facebook" />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">Twitter:</div>
                            <div class = "form-field">
								<input type = "text" name = "twitter" value = "<?php echo $twitter;?>" placeholder = "Twitter" />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<div class = "form-row">
                            <div class = "form-label">YouTube:</div>
                            <div class = "form-field">
								<input type = "text" name = "youtube" value = "<?php echo $youtube;?>" placeholder = "YouTube" />
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<!-- ADDTIONAL INFO -->
						<div class = "center"><h3>Any Additional Information</h3></div>
						<div class = "form-row">
                            <div class = "form-label"></div>
                            <div class = "form-field">
								<textarea name = "info" rows = "5"><?php echo $info;?></textarea>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						
						<?php require_once 'php/captcha.php'; ?>
						
						<!-- SUBMIT BTN -->
						<input type = "hidden" name = "validation" value = "true" />
                        <div class = "form-row-submit">
                            <div class = "center"><input type = "submit" value = "Submit Product" /></div>
                        </div><!-- /.form-row -->
						
						<!-- WHERE TO SEND MATERIALS -->
						<div class = "center"><h3>Where to Send Materials</h3></div>
						<div class = "center italic">
                           	Children's Technology Review<br/>
                            126 Main Street<br/>
                            Flemington, NJ 08822<br/>
                            <br/>
                            908-284-0404 (phone, 9 AM - 3PM, EST)
                        </div><!-- /.form-info -->
						
						<div class = "center caption italic">
							Final packaging and swag is not necessary and has no bearing on determining if a product gets reviewed.
						</div>
					
				</div><!-- /.paragraph -->
				
            </div><!-- /.center -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>


