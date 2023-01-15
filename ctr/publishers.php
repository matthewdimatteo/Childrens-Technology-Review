<?php
require_once 'php/autoload.php';
$publisherInput = $_SESSION['publisherInput'];
$inputCompany	= $publisherInput[0];
$inputEmail		= $publisherInput[1];
$inputPhone		= $publisherInput[2];
?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review - Publisher Accounts</title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center" id = "publisher-lookup">
                <h1>Publisher Accounts</h1>
                <div class = "paragraph">
                    <p>
                        All publishers whose products have been submitted to CTR for review are entitled to a free publisher account. This login provides a publisher profile page and full access to reviews of <strong>only your products</strong>. To look up your account login, please enter your company name, an email address to send the information to, and your company's phone number to validate your identity. You can also <a href = "about.php#contact">contact us</a> to activate your account manually.
						<form name = "publisher-lookup-form" id = "publisher-lookup-form" method = "POST" action = "publisher-lookup.php">
                            <div class = "form-row">
                                <div class = "form-label">Company:</div>
                                <div class = "form-field"><input type = "text" name = "company" required placeholder = "Company Name" value = "<?php echo $inputCompany; ?>" /></div>
                            </div><!-- /.form-row -->
                            <div class = "form-row">
                                <div class = "form-label">Email:</div>
                                <div class = "form-field"><input type = "email" name = "email" required placeholder = "yourname@yourdomain.com" value = "<?php echo $inputEmail; ?>" /></div>
                            </div><!-- /.form-row -->
                            <div class = "form-row">
                                <div class = "form-label">Phone:</div>
                                <div class = "form-field"><input type = "text" name = "phone" required placeholder = "xxx-xxx-xxxx" value = "<?php echo $inputPhone; ?>"/></div>
                            </div><!-- /.form-row -->
							<?php require_once 'php/captcha.php'; ?>
                            <div class = "form-row-submit">
                                <input type = "hidden" name = "validation" value = "true" />
                                <input type = "submit" name = "submit" value = "Lookup Account" />
                            </div><!-- /.form-row-submit -->
                        </form>
                    </p>
                    
					<p>
                        WE BELIEVE that “a review is the start of a conversation.” While we try our best to achieve accurate ratings and write factual reviews, we also know that covering hundreds of complex interactive products each month is far from an exact science. We try our best. FOR THIS REASON we have constructed a free, online forum on children’s interactive products. Both the reviewer and the publisher agree to enter this “space of good discourse” by agreeing to abide by the following guidelines:
                    </p>
					
                    <p>THE PUBLISHER</p>
                    <ol type = "1">
                        <li>
                            Nobody knows my product or my product history and future better than I do. I should therefore have the ability to suggest corrections <!--or add information -->to a review.
                        </li>
                        <li>
                            I have the right to have an exclusive space in the conversation, where I am identified as the publisher or an authorized agent who can speak on behalf of the product.
                        </li>
                        <li>
                            There should be no financial motive for granting access to a response page. In other words, I won’t be held hostage by a bad (or good) rating.
                        </li>
                        <li>
                            My original intellectual property should be referenced and respected. If another publisher is inspired by my work or uses my ideas to create a similar project, I deserve to be referenced.
                        </li>
                        <li>
                            Secrets that I share with a reviewer (such as advance copies or pre-release access to an upcoming product) should always be respected. My embargo dates should be honored.
                        </li>
                        <li>
                            I have the right to question a rating or review. The question “how can I make it better” should have an answer.
                        </li>
                    </ol>
                    <p>THE REVIEWER</p>
                    <ol type = "1">
                        <li>I work on behalf of children.</li>
                        <li>I will use clear, jargon free language.</li>
                        <li>Any product that is “for sale” or marketed to children (or the adults who care or educate them) is fair game for a review.</li>
                        <li>I have the right to question the financial motive, direct or indirect, of any product, even if it is “free.”</li>
                        <li>I will be aware of my bias.</li>
                        <li>I will disclose any and all bias I might have in the body of the review.</li>
                        <li>I will not make money from the sale of the products I review, even indirectly.</li>
                        <li>
                            I will support critical comments or low ratings with examples. Vague language will not be tolerated. I will not randomly “trash” a product.
                        </li>
                        <li>There may come a point in any conversation where “we agree to disagree.”</li>
                        <li>My time and energy is limited and should be respected.</li>
                        <li>
                            I will check in with the boss (real children) whenever possible, and I will keep his or her voice in my head when I write my review and assign my rating.
                        </li>
                    </ol>
                </div><!-- /.paragraph -->
            </div><!-- /.center /#publisher-lookup -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>