{include:header}

<h1>{page:heading}</h1>

{if messages}

<table class="default">

	<tr>
		<th class="narrow">From</th>
		<th>Message</th>
		<th class="medium">Date</th>
		<th class="narrow">Delete</th>
	</tr>

	{pagination}

	{messages}
	
		<tr class="{message:class}">

			<td align="center">
				{user:avatar}
				<br />
				<small><strong><a href="{user:link}">{user:name}</a></strong></small>
			</td>

			<td>
				<p>
					<a href="{message:link}">{message:title}</a>
					<br />
					<small>
						{message:body}
					</small>
				</p>
			</td>
			<td><small>{message:date}</small></td>
			<td><a href="/messages/delete_message/{message:id}" onclick="return confirm('This will delete all the messages in the thread.\n\nAre you sure you want to delete these messages?');" class="btn">Delete</a></td>
			
		</tr>
	
	{/messages}

	</table>

	<br class="clear">

	{pagination}

{else}

	<p>You have no messages in your inbox.</p>

{/if}

<div class="search">

	<form method="post" action="/messages/search">

		<label for="searchbox">Search:</label>
        <div class="input-append">
            <input name="query" class="textbox" type="text">
            <button class="btn" type="submit" ><i class="icon-search"></i></button>
        </div>

	</form>

</div>
	
{include:footer}