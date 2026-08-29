<?php
require __DIR__ . '/admin/Dbconfig.php';
$publications = require __DIR__ . '/admin/publications.php';

$banner_slides = $connect->query("SELECT * FROM banner_slides WHERE status = 'enabled' ORDER BY sort_order ASC, id ASC")->fetchAll();
$team_members = $connect->query("SELECT * FROM team_members WHERE status = 'enabled' ORDER BY sort_order ASC, id ASC")->fetchAll();
$projects = $connect->query("SELECT * FROM projects WHERE status = 'enabled' ORDER BY sort_order ASC, id ASC")->fetchAll();

// Group each project's popup videos/reviews by project_id for O(1) lookup in the loop below.
$project_videos = [];
foreach ($connect->query("SELECT * FROM project_videos ORDER BY sort_order ASC, id ASC") as $row) {
    $project_videos[$row['project_id']][] = $row;
}
$project_reviews = [];
foreach ($connect->query("SELECT * FROM project_reviews ORDER BY sort_order ASC, id ASC") as $row) {
    $project_reviews[$row['project_id']][] = $row;
}

// Preserves the theme's "<br>" line-break convention in titles while still
// escaping everything else, so admin-entered text can't inject markup/scripts.
function tt_title($str) {
    return str_replace('&lt;br&gt;', '<br>', htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
}

// Accepts whatever YouTube URL form an admin pastes (watch?v=, youtu.be/, or an
// already-canonical /embed/ link) and normalizes it to an embeddable URL.
function youtube_embed_url($url) {
    if (preg_match('~(?:youtu\.be/|youtube\.com/(?:embed/|watch\?v=|watch\?.*&v=))([A-Za-z0-9_-]{6,})~', $url, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>

<!--
	Template:   Nui - Creative Portfolio Showcase HTML Website Template
	Author:     Themetorium
	URL:        https://themetorium.net/
-->

<html lang="en">
	<head>

		<!-- Title -->
		<title>SP CINEMAS</title>

		<!-- Meta -->
		<meta charset="utf-8">
		<meta name="description" content="Download Nui - Creative Portfolio Showcase HTML Website Template that comes with rich features and well-commented code. Made by Themetorium.">
		<meta name="author" content="themetorium.net">

		<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Favicon (http://www.favicon-generator.org/) -->
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon">
		<link rel="icon" href="favicon.png" type="image/x-icon">

		<!-- Your Google Analytics code goes here -->

		<!-- Google fonts (https://www.google.com/fonts) -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"> <!-- Body font -->
		<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet"> <!-- Secondary/Alter font -->

		<!-- Libs and Plugins CSS -->
		<link rel="stylesheet" href="assets/vendor/normalize/normalize.min.css"> <!-- Normalize CSS (https://necolas.github.io/normalize.css/) -->
		<link rel="stylesheet" href="assets/vendor/fontawesome/css/fontawesome-all.min.css"> <!-- Font Icons CSS (https://fontawesome.com) Free version! -->
		<link rel="stylesheet" href="assets/vendor/swiper/css/swiper-bundle.min.css"> <!-- Swiper CSS (https://swiperjs.com/) -->
		<link rel="stylesheet" href="assets/vendor/lightgallery/css/lightgallery.min.css"> <!-- lightGallery CSS (http://sachinchoolur.github.io/lightGallery) -->

		<!-- Template master CSS -->
		<link rel="stylesheet" href="assets/css/helper.css">
		<link id="tt-themecss" rel="stylesheet" href="assets/css/theme.css">

		<!-- Project popup (see admin/index.php "Projects" tab for editing this content) -->
		<style>
			.tt-project-modal { position: fixed; inset: 0; z-index: 9999; display: none; }
			.tt-project-modal.is-open { display: block; }
			.tt-project-modal-overlay { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.75); }
			.tt-project-modal-dialog { position: relative; width: 92vw; max-width: 1100px; max-height: 92vh; margin: 4vh auto; padding: 50px; overflow-y: auto; background-color: var(--tt-main-bg-color); border: 1px solid rgba(255, 255, 255, 0.1); }
			.tt-project-modal-close { position: absolute; top: 12px; right: 16px; background: none; border: none; color: inherit; font-size: 32px; line-height: 1; cursor: pointer; }
			.tt-project-modal-body h2 { margin-top: 0; }
			.tt-project-modal-body iframe { width: 100%; height: 500px; border: 0; }
			@media (max-width: 767px) {
				.tt-project-modal-dialog { width: 96vw; padding: 24px; }
				.tt-project-modal-body iframe { height: 220px; }
			}
			.tt-project-popup-video { margin-bottom: 20px; }
			.tt-project-popup-reviews { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 20px; }
			.tt-project-popup-reviews img { max-height: 40px; max-width: 120px; }
			.tt-project-popup-review-text { color: var(--tt-main-color); text-decoration: underline; }
		</style>

	</head>

	
	<!-- ===========
	///// Body /////
	================
	* Use class "tt-boxed" to enable page boxed layout globally (affects all elements containing class "tt-wrap").
	* Use class "tt-smooth-scroll" to enable page smooth scrolling.
	* Use class "tt-transition" to enable page transitions.
	* Use class "tt-magic-cursor" to enable magic cursor.
	* Note: there may be classes that are specific to this page only!
	-->
	<body id="body" class="tt-transition tt-boxed tt-smooth-scroll tt-magic-cursor">


		<!-- *************************************
		*********** Begin body inner ************* 
		************************************** -->
		<main id="body-inner">

			<!-- Begin page transition (do not remove!!!) 
			=========================== -->
			<div id="page-transition">
				<div class="ptr-overlay"></div>
				<div class="ptr-preloader">
					<div class="ptr-prel-content">
						<!-- Hint: You may need to change the img height and opacity to match your logo type. You can do this from the "theme.css" file (find: ".ptr-prel-image"). -->
						<img src="assets/img/logo.png" class="ptr-prel-image tt-logo-light" alt="Logo">
					</div> <!-- /.ptr-prel-content -->
				</div> <!-- /.ptr-preloader -->
			</div>
			<!-- End page transition -->

			<!-- Begin magic cursor 
			======================== -->
			<div id="magic-cursor">
				<div id="ball"></div>
			</div>
			<!-- End magic cursor --> 


			<!-- *****************************************
			*********** Begin scroll container *********** 
			****************************************** -->
			<div id="scroll-container"> 
				
				<!-- ===================
				///// Begin header /////
				========================
				* Use class "tt-header-fixed" to set header to fixed position.
				-->
				<header id="tt-header" class="tt-header-fixed">
					<div class="tt-header-inner"> <!-- add/remove class "tt-wrap" to enable/disable element boxed layout (class "tt-boxed" is required in <body> tag!). Note: additionally you can use prepared helper class "max-width-*" to add custom width to "tt-wrap". Example: "max-width-1500" (class "tt-wrap" is still required!). More info about helper classes can be found in the file "helper.css". -->

						<div class="tt-header-col">

							<!-- Begin logo 
							================ -->
							<div class="tt-logo"> 
								<a href="index.php">
									<!-- Hint: You may need to change the img height to match your logo type. You can do this from the "theme.css" file (find: ".tt-logo img"). -->
									<img src="assets/img/logo.png" class="tt-logo-light magnetic-item" alt="Logo"> <!-- logo light -->
									<img src="assets/img/logo.png" class="tt-logo-dark magnetic-item" alt="Logo"> <!-- logo dark -->
								</a>
							</div>
							<!-- End logo -->

						</div> <!-- /.tt-header-col -->

						<div class="tt-header-col">

							<!-- Begin overlay menu toggle button -->
							<div id="tt-ol-menu-toggle-btn-wrap">
								<div class="tt-ol-menu-toggle-btn-text-wrap hide-cursor">
									<div class="tt-ol-menu-toggle-btn-text">
										<span class="text-menu" data-hover="Open">Menu</span>
										<span class="text-close">Close</span>
									</div> <!-- /.tt-ol-menu-toggle-btn-text -->
								</div> <!-- /.tt-ol-menu-toggle-btn-text-wrap -->
								<div class="tt-ol-menu-toggle-btn-holder">
									<a href="#" class="tt-ol-menu-toggle-btn magnetic-item"><span></span></a>
								</div> <!-- /.tt-ol-menu-toggle-btn-holder -->
							</div>
							<!-- End overlay menu toggle button -->

							<!-- Begin overlay menu 
							======================== 
							* Use class "tt-ol-menu-count" to enable menu counter.
							-->
							<nav class="tt-overlay-menu tt-ol-menu-count">
								<div class="tt-ol-menu-ghost">SP CINEMAS</div>
								<div class="tt-ol-menu-holder">
									<div class="tt-ol-menu-inner tt-wrap">
										<div class="tt-ol-menu-content">

											<!-- Begin menu list -->
											<ul class="tt-ol-menu-list">

												<li><a href="index.php">Home</a></li>
												<li><a href="#about-us">Who we are</a></li>
												<li><a href="#our-team">Team</a></li>
												<li><a href="#portfolio-grid">What We Do</a></li>
												<li><a href="#portfolio-grid">Our Works</a></li>
												<li><a href="#associations">Our Associations</a></li>
												<li><a href="contact.html">Contact us</a></li>
											</ul>
											<!-- End menu list -->

											<!-- Begin overlay menu social links 
											===================================== -->
											<ul class="tt-ol-menu-social">
												<li><h6 class="tt-ol-menu-social-heading">Social Links:</h6></li>
												<li><a href="https://www.facebook.com/thespcinemas/" target="_blank" rel="noopener">Facebook</a></li>
												<li><a href="https://twitter.com/thespcinemas" target="_blank" rel="noopener">Twitter</a></li>
												<li><a href="https://www.instagram.com/thespcinema/" target="_blank" rel="noopener">instagram</a></li>
												<li><a href="https://www.linkedin.com/company/sp-cinemas/" target="_blank" rel="noopener">Linked In</a></li>
											</ul>
											<!-- End overlay menu social links -->

										</div> <!-- /.tt-ol-menu-content -->
									</div> <!-- /.tt-ol-menu-inner -->
								</div> <!-- /.tt-ol-menu-holder -->
							</nav> 
							<!-- End overlay menu -->

						</div> <!-- /.header-col -->
					</div> <!-- /.header-inner -->
				</header>
				<!-- End header -->

				
				<!-- *************************************
				*********** Begin content wrap *********** 
				************************************** -->
				
				<div id="content-wrap">
					<div class="tt-portfolio-slider cursor-drag-mouse-down" data-speed="1000" data-mousewheel="false" data-keyboard="true" data-simulate-touch="true" data-grab-cursor="true" data-pagination-type="progressbar">

						<!-- Begin swiper container -->
						<div class="swiper">

							<!-- Begin swiper wrapper (required) -->
							<div class="swiper-wrapper">

								<!-- Banner slides are managed from admin/index.php (Home Banner tab) -->
								<?php foreach ($banner_slides as $slide): ?>
								<div class="swiper-slide" data-url="<?php echo htmlspecialchars($slide['link_url'], ENT_QUOTES, 'UTF-8'); ?>" data-title="<?php echo tt_title($slide['title']); ?>" data-category="<?php echo htmlspecialchars($slide['category'], ENT_QUOTES, 'UTF-8'); ?>">
									<div class="tt-portfolio-slider-item cover-opacity-4" data-swiper-parallax="50%">
										<picture>
											<?php if (!empty($slide['mobile_image'])): ?>
											<source media="(max-width: 767px)" data-srcset="assets/img/portfolio/mobile/<?php echo htmlspecialchars($slide['mobile_image'], ENT_QUOTES, 'UTF-8'); ?>">
											<?php endif; ?>
											<img class="tt-psi-image swiper-lazy" src="assets/img/low-qlt-thumb.jpg" data-src="assets/img/portfolio/1920/<?php echo htmlspecialchars($slide['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
										</picture>
									</div> <!-- /.tt-portfolio-slider-item -->
								</div>
								<?php endforeach; ?>

							</div>
							<!-- End swiper wrapper -->

						</div>
						<!-- End swiper container -->
						

						<!-- Begin portfolio slider caption
						==================================== 
						* Use class "psc-center" to align caption.
						* Use class "psc-stroke" to enable caption title stroke style.
						* Note: Titles and URLs are loaded from "swiper-slide" data attributes. Do not change them here!!!
						-->
						<div class="tt-portfolio-slider-caption">
							<div class="tt-ps-caption-inner">
								<div class="tt-psc-elem tt-ps-caption-category"></div>
								<h2 class="tt-psc-elem tt-ps-caption-title"><a href="" data-cursor="View<br>Project"></a></h2>
							</div> <!-- /.tt-ps-caption-inner -->
						</div>
						<!-- End portfolio slider caption -->

						<!-- Begin portfolio slider navigation 
						======================================= -->
						<div class="tt-portfolio-slider-navigation tt-swiper-nav">
							<div class="tt-ps-nav-prev">
								<div class="tt-ps-nav-arrow tt-ps-nav-arrow-prev magnetic-item"><i class="tt-arrow-left"></i></div>
							</div>
							<div class="tt-ps-nav-next">
								<div class="tt-ps-nav-arrow tt-ps-nav-arrow-next magnetic-item"><i class="tt-arrow-right"></i></div>
							</div>
							<div class="tt-ps-nav-pagination"></div>
						</div>
						<!-- End portfolio slider navigation -->

					</div>
					
					<!-- *************************************
					*********** Begin page content *********** 
					************************************** -->
					<div id="page-content">


						<!-- =======================
						///// Begin tt-section /////
						============================ 
						* You can use padding classes if needed. For example "padding-top-xlg-150", "padding-bottom-xlg-150", "no-padding-top", "no-padding-bottom", etc. Note that each situation may be different and each section may need different classes according to your needs. More info about helper classes can be found in the file "helper.css".
						-->
						<div id="about-us" class="tt-section padding-top-xlg-180 padding-bottom-xlg-180 padding-left-sm-3-p padding-right-sm-3-p">
							<div class="tt-section-inner tt-wrap max-width-1000">


								<h2 class="anim-fadeinup tt-heading-title">Who We Are?</h2>
								<div class="anim-fadeinup">
									<p>SP Cinemas was formed by Passionate Team to fill the gap which existed in the market based on their past experiences in the Industry. The Core Team of Sankar, Kishore & Naren used to work for PVP Cinema handling Production, Distribution & Marketing Respectively before branching out independently to start their own Production House.</p>
									<p>Small/Medium budget films with Strong Content and lesser known Actors/New Actors are not able to reach the audience due to various factors including improper Marketing & Distribution to name a few. We at SP Cinemas identify such projects and help the producer in releasing such films. SP Cinemas helps People/Investors with Passion for Cinema in identifying, choosing and executing projects from Script Identification till Release at Theatres for them thereby reducing the risks associated with producing a movie.</p>
									<p>We at SP Cinemas see filmmaking as both a Creative and Business Process. So we are involved right from the scripting stage till the release of the film. We handle the entire filmmaking process chain including Production, Marketing & Distribution. SP Cinemas is committed to bring transparency in Film Making business by making all stake holders accountable. The team consists of seasoned industry professionals who have worked with Madras Talkies, Vijay TV, Raadan Media Works, PVP Cinema, UTV Motion Pictures, Qube Digital Cinema etc.</p>
								</div>

							</div> <!-- /.tt-section-inner -->
						</div>
						<!-- End tt-section -->

					</div>
					<!-- End page content -->


					<!-- *************************************
					*********** Begin page content *********** 
					************************************** -->
					<div id="page-content">

						<!-- =======================
						///// Begin tt-section /////
						============================ 
						* You can use padding classes if needed. For example "padding-top-xlg-150", "padding-bottom-xlg-150", "no-padding-top", "no-padding-bottom", etc. Note that each situation may be different and each section may need different classes according to your needs. More info about helper classes can be found in the file "helper.css".
						-->
						<div id="our-team" class="tt-section padding-top-xlg-150 padding-bottom-xlg-150">
							<div class="tt-section-inner tt-wrap">

								<div class="tt-row padding-bottom-2-p">
									<div class="tt-col-lg-7">

										<!-- Begin tt-Heading 
										====================== 
										* Use class "tt-heading-xsm", "tt-heading-sm", "tt-heading-lg", "tt-heading-xlg" or "tt-heading-xxlg" to set caption size (no class = default size).
										* Use class "tt-heading-stroke" to enable stroke style.
										* Use class "tt-heading-center" to align tt-Heading to center.
										* Use prepared helper class "max-width-*" to add custom width if needed. Example: "max-width-800". More info about helper classes can be found in the file "helper.css".
										-->
										<div class="tt-heading tt-heading-xlg anim-fadeinup">
											<!-- <h3 class="tt-heading-subtitle">OUR TEAM</h3> -->
											<h2 class="tt-heading-title">OUR TEAM</h2> <!-- You can use <br> to break a text line if needed -->
										</div>
										<!-- End tt-Heading -->

									</div> <!-- /.tt-col -->

									<div class="tt-col-lg-5 tt-align-self-center">

										<!-- <div class="anim-fadeinup">
											<h5>When passion, courage, and craftsmanship are put into something, positive things will happen.</h5>
										</div> -->

										<!-- <div class="text-gray anim-fadeinup">
											<p>Lorem ipsum dolor sit amet. Qui velit deleniti et neque illo in reprehenderit numquam. Est officiis eligendi qui enim porro aut quos velit aut ratione accusantium et necessitatibus autem?</p>
										</div> -->

									</div> <!-- /.tt-col -->
								</div> <!-- /.tt-row -->

								<!-- Begin accordion 
								===================== 
								* Use class "tt-ac-sm", "tt-ac-lg", "tt-ac-xlg" or "tt-ac-xxlg" to set accordion size.
								* Use class "tt-ac-borders" to enable borders.
								* Note: Add class "is-open" to the "tt-accordion-content" to make this content open by default.
								-->
								<div class="tt-accordion tt-ac-borders">
									<!-- Team members are managed from admin/index.php (Our Team tab) -->
									<?php foreach ($team_members as $member): ?>
									<div class="tt-accordion-item anim-fadeinup">
										<div class="tt-accordion-heading">
											<div class="tt-ac-head cursor-alter">
												<h3 class="tt-ac-head-title"><?php echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
												<p class=""> <?php echo htmlspecialchars($member['role'], ENT_QUOTES, 'UTF-8'); ?></p>
											</div>

											<div class="tt-accordion-caret-wrap">
												<div class="tt-accordion-caret-inner magnetic-item">
													<div class="tt-accordion-caret"></div>
												</div>
											</div> <!-- /.tt-accordion-caret-wrap -->
										</div> <!-- /.tt-accordion-heading -->
										<div class="tt-accordion-content max-width-800">
											<!-- <h5><?php echo htmlspecialchars($member['role'], ENT_QUOTES, 'UTF-8'); ?></h5> -->
											<p><?php echo nl2br(htmlspecialchars($member['bio'], ENT_QUOTES, 'UTF-8')); ?></p>
										</div> <!-- /.tt-accordion-content -->
									</div> <!-- /.tt-accordion-item -->
									<?php endforeach; ?>

								</div>
								<!-- End accordion -->

							</div> <!-- /.tt-section-inner -->
						</div>
						<!-- End tt-section -->

						<!-- =======================
						///// Begin tt-section /////
						============================ 
						* You can use padding classes if needed. For example "padding-top-xlg-150", "padding-bottom-xlg-150", "no-padding-top", "no-padding-bottom", etc. Note that each situation may be different and each section may need different classes according to your needs. More info about helper classes can be found in the file "helper.css".
						-->
						<div class="tt-section">
							<div class="tt-section-inner">

								<!-- Begin portfolio grid (works combined with tt-Ggrid!)
								========================== 
								* Use class "pgi-hover" to enable portfolio grid item hover effect (behavior depends on "ttgr-gap-*" classes below!).
								* Use class "pgi-cap-hover" to enable portfolio grid item caption hover effect (effect only with class "pgi-cap-inside"! Also no effect on mobile devices!).
								* Use class "pgi-cap-center" to position portfolio grid item caption to center.
								* Use class "pgi-cap-inside" to position portfolio grid item caption to inside.
								--> 
								<div id="portfolio-grid" class="pgi-hover pgi-cap-inside">

									<!-- Begin tt-Grid
									=================== 
									* Use class "ttgr-layout-2", "ttgr-layout-3", "ttgr-layout-4" to set grid layout (columns). No class = one column.
									* Use class "ttgr-layout-1-2", "ttgr-layout-2-1", "ttgr-layout-2-3", "ttgr-layout-3-2", "ttgr-layout-3-4" or "ttgr-layout-4-3" to set grid mixed layout (columns).
									* Use class "ttgr-layout-creative-1" or "ttgr-layout-creative-2" to set grid creative mixed layout (no effect with classes "ttgr-portrait", "ttgr-portrait-half", "ttgr-not-cropped" and "ttgr-shifted").
									* Use class "ttgr-portrait" or "ttgr-portrait-half" to enable portrait mode (no effect with classes "ttgr-layout-creative-1", "ttgr-layout-creative-2" and "ttgr-not-cropped").
									* Use class "ttgr-gap-1", "ttgr-gap-2", "ttgr-gap-3", "ttgr-gap-4", "ttgr-gap-5" or "ttgr-gap-6" to add space between items.
									* Use class "ttgr-not-cropped" to enable not cropped mode (effect only with classes "ttgr-layout-2", "ttgr-layout-3" and "ttgr-layout-4").
									* Use class "ttgr-shifted" to enable shifted layout (effect only with classes "ttgr-layout-2", "ttgr-layout-3" and "ttgr-layout-4").
									-->
									<div class="tt-grid ttgr-layout-3 ttgr-gap-3">
										<div class="tt-heading tt-heading-lg tt-heading-center margin-bottom-120 anim-fadeinup">
											<!-- <h3 class="tt-heading-subtitle text-main">Subtitle</h3> -->
											<h2 class="tt-heading-title">Our Works</h2> <!-- You can use <br> to break a text line if needed -->
										</div>

										<!-- Begin tt-Ggrid top content 
										================================ -->
										<div class="tt-grid-top">

											<!-- Begin tt-Ggrid categories/filter classic
											============================================== -->
											<div class="tt-grid-categories-classic">

												<!-- Begin tt-Ggrid categories
												===============================
												* Use class "ttgr-cat-classic-center" to enable position center (no effect on small screens!).
												* Use class "ttgr-cat-classic-right" to enable position right (no effect on small screens!).
												* Use class "ttgr-cat-classic-colored" to enable colored style.
												-->
												<div class="ttgr-cat-classic-nav ttgr-cat-classic-right ttgr-cat-classic-colored">
													<ul class="ttgr-cat-classic-list">
														<li class="ttgr-cat-classic-item"><a href="#" class="active">Show All</a></li>
														<li class="ttgr-cat-classic-item"><a href="#" data-filter=".branding">Films</a></li>
														<li class="ttgr-cat-classic-item"><a href="#" data-filter=".people">Web Series</a></li>
														<li class="ttgr-cat-classic-item"><a href="#" data-filter=".nature">Commercial</a></li>
													</ul>
												</div>
												<!-- End tt-Ggrid categories-->

											</div>
											<!-- End tt-Ggrid categories/filter classic -->

										</div>
										<!-- End tt-Grid top content -->


										<!-- Begin tt-Grid items wrap 
										============================== -->
										<div class="tt-grid-items-wrap isotope-items-wrap">

											<!-- Projects are managed from admin/index.php (Projects tab) -->
											<?php foreach ($projects as $project): ?>
											<div class="tt-grid-item isotope-item <?php echo htmlspecialchars($project['category'], ENT_QUOTES, 'UTF-8'); ?>">
												<div class="ttgr-item-inner">

													<div class="portfolio-grid-item">
														<a href="javascript:void(0)" class="pgi-image-wrap no-transition" data-cursor="View<br>Project" data-project-popup="<?php echo (int)$project['id']; ?>">
															<div class="pgi-image-holder">
																<div class="pgi-image-inner anim-zoomin">
																	<figure class="pgi-image ttgr-height">
																		<img src="assets/img/portfolio/940/<?php echo htmlspecialchars($project['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="image">
																	</figure> <!-- /.pgi-image -->
																</div> <!-- /.pgi-image-inner -->
															</div> <!-- /.pgi-image-holder -->
														</a> <!-- /.pgi-image-wrap -->

														<div class="pgi-caption">
															<div class="pgi-caption-inner">
																<h2 class="pgi-title">
																	<a href="javascript:void(0)" class="no-transition" data-project-popup="<?php echo (int)$project['id']; ?>"><?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?></a>
																</h2>
																<?php if (trim((string)$project['credits']) !== ''): ?>
																<div class="pgi-categories-wrap">
																	<?php foreach (preg_split('/\r\n|\r|\n/', trim($project['credits'])) as $credit_line): ?>
																	<div class="pgi-category"><?php echo htmlspecialchars($credit_line, ENT_QUOTES, 'UTF-8'); ?></div>
																	<?php endforeach; ?>
																</div> <!-- /.pli-categories-wrap -->
																<?php endif; ?>
															</div> <!-- /.pgi-caption-inner -->
														</div> <!-- /.pgi-caption -->
													</div>
													<!-- End portfolio grid item -->

												</div> <!-- /.ttgr-item-inner -->
											</div>
											<!-- End tt-Grid item -->
											<?php endforeach; ?>
										</div>
										<!-- End tt-Grid items wrap  -->

									</div>
									<!-- End tt-Grid -->

								</div>
								<!-- End portfolio grid -->

								<!-- Hidden per-project popup content, cloned into #tt-project-modal on click (see script near </body>) -->
								<?php foreach ($projects as $project): ?>
								<div class="tt-project-popup-source" data-project-id="<?php echo (int)$project['id']; ?>" style="display:none">
									<h2><?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
									<?php if (trim((string)$project['synopsis']) !== ''): ?>
									<p><strong>Synopsis:</strong></p>
									<p><?php echo nl2br(htmlspecialchars($project['synopsis'], ENT_QUOTES, 'UTF-8')); ?></p>
									<?php endif; ?>
									<?php foreach ($project_videos[$project['id']] ?? [] as $video): ?>
									<p><strong><?php echo htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'); ?>:</strong></p>
									<div class="tt-project-popup-video">
										<iframe src="<?php echo youtube_embed_url($video['youtube_url']); ?>" title="<?php echo htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									</div>
									<?php endforeach; ?>
									<?php if (!empty($project_reviews[$project['id']])): ?>
									<p><strong>Reviews:</strong></p>
									<div class="tt-project-popup-reviews">
										<?php foreach ($project_reviews[$project['id']] as $review):
											$logo = $publications[$review['publication']] ?? null;
										?>
										<a href="<?php echo htmlspecialchars($review['review_url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">
											<?php if ($logo): ?>
											<img src="assets/img/review/<?php echo htmlspecialchars($logo, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($review['publication'], ENT_QUOTES, 'UTF-8'); ?>">
											<?php else: ?>
											<span class="tt-project-popup-review-text"><?php echo htmlspecialchars($review['publication'], ENT_QUOTES, 'UTF-8'); ?></span>
											<?php endif; ?>
										</a>
										<?php endforeach; ?>
									</div>
									<?php endif; ?>
								</div>
								<?php endforeach; ?>

								<!-- Shared project popup modal shell -->
								<div id="tt-project-modal" class="tt-project-modal">
									<div class="tt-project-modal-overlay"></div>
									<div class="tt-project-modal-dialog">
										<button type="button" class="tt-project-modal-close" aria-label="Close">&times;</button>
										<div class="tt-project-modal-body"></div>
									</div>
								</div>


								<!-- Begin tt-pagination (uncomment below code if you want to use pagination)
								========================= 
								* Use class "tt-pagin-center" to align center.
								-->
								<!-- <div class="tt-pagination tt-pagin-center anim-fadeinup">
									<div class="tt-pagin-prev">
										<a href="" class="tt-pagin-item magnetic-item"><i class="fas fa-chevron-left"></i></a>
									</div>
									<div class="tt-pagin-numbers">
										<a href="#" class="tt-pagin-item magnetic-item active">1</a>
										<a href="" class="tt-pagin-item magnetic-item">2</a>
										<a href="" class="tt-pagin-item magnetic-item">3</a>
										<a href="" class="tt-pagin-item magnetic-item">4</a>
									</div>
									<div class="tt-pagin-next">
										<a href="" class="tt-pagin-item tt-pagin-next magnetic-item"><i class="fas fa-chevron-right"></i></a>
									</div>
								</div> -->
								<!-- End tt-pagination -->

							</div> <!-- /.tt-section-inner -->
						</div>
						<!-- End tt-section -->

						

						<!-- =======================
						///// Begin tt-section /////
						============================ 
						* You can use padding classes if needed. For example "padding-top-xlg-150", "padding-bottom-xlg-150", "no-padding-top", "no-padding-bottom", etc. Note that each situation may be different and each section may need different classes according to your needs. More info about helper classes can be found in the file "helper.css".
						-->
						<div id="associations" class="tt-section padding-top-xlg-150 padding-bottom-xlg-150">
							<div class="tt-section-inner tt-wrap">

								<!-- Begin tt-Heading
								======================
								* Use class "tt-heading-xsm", "tt-heading-sm", "tt-heading-lg", "tt-heading-xlg" or "tt-heading-xxlg" to set caption size (no class = default size).
								* Use class "tt-heading-stroke" to enable stroke style.
								* Use class "tt-heading-center" to align tt-Heading to center.
								* Use prepared helper class "max-width-*" to add custom width if needed. Example: "max-width-800". More info about helper classes can be found in the file "helper.css".
								-->
								<div class="tt-heading tt-heading-lg tt-heading-center margin-bottom-120 anim-fadeinup">
									<!-- <h3 class="tt-heading-subtitle text-main">Subtitle</h3> -->
									<h2 class="tt-heading-title">OUR ASSOCIATIONS</h2> <!-- You can use <br> to break a text line if needed -->
								</div>
								<!-- End tt-Heading -->

								<!-- Begin logo wall 
								=====================
								* Use class "cl-col-2", "cl-col-3" or "cl-col-4" to change columns.
								* Hint: for better results make sure all your images are in the same dimensions!
								-->
								<ul class="tt-logo-wall anim-fadeinup">
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/prime.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/prime.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/applause.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/applause.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/shakthi.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/shakthi.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/pramod.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/pramod.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<!-- <li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/hoichoi.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/hoichoi.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li> -->
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/studious-llp.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/studious-llp.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/kalyan-jewellers.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/kalyan-jewellers.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/zion.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/zion.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/vijay-antony.jpg" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/vijay-antony.jpg" class="lv-client-dark" alt="Client">
										</a>
									</li>
									<li>
										<a href="#" class="cursor-alter" target="_blank" rel="noopener">
											<img src="assets/img/clients/power-house.png" class="lv-client-light" alt="Client">
											<img src="assets/img/clients/power-house.png" class="lv-client-dark" alt="Client">
										</a>
									</li>
					
									<!-- Use the below example if you want a list without links -->
									<!-- <li><img src="assets/img/clients/client-1.png" alt="Client"></li> -->
								</ul>
								<!-- End logo wall -->

							</div> <!-- /.tt-section-inner -->
						</div>
						<!-- End tt-section -->


						

						<!-- =======================
						///// Begin tt-section /////
						============================ 
						* You can use padding classes if needed. For example "padding-top-xlg-150", "padding-bottom-xlg-150", "no-padding-top", "no-padding-bottom", etc. Note that each situation may be different and each section may need different classes according to your needs. More info about helper classes can be found in the file "helper.css".
						-->
						<div class="tt-section padding-top-xlg-150 padding-bottom-xlg-150">
							<div class="tt-section-inner tt-wrap">

								<!-- Begin page nav 
								==================== 
								* Use class "tt-pn-center" to align page nav to center.
								* Use class "tt-pn-stroke" to enable title stroke style.
								-->
								<div class="tt-page-nav tt-pn-stroke">
									<a href="contact.html" class="tt-pn-link anim-fadeinup" data-cursor="<i class='fas fa-envelope'></i>">
										<div class="tt-pn-title">Let's talk</div>
										<div class="tt-pn-hover-title">Let's talk</div>
									</a> <!-- /.tt-pn-link -->
									<div class="tt-pn-subtitle anim-fadeinup">Get in Touch</div>
								</div>
								<!-- End page nav -->

							</div> <!-- /.tt-section-inner -->
						</div>
						<!-- End tt-section -->


					</div>
					<!-- End page content -->
					

					<!-- ======================
					///// Begin tt-footer /////
					=========================== -->
					<footer id="tt-footer">
						<div class="tt-footer-inner">

							<!-- Begin footer column 
							========================= -->
							<div class="footer-col tt-align-center-left">
								<div class="footer-col-inner">

									<a href="#" class="tt-btn tt-btn-link scroll-to-top">
										<span class="tt-btn-icon"><i class="fas fa-arrow-up"></i></span>
										<div data-hover="Back to Top">Back to Top</div>
									</a>

								</div> <!-- /.footer-col-inner -->
							</div>
							<!-- Begin footer column -->

							<!-- Begin footer column 
							========================= -->
							<div class="footer-col tt-align-center order-m-last">
								<div class="footer-col-inner">

									<div class="tt-copyright text-gray">
										<a href="http://spcinemas.in/" target="_blank" rel="noopener" class="tt-btn tt-btn-link">
											<span class="tt-btn-icon"><i class="far fa-copyright"></i></span>
											<div data-hover="spcinemas.in">spcinemas.in</div>
										</a>
									</div>

								</div> <!-- /.footer-col-inner -->
							</div>
							<!-- Begin footer column -->

							<!-- Begin footer column 
							========================= -->
							<div class="footer-col tt-align-center-right">
								<div class="footer-col-inner">

									<div class="footer-social">
										<div class="footer-social-text"><span>Follow</span><i class="fas fa-share-alt"></i></div>
										<div class="social-buttons">
											<ul>
												<li><a href="#" class="magnetic-item" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a></li>
												<li><a href="#" class="magnetic-item" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a></li>
												<li><a href="#" class="magnetic-item" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a></li>
												<li><a href="#" class="magnetic-item" target="_blank" rel="noopener"><i class="fab fa-dribbble"></i></a></li>
												<li><a href="#" class="magnetic-item" target="_blank" rel="noopener"><i class="fab fa-behance"></i></a></li>
											</ul>
										</div> <!-- /.social-buttons -->
									</div> <!-- /.footer-social -->

								</div> <!-- /.footer-col-inner -->
							</div>
							<!-- Begin footer column -->

						</div> <!-- /.tt-section-inner -->
					</footer>
					<!-- End tt-footer -->


				</div>
				<!-- End content wrap -->

			</div>
			<!-- End scroll container -->


		</main>
		<!-- End body inner -->


        

		<!-- ====================
		///// Scripts below /////
		===================== -->

		<!-- Core JS -->
		<script src="assets/vendor/jquery/jquery.min.js"></script> <!-- jquery JS (https://jquery.com) -->

		<!-- Libs and Plugins JS -->
		<script src="assets/vendor/gsap/gsap.min.js"></script> <!-- GSAP JS (https://greensock.com/gsap/) -->
		<script src="assets/vendor/gsap/ScrollToPlugin.min.js"></script> <!-- GSAP ScrollToPlugin JS (https://greensock.com/scrolltoplugin/) -->
		<script src="assets/vendor/gsap/ScrollTrigger.min.js"></script> <!-- GSAP ScrollTrigger JS (https://greensock.com/scrolltrigger/) -->

		<script src="assets/vendor/smooth-scrollbar.js"></script> <!-- Smooth Scrollbar JS (https://github.com/idiotWu/smooth-scrollbar/) -->
		<script src="assets/vendor/swiper/js/swiper-bundle.min.js"></script> <!-- Swiper JS (https://swiperjs.com/) -->
		<script src="assets/vendor/isotope/imagesloaded.pkgd.min.js"></script> <!-- imagesloaded JS (more info: https://imagesloaded.desandro.com/) -->
		<script src="assets/vendor/isotope/isotope.pkgd.min.js"></script> <!-- Isotope JS (http://isotope.metafizzy.co) -->
		<script src="assets/vendor/isotope/packery-mode.pkgd.min.js"></script> <!-- Isotope Packery Mode JS (https://isotope.metafizzy.co/layout-modes/packery.html) -->
		<script src="assets/vendor/lightgallery/js/lightgallery-all.min.js"></script> <!-- lightGallery Plugins JS (http://sachinchoolur.github.io/lightGallery) -->
		<script src="assets/vendor/jquery.mousewheel.min.js"></script> <!-- A jQuery plugin that adds cross browser mouse wheel support (https://github.com/jquery/jquery-mousewheel) -->

		<!-- Template master JS -->
		<script src="assets/js/theme.js"></script>

		<!-- Project popup (content managed from admin/index.php "Projects" tab) -->
		<script>
			(function ($) {
				var $modal = $("#tt-project-modal");
				var $modalBody = $modal.find(".tt-project-modal-body");

				// Smooth Scrollbar applies a transform to #scroll-container's content, which
				// breaks position:fixed for anything nested inside it (same reason theme.js
				// moves #tt-header/#tt-footer out of #scroll-container) — move the modal out
				// too so it actually fixes to the viewport instead of the scrolled content.
				if ($("body").hasClass("tt-smooth-scroll") && $modal.closest("#scroll-container").length) {
					$("#scroll-container").before($modal);
				}

				function openProjectPopup(id) {
					var $source = $('.tt-project-popup-source[data-project-id="' + id + '"]');
					if (!$source.length) return;
					$modalBody.html($source.html());
					$modal.addClass("is-open");
					$("html").addClass("tt-no-scroll");
				}

				function closeProjectPopup() {
					$modal.removeClass("is-open");
					$("html").removeClass("tt-no-scroll");
					$modalBody.empty(); // stops any playing video embeds
				}

				$(document).on("click", "[data-project-popup]", function (e) {
					e.preventDefault();
					openProjectPopup($(this).data("project-popup"));
				});

				$modal.find(".tt-project-modal-close, .tt-project-modal-overlay").on("click", function () {
					closeProjectPopup();
				});

				$(document).on("keydown", function (e) {
					if (e.key === "Escape" && $modal.hasClass("is-open")) {
						closeProjectPopup();
					}
				});
			})(jQuery);
		</script>

	</body>

</html>