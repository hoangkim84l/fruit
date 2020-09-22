<!-- head -->
<?php $this->load->view('admin/banner/head', $this->data)?>

<div class="line"></div>

<div class="wrapper">
	<!-- Form -->
	<form enctype="multipart/form-data" method="post" action="<?php echo admin_url('banner/add')?>" id="form" class="form">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img class="titleIcon" src="<?php echo public_url('admin')?>/images/icons/dark/add.png">
					<h6>Thêm mới banner</h6>
				</div>

				<ul class="tabs">
					<li class="activeTab"><a href="#tab1">Thông tin chung</a></li>
				</ul>

				<div class="tab_container">
					<div class="tab_content pd0" id="tab1" style="display: block;">
						<div class="formRow">
							<label for="param_name" class="formLeft">Tiêu đề:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo"><input type="text" _autocheck="true" id="param_title" name="title" required="true"></span>
								<span class="autocheck" name="name_autocheck"></span>
								<div class="clear error" name="name_error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft">Hình ảnh:</label>
							<div class="formRight">
								<div class="left">
									<input type="file" name="image" id="image" size="25">
								</div>
								<div class="clear error" name="image_error"></div>
							</div>
							<div class="clear"></div>
						</div>


						<div class="formRow hide"></div>
					</div>

				</div><!-- End tab_container-->

				<div class="formSubmit">
					<input type="submit" class="redB" value="Thêm mới">
					<input type="reset" class="basic" value="Hủy bỏ">
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</form>
</div>
<div class="clear mt30"></div>
