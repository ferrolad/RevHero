<script type="text/javascript" src="<?php echo JS_PATH.'bootstrap-tagsinput.js';?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.textareaCounter.plugin.js';?>"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH.'bootstrap-tagsinput.css';?>" />
<script language="javascript" type="text/javascript">
$(document).ready(function(){

$('#testTextarea2').mouseover(function()
{
	$("#removeCnt").remove();
});
$('#testTextarea2').focus(function()
{
	$("#removeCnt").remove();
});

var countcharBodyText = {
		'maxCharacterSize': 104,
		'originalStyle': 'originalTextareaInfo',
		'warningStyle' : 'warningTextareaInfo',
		'warningNumber': 40,
		//'displayFormat' : '#input Characters | #left Characters Left | #words Words'  
		'displayFormat' : '#left Characters Left'  
};
$('#testTextarea2').textareaCount(countcharBodyText);


var text_max_dest_url = 512;
$('#textbox_desturl').html(text_max_dest_url + ' Characters Left');

$('#dest_url').keyup(function() {
	var text_length = $('#dest_url').val().length;
	var text_remaining = text_max_dest_url - text_length;

	$('#textbox_desturl').html(text_remaining + ' Characters Left');
});

var text_max_headline = 35;
$('#textbox_headline').html(text_max_headline + ' Characters Left');

$('#add_headline').keyup(function() {
	var text_length = $('#add_headline').val().length;
	var text_remaining = text_max_headline - text_length;

	$('#textbox_headline').html(text_remaining + ' Characters Left');
});


$("#dest_url").change(function()
{
	var strURL = $('#pageurl').val();
	var dest_url = $("#dest_url").val().trim();
	$("#loader").show();
	$.post(strURL+"ads/getTitleFromUrl",{url:dest_url},function(data){
		//alert(JSON.stringify(data, null, 4));
		$("#loader").hide();
		if(data.status == 1){
			var max_count = 35;
			var totalCount = data.title.length;
			var finalLeft = max_count-totalCount
			$("#add_headline").val(data.title);
			$("#textbox_headline").html(finalLeft+' Characters Left');
		}else{
			$("#add_headline").val('');
			$("#textbox_headline").html('35 Characters Left');
		}
		
	},'json');
});

	
/*$("#add_headline").keyup(function()
{
	var headlineval = $("#add_headline").val().trim();
	if(headlineval.length >= 35){
		var textval = headlineval.substr(0,35);
		$("#add_headline").val(textval)
	}
});

$("#dest_url").keyup(function()
{
	var desturlval = $("#dest_url").val().trim();
	if(desturlval.length >= 512){
		var textval = desturlval.substr(0,512);
		$("#dest_url").val(textval)
	}
});*/
	
});
</script>
<div class="container">
	<div><h2>Add New Advertise Details</h2></div>
	<div class="well">
		<div class="row">
			 <form class="form-horizontal" action="<?php echo HTTP_ROOT; ?>ads/add" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label">Destination URL</label>
						<div class="controls">
							<input type="url" name="data[Ad][dest_url]" id="dest_url" placeholder=""  class="input-xlarge" required="true" maxlength="512" size="512">
							<div id="textbox_desturl"></div>
							<!--<p class="help-block">Max. 512 Characters</p>-->
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Headline</label>
						<div class="controls">
							<input type="text" name="data[Ad][headline]" id="add_headline" placeholder=""  class="input-xlarge" required="true" maxlength="35" size="35">
							<span id="loader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Updating Headline</span>
						    <div id="textbox_headline"></div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Body Text</label>
						<div class="controls">
							<textarea rows="3"  name="data[Ad][bodytext]" style="resize:none;width:270px;" required="true" id="testTextarea2"></textarea>
							<div id="removeCnt" style="width: 270px;margin-top:-19px;">104 Characters Left</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">CPC</label>
						<div class="controls">
							$ <input type="text" name="data[Ad][cpc]" id="cpc" placeholder="1.85" class="input-xlarge" required="true" style="width:45px;">
						</div>
					</div>	
					<div class="control-group">
						<label class="control-label">CPA</label>
						<div class="controls">
							$ <input type="text" name="data[Ad][cpa]" id="cpa" placeholder="1.25"  class="input-xlarge" required="true" style="width:45px;">
						</div>
					</div>	
					<div class="control-group">
						<label class="control-label">Tags</label>
						<div class="controls">
							<input type="text" name="data[Ad][alltags]" data-role="tagsinput" id="allTags" class="input-xlarge"/>
						</div>
					</div>
					<div class="form-actions">
						<button class="btn btn-primary">Save</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script>
$('#allTags').tagsinput({
  typeahead: {
	  source: function(query) {
		 return $.getJSON('<?php echo HTTP_ROOT; ?>ads/getTag');
	  }
  }
});
</script>