{include:header}
<script type="text/javascript" src="/static/js/bootstrap-filestyle.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/static/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="/static/css/jquery.Jcrop.css" type="text/css" />
<style>
.upload-bar {
  display: none;
}
</style>
<script>
$(function(){
	// TBD: Set initial crop w/h values to size of image
	function updateCoords(c) {
		$('#crop_x').val(c.x);
		$('#crop_y').val(c.y);
		$('#crop_w').val(c.w);
		$('#crop_h').val(c.h);

        $.cookie("cropData", c);
	};

	// if we have multiple uploads, then this will allow selection of one; then it can be cropped,
	// and the user may proceed to the product selection, etc. pages
	// $('#selectupload').click(function(event){
		// alert("HERE");
		// post('/shop/upload_select', { id: $(this).id }, function(data){
			// // now, generate the single upload with cropping capability
			// alert("NOW, HERE");
		// });
	// });

	$('#upload').Jcrop({
		onChange: updateCoords,
//		onSelect: updateCoords
	});

//	$('div.upload-bar').hide();
	// $('#upload-btn').click(function(event){
		// $('div.upload-form').fadeOut();
		// $('div.upload-bar').fadeIn();
	// });

	$('#upload-form').validate(
	 {
	  rules: {
		email: {
		  required: true,
		  email: true
		},
		photo: {
		  required: true,
		  accept: "image/*"
		}
	  },
	  highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
	  },
	  success: function(element) {
		element
		.text('OK!').addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
		$('div.upload-form').fadeOut();
		$('div.upload-bar').fadeIn();
	  }
	 });
 
	$(":file").filestyle({input: false, classButton: "btn btn-primary", classIcon: "icon-picture", buttonText: "Browse"});
});
</script>
<div class="row-fluid">
  <div class="span6">
    <div class="padded">

      {if errors}
      <div class="alert alert-error">
        <a class="close" data-dismiss="alert">×</a>
        <div class="error">
          {errors}
        </div>
      </div>
      {/if}

      {if message}
      <div class="alert">
        <a class="close" data-dismiss="alert">×</a>
        <div class="message">
          {message}
        </div>
      </div>
      {/if}

      <div class="well">

		<h1>Upload your Photo Here:</h1>

		<div class="upload-bar">
			<h3>
			  Uploading...
			</h3>
			<div class="progress progress-striped active">
				<div class="bar" style="width: 100%;"></div>
			</div>
		</div>

		<div class="upload-form">
        <form class="form-horizontal" id="upload-form" name="upload-form" method="post" action="{page:uri}" enctype="multipart/form-data">
		  <input type="hidden" name="image_quality" value="1" />

          <div class="control-group formrow error">
              <label class="control-label" for="email">Your email:</label>
			  <div class="controls">
				<input type="text" name="email" value="{form:email}" id="email" class="required form-control" />
			  </div>
          </div>

          <div class="control-group formrow error">
              <label class="control-label" for="photo">Your photo:</label>
			  <div class="controls">
              <div class="uploadfile">
                <input type="file" class="required form-control filestyle" id="photo" name="photo" style="width: 220px;" data-input="false" />
              </div>
			  </div>
          </div>

		  {form:csrf}
		  <div class="control-group">
			<div class="controls">
				<button id="upload-btn" type="submit" class="btn btn-primary btn-large">Upload</button>
			</div>
		  </div>
        </form>
		<br class="clear" />
        <h4>NOTE: We ask you to enter your email so you can receive a verification of your upload, as well as keep track of what you've uploaded to our site. You may read our privacy policy <a href="/our-privacy-policy">here</a>.</h4>
		</div>
      </div>
    </div>
  </div>

  <div class="span6">
    <div class="padded">
      <div class="well">
	  <div id="select_image">
	    {if useruploads}
        {useruploads}
		{/if}
	  </div>
	  <div id="crop">
	    {if selectedupload}
        <form class="form-horizontal" id="crop-form" name="crop-form" method="post" action="/shop/update_upload">
		<input type="hidden" name="category" value="print-media-selection" />
		<input type="hidden" id="crop_x" name="crop_x" value="0" />
		<input type="hidden" id="crop_y" name="crop_y" value="0" />
		<input type="hidden" id="crop_w" name="crop_w" value="0" />
		<input type="hidden" id="crop_h" name="crop_h" value="0" />
        {selectedupload}
		<input type="hidden" id="uploadID" name="uploadID" value="{upload:id}" />
        <p>{upload:image}</p>
		<h3>Filename: {upload:caption}</h3>
		<h4>Upload date: {upload:date}</h4>
		<h4>
			You may add a brief description of your photo here (e.g., Uncle Dan and Aunt Jill at the beach):
		</h4>
		<textarea id="description" name="description" rows="3">{upload:description}</textarea>
		<h4>
		  If you wish to crop your photo, place your mouse pointer on the image, then hold the left button while you select the area from the photo that you wish to have printed.
		</h4>
        <h4>
          Image quality: {upload:quality}
        </h4>
        <p>The resolution of your uploaded picture allows for the following maximum dimensions (you will choose the final size on the following pages):</p>
		<h4>{upload:maxheight}"H x {upload:maxwidth}"W</h4>
        {/selectedupload}

		{form:csrf}
		<button type="submit" class="btn btn-primary btn-large">Continue <i class="icon-arrow-right"></i></button>
		</form>
		{/if}
	  </div>
      </div>
    </div>
  </div>
</div>

{include:footer}
