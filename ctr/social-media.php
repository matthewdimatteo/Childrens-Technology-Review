<?php require_once 'php/autoload.php';?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review - Social Media</title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center">
                <h1>Follow CTR on Social Media</h1>
                <p><?php require_once 'php/social-media-btns.php';?></p>
                
                <!-- FACEBOOK SCRIPT -->
                <div id="fb-root"></div>
                <script>
                (function(d, s, id) 
                {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=568090119955283";
                  fjs.parentNode.insertBefore(js, fjs);
                }
                (document, 'script', 'facebook-jssdk')
                );
                </script>

                <!-- FACEBOOK FEED -->
                <div id = "facebook-feed-container" class = "inline">

                    <!-- PAGE CONTAINER -->
                    <div id = "fb-page-container" class = "mb-20">
                        <div 
                            class = "fb-page" 
                            data-href="https://www.facebook.com/childtech" 
                            data-width="480"
                            data-height="400"
                            data-small-header="false" 
                            data-adapt-container-width="true" 
                            data-hide-cover="false" 
                            data-show-facepile="true" 
                            data-show-posts="true">

                            <div class="fb-xfbml-parse-ignore">
                                <blockquote cite="https://www.facebook.com/childtech">
                                    <a href="https://www.facebook.com/childtech">Children&#039;s Technology Review</a>
                                </blockquote>
                            </div><!-- end page-link -->
                        </div><!-- /.fb-page -->
                    </div><!-- /#fb-page-container .mb-20 -->

                    <!-- LIKE BOX CONTAINER -->
                    <div id = "fb-like-container" class = "mb-20">
                        <div 
                            class = "fb-like" 
                            data-href = "https://www.facebook.com/childtech" 
                            data-layout = "standard" 
                            data-action = "like" 
                            data-show-faces = "true" 
                            data-share = "true">
                        </div><!-- end like-box -->
                    </div><!-- /#fb-like-container .mb-20 -->

                </div><!-- /#facebook-feed-container /.inline -->

                <!-- TWITTER FEED -->
                <div id = "twitter-feed-container" class = "inline">
                    <a class="twitter-timeline"  href="https://twitter.com/childtech" data-widget-id="623597494627241985">Tweets by @childtech</a>
                    <script>
                    !function(d,s,id)
                    {
                        var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                        if(!d.getElementById(id))
                        {
                            js=d.createElement(s);
                            js.id=id;
                            js.src=p+"://platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js,fjs);
                        }
                    }
                    (document,"script","twitter-wjs");
                    </script>
                </div><!-- /#twitter-feed-container /.inline -->
                
                <!-- BROWSER NOTE -->
                <div class = "caption italic">
                    * Note for Firefox users: If the above feeds are not loading, please select the shield icon to the left of your URL field - you may need to allow permission for this page to include third-party content.
                </div><!-- /.caption italic -->
                
            </div><!-- /.center -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>