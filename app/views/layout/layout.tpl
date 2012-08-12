<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>FBM Toolbox - ProtView</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="https://wwwfbm.unil.ch/favicon.ico"
	type="image/x-icon" />
<link rel="shortcut icon" href="https://wwwfbm.unil.ch/favicon.ico"
	type="image/x-icon" />
<!-- Le styles -->
<?php foreach ($m['css'] as $css): ?>
<link href="<?php echo $css ?>" rel="stylesheet">
<?php endforeach ?>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	<!-- JavaScript -->
	<script type="text/javascript">
		var Application = {};
		Application.ROOTPATH = '<?php echo xUtil::url()?>';
		Application.THEME = 'ui-smoothness';
	</script>
	<?php foreach ($m['js'] as $js): ?>
	<script type="text/javascript" src="<?php echo $js ?>"></script>
	<?php endforeach ?>
	<!-- Le fav and touch icons -->
</head>
<body>
	<!-- BEGIN PAGE -->
	<div id="page">
		<!-- BEBIN HEADER -->
		<div id="header" style="height: 30px">
			<div id='menubar' style='visibility: hidden;'>
				<?php echo xView::load('menubar/menubar')->render() ?>
			</div>
		</div>
		<!-- END HEADER -->
		<!-- BEGIN MAIN -->
		<div id="main" style="height: 540px">
			<!-- BEGIN CONTENT -->
			<div id="content" style="height: 540px">
				<img id="content-loading"
					src="<?php echo xUtil::url('a/js/lib/jqwidgets/resources/loader.gif')?>" />
				<?php if (is_array($d['messages'])) foreach ($d['messages'] as $type => $message): ?>
				<div class="alert <?php echo $type ?>">
					<button class="close" data-dismiss="alert">×</button>
					<?php echo $message ?>
				</div>
				<?php endforeach ?>
				<?php echo $d['html']['content'] ?>
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END MAIN -->
		<!-- BEGIN FOOTER -->
		<div id="footer">&copy; 2012 - Université de Lausanne - All right
			reserved</div>
		<!-- END FOOTER -->
	</div>
	<!-- END PAGE -->
</body>
</html>
