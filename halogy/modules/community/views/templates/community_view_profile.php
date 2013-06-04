{include:header}

<div class="container">

<div id="tpl-community" class="module">

<div class="row-fluid">
	<div class="span6 hero-unit">

		<h1>{page:heading}</h1>
	
		{if user:bio}
			<h3>About Me</h3>
			<div class="bio">
				{user:bio}
			</div>
		{/if}

		{if user:company}
			<h3>My work</h3>

			<p><strong>{user:company}</strong></p>
			
			<div class="bio">
				{user:company-description}
			</div>
		{/if}
		
	</div>
	<div class="span6 hero-unit">
		
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