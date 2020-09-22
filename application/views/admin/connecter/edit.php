<!-- head -->
<?php $this->load->view('admin/connecter/head', $this->data)?>

<div class="line"></div>

<div class="wrapper">

	<!-- Form -->
	<form enctype="multipart/form-data" method="post" action="" id="form" class="form">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img class="titleIcon" src="<?php echo public_url('admin')?>/images/icons/dark/add.png">
					<h6>Cập nhật thông tin nhà liên kết</h6>
				</div>

				<ul class="tabs">
					<li class="activeTab"><a href="#tab1">Thông tin chung</a></li>
					<li class=""><a href="#tab3">Giới thiệu</a></li>
				</ul>

				<div class="tab_container">
					<div class="tab_content pd0" id="tab1" style="display: block;">
						<div class="formRow">
							<label for="param_name" class="formLeft">Tên<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo"><input type="text" _autocheck="true" id="param_name" value="<?php echo $connecter->name?>" name="name" reruired="true" ></span>
								<span class="autocheck" name="name_autocheck"></span>
								<div class="clear error" name="name_error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft">Hình ảnh:<span class="req">*</span></label>
							<div class="formRight">
								<div class="left">
									<input type="file" name="image" id="image" size="25">
									<img src="<?php echo base_url('upload/connecter/'.$connecter->image_link)?>" style="width:100px;height:70px">
								</div>
								<div class="clear error" name="image_error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label for="param_name" class="formLeft">Tên</label>
							<div class="formRight">
								<span class="oneTwo"><input type="text" _autocheck="true" id="param_phone" value="<?php echo $connecter->phone?>" name="phone" ></span>
								<span class="autocheck" name="name_autocheck"></span>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label for="param_name" class="formLeft">Email</label>
							<div class="formRight">
								<span class="oneTwo"><input type="text" _autocheck="true" id="param_email" value="<?php echo $connecter->email?>" name="email" ></span>
								<span class="autocheck" name="name_autocheck"></span>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label for="param_name" class="formLeft">Địa chỉ</label>
							<div class="formRight">
								<span class="oneTwo"><input type="text" _autocheck="true" id="param_address" value="<?php echo $connecter->address?>" name="address" ></span>
								<span class="autocheck" name="name_autocheck"></span>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow hide"></div>
					</div>

					<div class="tab_content pd0" id="tab3" style="display: none;">
						<div class="formRow">
							<label class="formLeft">Nội dung:</label>
							<div class="formRight">
								<textarea class="editor" id="param_intro" name="intro"><?php echo $connecter->intro?></textarea>
								<div class="clear error" name="content_error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
					</div>


				</div><!-- End tab_container-->

				<div class="formSubmit">
					<input type="submit" class="redB" value="Cập nhật">
					<input type="reset" class="basic" value="Hủy bỏ">
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</form>
</div>
<div class="clear mt30"></div>
