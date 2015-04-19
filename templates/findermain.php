<html>
	<head>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		<script type="text/javascript" src="http://malsup.github.com/chili-1.7.pack.js"></script>
		<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
		<script type="text/javascript" src="http://malsup.github.com/jquery.easing.1.3.js"></script>
		 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script>
			$(document).ready(function() {
				var width = $('.slide').width();
				var height = $('.slide').height();
				$('.onephoto').width( (width / 4) - 70 );
				$('.onephoto .imgbox').width($('.onephoto').width());
				
				$('#myslider').cycle({ fx: 'scrollLeft', next: '#myslider', timeout:  0, easing:  'easeInOutBack' });	
				$('#myslider2').cycle({ fx: 'scrollLeft', next: '#myslider2', timeout:  0, easing:  'easeInOutBack' });
				$( "#tabs" ).tabs();
			});
		</script>
		<style>
			.table .slide { width:95%; overflow:hidden; text-align: center;}
			.onephoto .imgbox { overflow:hidden; text-align:center; }
			.onephoto p {margin:0px; padding:0px; margin-bottom: 10px; font-family: Verdana; font-size:12px; color: #777777}
			.onephoto { float:left; overflow:hidden; border: 1px solid grey; border-radius: 10px; margin:10px; padding:10px; text-align:center; }
		</style>
	</head>
	<body>
		<div id="tabs">
		
			<ul>
				<li><a href="#tabs-1">Best match</a></li>
				<li><a href="#tabs-2">All other results</a></li>
			</ul>
			
			<div id="tabs-1">
				<div class="table " id="myslider">
					<? $nbr=8; $i = 0; ?>
					<? while(($i < count($data2)) && ($i < 8)): ?>
						<div class="slide">				
							<? $j = 4; ?>

							<? while(($j) && ($i < count($data2))) : ?>
								<? $j--; ?>
							
								<div class="onephoto">
									<p>
										<?=$data2[$i]->visibleUrl; ?> 
									
									</p>	
									<div class="imgbox">
										<img src="<?=$data2[$i]->unescapedUrl; ?>" height="200px" />
									</div>
								</div>
								<? $i++; ?>
							<? endwhile;?>
							<div style="clear:both"></div>
						</div>			
					<? endwhile; ?>
				</div>
			</div>
			
			<div id="tabs-2">
				<div class="table "  id="myslider2">
				<? $nbr=8; ?>
				<? while($i < count($data2)) : ?>
						<div class="slide">				
							<? $j = 4; ?>
							<? while(($j) && ($i < count($data2))) : ?>
								<? $j--; ?>
								<div class="onephoto">
									<p>
										<?=$data2[$i]->weight; ?> -  <?=$data2[$i]->visibleUrl; ?> 
										<? // print_r($img); ?>
									</p>	
									<div class="imgbox">
										<img src="<?=$data2[$i]->unescapedUrl; ?>" height="200px" />
									</div>
								</div>
								<? $i++; ?>
							<? endwhile;?>
							<div style="clear:both"></div>
						</div>			
				<? endwhile; ?>	
				</div>
		
			</div>
		</div>
		
	</body>
</html>
