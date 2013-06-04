{include:header}

<div class="container">

<div id="tpl-community" class="module">

<div class="row-fluid">
	<div class="span8">

		<h1>{page:heading}</h1>			
		
		<p>This profile is private.</p>
		
	</div>
	<div class="span4">
		
		<div class="avatar">
			{user:avatar}
		</div>
		
		<br />

		<ul class="menu">
			{profile:navigation}
		</ul>
		
		<br />

		<form method="post" action="{site:url}users/search/" class="search">

			<label for="searchbox">Search user:</label>
			<input type="text" name="query" id="searchbox" maxlength="255" value="" class="textbox" />
			<button type="submit" class="btn btn-primary" id="searchbutton"><i class="icon-search"></i></button>
			<br class="clear" />

		</form>
	
	</div>

</div>
</div>
</div>
		
{include:footer}