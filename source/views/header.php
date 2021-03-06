<!-- Site wrapper begins -->
<div id="wrapper" class="container-fluid">
	<!-- Site content begins -->
	<div class="row">
		<aside class="main-sidebar col-md-2">
			<!-- Navigation -->
			<nav class="navbar navbar-default row" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-collapse" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand logo" href="/">
						<img src="../assets/logo.svg" alt="POW! Comic Book Manager" />
		      	<h1>Comic Book Manager</h1>
		      </a>
		    </div>
				<!-- Collect the nav links, forms, and other content for toggling -->
    		<div class="collapse navbar-collapse" id="main-nav-collapse">
					<ul class="nav navbar-nav nolist">
					<?php if ($login->isUserLoggedIn () == true) { ?>
						<li><a href="/"><i class="fa fa-fw fa-tachometer"></i> Dashboard</a></li>
						<li><a href="/profile.php"><i class="fa fa-fw fa-archive"></i> Collection</a></li>
						<li><a href="/add.php"><i class="fa fa-fw fa-plus-circle text-center"></i> Add Items</a></li>
						
						<li class="menu-break"><a href="/feed.php"><i class="fa fa-fw fa-users"></i> User Feed</a></li>
						<li><a href="/settings.php"><i class="fa fa-fw fa-cog text-center"></i> Settings</a></li>
						
						<li class="menu-break"><a href="/about.php"><i class="fa fa-fw fa-question text-center"></i> Who Are We?</a></li>
						<li><a href="/contact.php"><i class="fa fa-fw fa-comment text-center"></i> Contact Us</a></li>
						<li><a href="https://github.com/asanchez78/comicdb/issues" target="_blank"><i class="fa fa-fw fa-bug text-center"></i> Submit a Bug</a></li>
						<li><a data-toggle="modal" data-target="#logoutFormModal"><i class="fa fa-fw fa-sign-out text-center"></i> Logout</a></li>
					<?php } else { ?>
						<li><a href="/about.php"><i class="fa fa-fw fa-question text-center"></i> Who Are We?</a></li>
						<li><a href="/contact.php"><i class="fa fa-fw fa-comment text-center"></i> Contact Us</a></li>
						<li class="menu-break"><a href="/admin/register.php?return=<?php echo $current_page; ?>" class="login"><i class="fa fa-fw fa-plus text-center"></i> Register</a></li>
						<li>
							<button data-toggle="modal" data-target="#loginFormModal" class="btn btn-link login"><i class="fa fa-fw fa-sign-in text-center"></i> Login</button>
						</li>
					<?php } ?>
					</ul>
			</nav>
		</aside>
		<main class="col-md-10" role="main">