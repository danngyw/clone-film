<?php
$keyword = get_query_var('s');
?>
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-xs-12" style="margin-bottom:20px">
			<form role="search" action="<?php echo home_url();?>">
				<div class="input-group">
				<span class="twitter-typeahead" style="position: relative; display: inline-block;">

						<input type="text" value="<?php echo $keyword;?>" class="form-control tt-input" id="qSearch" placeholder="Search" name="s" data-provide="typeahead" autocomplete="off" autofocus="" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;">


						<div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-rms"></div></div></span>
				<div class="input-group-btn">
				<button class="btn btn-link" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
				</div>
			</form>
		</div>
	</div>
</div>