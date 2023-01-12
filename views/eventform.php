<link href="<?php echo WEB_ROOT; ?>library/spry/textfieldvalidation/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="<?php echo WEB_ROOT; ?>library/spry/textfieldvalidation/SpryValidationTextField.js" type="text/javascript"></script>

<link href="<?php echo WEB_ROOT; ?>library/spry/textareavalidation/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="<?php echo WEB_ROOT; ?>library/spry/textareavalidation/SpryValidationTextarea.js" type="text/javascript"></script>

<link href="<?php echo WEB_ROOT; ?>library/spry/selectvalidation/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="<?php echo WEB_ROOT; ?>library/spry/selectvalidation/SpryValidationSelect.js" type="text/javascript"></script>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><b>Book Event</b></h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="<?php echo WEB_ROOT; ?>api/process.php?cmd=book" method="post" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label for="exampleInputEmail1">UserName</label>
				<input type="hidden" name="userId" value="" id="userId" />
				<span id="sprytf_name">
					<select name="name" class="form-control input-sm">
						<option>--select username--</option>
						<?php
						$sql = "SELECT id, name FROM tbl_users";
						$result = dbQuery($sql);
						while ($row = dbFetchAssoc($result)) {
							extract($row);
						?>
							<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
						<?php
						}
						?>
					</select>
					<span class="selectRequiredMsg">Name is required.</span>

				</span>
			</div>


			<div class="form-group">
				<label for="exampleInputEmail1">ชื่อฝ่าย</label>
				<input type="hidden" name="namethai" value="" id="namethai" />
				<span id="sprytf_namethai">
					<select name="namethai" class="form-control input-sm">
						<option>--เลือกฝ่าย--</option>
						<?php
						$sql = "SELECT id,name,namethai FROM tbl_users ";
						$result = dbQuery($sql);
						while ($row = dbFetchAssoc($result)) {
							extract($row);
						?>
							<option value="<?php echo $namethai; ?>"><?php echo $namethai; ?></option>
						<?php
						}
						?>
					</select>
					<span class="selectRequiredMsg">Namethai is required.</span>

				</span>
			</div>

			<div class="form-group">
				<label for="exampleInputEmail1">Address</label>
				<span id="sprytf_address">
					<textarea name="address" class="form-control input-sm" placeholder="Address" id="address"></textarea>
					<span class="textareaRequiredMsg">Address is required.</span>
					<span class="textareaMinCharsMsg">Address must specify at least 10 characters.</span>
				</span>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Phone</label>
				<span id="sprytf_phone">
					<input type="text" name="phone" class="form-control input-sm" placeholder="Phone number" id="phone">
					<span class="textfieldRequiredMsg">Phone number is required.</span>
				</span>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<span id="sprytf_email">
					<input type="text" name="email" class="form-control input-sm" placeholder="Enter email" id="email">
					<span class="textfieldRequiredMsg">Email ID is required.</span>
					<span class="textfieldInvalidFormatMsg">Please enter a valid email (user@domain.com).</span>
				</span>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<label>Reservation Date</label>
						<span id="sprytf_rdate">
							<input type="date" name="rdate" class="form-control" placeholder="YYYY-mm-dd">
							<span class="textfieldRequiredMsg">Date is required.</span>
							<span class="textfieldInvalidFormatMsg">Invalid date Format.</span>
						</span>
					</div>
					<div class="col-xs-6">
						<label>Reservation Time</label>
						<span id="sprytf_rtime">
							<input type="time" name="rtime" class="form-control" placeholder="HH:mm">
							<span class="textfieldRequiredMsg">Time is required.</span>
							<span class="textfieldInvalidFormatMsg">Invalid time Format.</span>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="exampleInputPassword1">No of Peoples</label>
				<span id="sprytf_ucount">
					<input type="text" name="ucount" class="form-control input-sm" placeholder="No of peoples">
					<span class="textfieldRequiredMsg">No of peoples is required.</span>
					<span class="textfieldInvalidFormatMsg">Invalid Format.</span>
			</div>

			<div class="form-group">
				<label for="exampleInputDetails">Details</label>
				<span id="sprytf_details">
					<textarea name="details" class="form-control input-sm" placeholder="Details" id="details"></textarea>
					<span class="textareaRequiredMsg">Details is required.</span>
					<span class="textareaMinCharsMsg">Details must specify at least 10 characters.</span>
				</span>
			</div>

			<!-- sprytf_upload -->

			<div class="form-group">
				<label for="exampleInputUpload">Upload Multiple File(s)</label>
				<span id="sprytf_upload">
					<!-- <form role="form" action="<?php echo WEB_ROOT; ?>api/process.php?cmd=book" method="post"> -->
						<fieldset>
							<!-- <legend>Upload Multiple File(s)</legend> -->
							<section>
								<label>
									<input type="file" name="upload_file1" id="upload_file1"  />
								</label>
								<div id="moreFileUpload"></div>
								<div style="clear:both;"></div>
								<!-- <div id="moreFileUploadLink" style="display:none;margin-left: 10px;">
									<a href="javascript:void(0);" id="attachMore">แนบไฟล์เพิ่มเติม</a>
								</div> -->
							</section>
						</fieldset>
						<div>&nbsp;</div>
						<!-- <footer>
							<input type="submit" name="upload" value="Upload" />
						</footer> -->
					
				</span>
			</div>

			<!-- sprytf_upload -->

			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
	</form>
</div>

<!-- /.box -->
<script type="text/javascript">
	var sprytf_name = new Spry.Widget.ValidationSelect("sprytf_name");
	var sprytf_namethai = new Spry.Widget.ValidationSelect("sprytf_namethai");
	var sprytf_address = new Spry.Widget.ValidationTextarea("sprytf_address", {
		minChars: 6,
		isRequired: true,
		validateOn: ["blur", "change"]
	});
	var sprytf_phone = new Spry.Widget.ValidationTextField("sprytf_phone", 'none', {
		validateOn: ["blur", "change"]
	});
	var sprytf_mail = new Spry.Widget.ValidationTextField("sprytf_email", 'email', {
		validateOn: ["blur", "change"]
	});
	var sprytf_rdate = new Spry.Widget.ValidationTextField("sprytf_rdate", "date", {
		format: "yyyy-mm-dd",
		useCharacterMasking: true,
		validateOn: ["blur", "change"]
	});
	var sprytf_rtime = new Spry.Widget.ValidationTextField("sprytf_rtime", "time", {
		hint: "ตัวอย่าง 20:10",
		useCharacterMasking: true,
		validateOn: ["blur", "change"]
	});
	var sprytf_ucount = new Spry.Widget.ValidationTextField("sprytf_ucount", "integer", {
		validateOn: ["blur", "change"]
	});
	var sprytf_details = new Spry.Widget.ValidationTextarea("sprytf_details", {
		minChars: 10,
		isRequired: true,
		validateOn: ["blur", "change"]
	});
	//  // กรณีต้องการตรวจไฟล์ upload ก่อนจอง
	var sprytf_upload = new Spry.Widget.ValidationSelect("sprytf_upload");
	//
</script>

<script type="text/javascript">
	$('select').on('change', function() {
		//alert( this.value );
		var id = this.value;
		$.get('<?php echo WEB_ROOT . 'api/process.php?cmd=user&userId=' ?>' + id, function(data, status) {
			var obj = $.parseJSON(data);
			$('#userId').val(obj.user_id);
			$('#name').val(obj.user_id);
			$('#namethai').val(obj.user_id);
			$('#email').val(obj.email);
			$('#address').val(obj.address);
			$('#phone').val(obj.phone_no);
		});

	})
</script>

<!-- script upload_file -->

<script type="text/javascript">
	$(document).ready(function() {
		$("input[id^='upload_file']").each(function() {
			var id = parseInt(this.id.replace("upload_file", ""));
			$("#upload_file" + id).change(function() {
				if ($("#upload_file" + id).val() !== "") {
					$("#moreFileUploadLink").show();
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		var upload_number = 2;
		$('#attachMore').click(function() {
			//add more file
			var moreUploadTag = '';
			moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>';
			moreUploadTag += '&nbsp;<input type="file" id="upload_file' + upload_number + '" name="upload_file' + upload_number + '"/>';
			moreUploadTag += '&nbsp;<a href="javascript:void" style="cursor:pointer;" onclick="deletefileLink(' + upload_number + ')">Delete ' + upload_number + '</a></div>';
			$('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreFileUpload');
			upload_number++;
		});
	});
</script>

<script type="text/javascript">
	function deletefileLink(eleId) {
		if (confirm("Are you really want to delete ?")) {
			var ele = document.getElementById("delete_file" + eleId);
			ele.parentNode.removeChild(ele);
		}
	}
</script>

<!-- script upload_file -->