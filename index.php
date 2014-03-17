<?php
namespace Tspycher;
include_once "code/config.php";
include_once "code/Rss.php";
include_once "code/Twitter.php";

?>

<!DOCTYPE HTML>
<!--
	Astral 2.5 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Astral by HTML5 UP</title>
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
									<h1>Thomas (Tom) Spycher</h1>
									<span class="byline">Software Engineer</span>
								</header>
								<a href="#work" class="jumplink pic">
									<span class="jumplink arrow fa fa-chevron-right"><span>Latest Tweets and News</span></span>
									<img src="images/me.jpg" alt="" />
								</a>
                                <img src="images/Social_Icons/Github.png">
                                <img src="images/Social_Icons/twitter.png">
                                <img src="images/Social_Icons/4sq.png">
                                <img src="images/Social_Icons/g+.png">
                                <img src="images/Social_Icons/facebook.png">

							</article>

						<!-- Work --> 
							<article id="work" class="panel">
								<header>
									<h2>Latest News from Me</h2>
								</header>
								<p>

								</p>
								<!-- Blog Articles / Tweets go here -->
                                <?php
                                    $c = new Config();
                                    $r = new Rss($c->feedUrls);
                                    $t = new Twitter(
                                        $c->username,
                                        $c->consumer_key,
                                        $c->consumer_secret,
                                        $c->oauth_access_token,
                                        $c->oauth_access_token_secret
                                    );

                                    $_r = $r->collect();
                                    $_t = $t->collect();
                                    $data = $_r + $_t;
                                    krsort($data);
                                    foreach($data as $x)
                                        echo $x;
                                ?>
							</article>

						<!-- Email -->
							<article id="email" class="panel">
								<header>
									<h2>Email Me</h2>
								</header>
								<form action="#" method="post">
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

	</body>
</html>