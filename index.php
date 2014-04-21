<?php
namespace Tspycher;
session_start();

include_once "code/config.php";
include_once "code/Rss.php";
include_once "code/Twitter.php";

function mailcode($force = false) {
    if(!array_key_exists('mailcode', $_SESSION) or $force)
        $_SESSION['mailcode'] = rand(5, 20);
}

mailcode();
$c = new Config();
?>

<!DOCTYPE HTML>
<!--
	Astral 2.5 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Thomas Spycher</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
			<link rel="stylesheet" href="css/noscript.css" />
		</noscript>
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
	</head>
	<body class="homepage">

		<!-- Wrapper-->
			<div id="wrapper">
				
				<!-- Nav -->
					<nav id="nav">
						<a href="#me" class="fa fa-home active"><span>Home</span></a>
						<a href="#work" class="fa fa-folder"><span>News</span></a>
						<a href="#email" class="fa fa-envelope"><span>Email Me</span></a>
						<a href="http://twitter.com/tspycher" class="fa fa-twitter"><span>Twitter</span></a>
					</nav>

				<!-- Main -->
					<div id="main">
						
						<!-- Me -->
							<article id="me" class="panel">
								<header>
									<h1>Thomas "Tom" Spycher</h1>
									<span class="byline">Passionate Software Engineer,<br /> Car enthusiast and Photographer</span>
                                    <div class="social">
                                        <a href="http://twitter.com/tspycher" target="_blank"> <img src="images/Social_Icons/twitter.png"></a>
                                        <a href="http://github.com/tspycher" target="_blank"> <img src="images/Social_Icons/Github.png"></a>
                                        <a href="https://foursquare.com/tspycher" target="_blank"> <img src="images/Social_Icons/4sq.png"></a>
                                        <a href="http://flickr.com/tspycher" target="_blank"> <img src="images/Social_Icons/flickr.png"></a>
                                        <a href="https://plus.google.com/+ThomasSpycher" target="_blank"> <img src="images/Social_Icons/g+.png"></a>
                                        <a href="http://facebook.com/tspycher" target="_blank"> <img src="images/Social_Icons/facebook.png"></a>
                                        <a href="https://www.xing.com/profile/Thomas_Spycher" target="_blank"> <img src="images/Social_Icons/xing.png"></a>

                                    </div>
                                </header>
								<a href="#work" class="jumplink pic">
									<span class="jumplink arrow fa fa-chevron-right"><span>About & News</span></span>
									<img src="images/me.jpg" alt="" />
								</a>

							</article>

						<!-- Work --> 
							<article id="work" class="panel">
								<header>
									<h2>About Me</h2>
								</header>
								<p>
                                    I'm a <?php echo intval(substr(date('Ymd') - date('Ymd', strtotime('31.05.1984')), 0, -4)); ?> year old passionate Software Engineer. Working for
                                    <a href="http://cyberlink.ch">Cyberlink AG</a> in Zurich and I'm a Co-Founder of <a href="http://zerodine.com">Zerodine</a>. I fall in love with
                                    beautiful software. Mostly I write security and scalability centric software. If not behind my laptop with my earphones plugged in, you will find
                                    me behind a lens and a camera trying to catch a good picture, behind the steering wheel and driving or I'm forcing myself to do something for my health in a
                                    <a href="http://www.crossfit-timeout.ch" target="_blank">Crossfitbox</a>.
								</p>
                                <h3>Latest Photographic Work</h3>

                                    <div>
                                        <span style="display: inline-block; vertical-align: top; height: 0px;">
                                            <a href="http://photo.tspycher.com/" target="_blank">
                                                <img style='margin-right: 4px;vertical-align:top' src='http://photo.tspycher.com/photo.php?set=72157644067521384&num=1&size=q'/>
                                            </a>
                                        </span>
                                        <span style="display: inline-block; vertical-align: top; margin-left:155px;">
                                            Beneath being a passionate programmer i'm also a passionate photographer. My latest work, like the one on the left, you can check out
                                            either on my personal <a href="http://photo.tspycher.com/" target="_blank">Photopage</a> or on <a href="https://flickr.com/tspycher" target="_blank">Flickr</a>.
                                        </span>
                                    </div>
                                <br />
                                <br />
                                <h3>Latest Posts and Tweets</h3>
                                <br />
								<!-- Blog Articles / Tweets go here -->
                                <?php
                                    #$r = new Rss($c->feedUrls);
                                    $t = new Twitter(
                                        $c->username,
                                        $c->consumer_key,
                                        $c->consumer_secret,
                                        $c->oauth_access_token,
                                        $c->oauth_access_token_secret
                                    );

                                    #$_r = $r->collect();
                                    $_r = array();
                                    $_t = $t->collect(5);
                                    $data = $_r + $_t;
                                    krsort($data);
                                    ?>
                                    <div class="feed"><ul>
                                    <?php
                                        foreach($data as $x)
                                            echo $x;
                                    ?>
                                    </ul></div>
							</article>

						<!-- Email -->
							<article id="email" class="panel">
								<header>
									<h2>Email Me</h2>
								</header>
                                <p>Use the form below or just send a mail to <a href="mailto:me@tspycher.com">me@tspycher.com</a>
                                </p>
                                <?php
                                $num1 = $_SESSION['mailcode'] - rand(1, $_SESSION['mailcode']);
                                $num2 = $_SESSION['mailcode'] - $num1;
                                ?>

                                <?php
                                if(!empty($_POST)) {
                                    // Send Email
                                    $valid = true;
                                    $fields = array('name', 'email', 'subject', 'message', 'code');
                                    foreach($fields as $field)
                                        if(!$_POST[$field]) $valid = false;

                                    if ($_POST['code'] != $_SESSION['mailcode'])
                                        $valid = false;

                                    if($valid) {
                                        // Send Mail
                                        $body = sprintf("%s", $_POST['message']);
                                        $subject = sprintf("Websitemessage: %s", $_POST['subject']);
                                        $sender = sprintf("%s <%s>", $_POST['name'], $_POST['email']);
                                        $to = 'me@tspycher.com';
                                        $headers = 'From: '.$sender . "\r\n" .
                                            'Reply-To: '. $sender . "\r\n" .
                                            'X-Mailer: PHP/' . phpversion();
                                        mail($to, $subject, $body, $headers);
                                        mailcode(true);
                                        print '<div class="success">Vielen Dank für die Email</div>';

                                    } else {
                                        print '<div class="error">Die Email konnte nicht gesendet werden!</div>';
                                    }
                                }
                                ?>

								<form action=".#email" method="post">
									<div>
										<div class="row half">
											<div class="6u">
												<input type="text" class="text" name="name" placeholder="Name" />
											</div>
											<div class="6u">
												<input type="text" class="text" name="email" placeholder="Email" />
											</div>
										</div>
										<div class="row half">
											<div class="12u">
												<input type="text" class="text" name="subject" placeholder="Subject" />
											</div>
										</div>
                                        <div class="row half">
                                            <div class="4u">
                                                <input type="text" class="text" name="code" placeholder="<?php echo $num1; ?> + <?php echo $num2; ?> = ?" />
                                            </div>
                                        </div>
										<div class="row half">
											<div class="12u">
												<textarea name="message" placeholder="Message"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input type="submit" class="button" value="Send Message" />
											</div>
										</div>
									</div>
								</form>
							</article>

					</div>
		
				<!-- Footer -->
					<div id="footer">
						<ul class="links">
							<li>&copy; Thomas Spycher</li>
							<li>Design : <a href="http://html5up.net/">HTML5 UP</a></li>
						</ul>
					</div>
		
			</div>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '<?php echo $c->g_trackingId;?>', '<?php echo $c->g_id;?>');
            ga('send', 'pageview');

        </script>
	</body>
</html>