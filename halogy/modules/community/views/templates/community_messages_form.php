{include:header}

<h1>Send a Message</h1>

{if errors}
	<div class="alert alert-error">{errors}</div>
{/if}

<form method="post" action="{page:uri}" class="default">

	<label for="to">To:</label>
	<input type="text" name="to" value="{form:to}" id="to" class="form-control" disabled="disabled" />
	<br class="clear" />

	<label for="subject">Subject:</label>
	<input type="text" name="subject" value="{form:subject}" id="subject" class="form-control" />
	<br class="clear" />

	<label for="message">Message:</label>
	<textarea name="message" id="message" class="form-control small">{form:message}</textarea>
	<br class="clear" /><br />

	<input type="submit" value="Send Message" id="submit" class="btn" />
	
</form>
	
{include:footer}