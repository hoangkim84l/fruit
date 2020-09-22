
<?php $this->load->view('admin/support/_common'); ?>

<!-- Main content wrapper -->
<div class="wrapper">

   	<!-- Form -->
	<form class="form" enctype="multipart/form-data" id="form" action="<?php echo $action; ?>" method="post">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img src="<?php echo public_url('admin'); ?>/images/icons/dark/add.png" class="titleIcon" />
					<h6><?php echo lang('edit'); ?> <?php echo lang('mod_support'); ?></h6>
				</div>
				
				<div class="formRow">
					<label class="formLeft" for="param_name"><?php echo lang('name'); ?>:<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo"><input name="name" id="param_name" value='<?php echo $info->name?>' _autocheck="true" type="text" /></span>
						<span name="name_autocheck" class="autocheck"></span>
						<div name="name_error" class="clear error"></div>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="formRow">
					<label class="formLeft" for="param_phone"><?php echo lang('phone'); ?>:<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo"><input name="phone" id="param_phone" value='<?php echo $info->phone?>'  _autocheck="true" type="text" /></span>
						<span name="phone_autocheck" class="autocheck"></span>
						<div name="phone_error" class="clear error"></div>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="formRow">
					<label class="formLeft" for="param_hotline">Hotline:</label>
					<div class="formRight">
						<span class="oneTwo"><input name="hotline" id="param_hotline" value='<?php echo $info->hotline?>'  type="text" /></span>
						<span name="yahoo_autocheck" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="formRow">
					<label class="formLeft" for="param_gmail"><?php echo lang('email'); ?>:</label>
					<div class="formRight">
						<span class="oneTwo"><input name="gmail" id="param_gmail" value='<?php echo $info->gmail?>'  type="text" /></span>
						<span name="gmail_autocheck" class="autocheck"></span>
						<div name="gmail_error" class="clear error"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_skype"><?php echo lang('skype'); ?>:</label>
					<div class="formRight">
						<span class="oneTwo"><input name="skype" id="param_skype" value="<?php echo $info->skype?>" type="text"/></span>
						<span name="skype_autocheck" class="autocheck"></span>
						<div name="skype_error" class="clear error"><?php echo form_error('skype')?></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_fanpage_fb">Fanpage Facebook:</label>
					<div class="formRight">
						<span class="oneTwo"><input name="fanpage_fb" id="param_fanpage_fb" value="<?php echo $info->fanpage_fb?>" type="text"/></span>
						<span name="fanpage_fb_autocheck" class="autocheck"></span>
						<div name="fanpage_fb_error" class="clear error"><?php echo form_error('fanpage_fb')?></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_fanpage_twitter">Fanpage Twitter:</label>
					<div class="formRight">
						<span class="oneTwo"><input name="fanpage_twitter" id="param_fanpage_twitter" value="<?php echo $info->fanpage_twitter?>" type="text"/></span>
						<span name="fanpage_twitter_autocheck" class="autocheck"></span>
						<div name="fanpage_twitter_error" class="clear error"><?php echo form_error('fanpage_twitter')?></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_fanpage_linkedin">Fanpage Linkedin:</label>
					<div class="formRight">
						<span class="oneTwo"><input name="fanpage_linkedin" id="param_fanpage_linkedin" value="<?php echo $info->fanpage_linkedin?>" type="text"/></span>
						<span name="fanpage_linkedin_autocheck" class="autocheck"></span>
						<div name="fanpage_linkedin_error" class="clear error"><?php echo form_error('fanpage_linkedin')?></div>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="formRow">
					<label class="formLeft" for="param_site_title">Seo Title</label>
					<div class="formRight">
						<span class="oneTwo"><input name="site_title" id="param_site_title" value="<?php echo $info->site_title?>" type="text"/></span>
						<span name="site_title" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_site_key">Seo Key</label>
					<div class="formRight">
						<span class="oneTwo"><input name="site_key" id="param_site_key" value="<?php echo $info->site_key?>" type="text"/></span>
						<span name="site_key" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_site_desc">Seo Description</label>
					<div class="formRight">
						<span class="oneTwo"><input name="site_desc" id="param_site_desc" value="<?php echo $info->site_desc?>" type="text"/></span>
						<span name="site_desc" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_robots">Seo Robots</label>
					<div class="formRight">
						<span class="oneTwo"><input name="robots" id="param_robots" value="<?php echo $info->robots?>" type="text"/></span>
						<span name="robots" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_author">Seo Author</label>
					<div class="formRight">
						<span class="oneTwo"><input name="author" id="param_author" value="<?php echo $info->author?>" type="text"/></span>
						<span name="author" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_copyright">Seo Copyright</label>
					<div class="formRight">
						<span class="oneTwo"><input name="copyright" id="param_copyright" value="<?php echo $info->copyright?>" type="text"/></span>
						<span name="copyright" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_geo_region">Seo Geo Region</label>
					<div class="formRight">
						<span class="oneTwo"><input name="geo_region" id="param_geo_region" value="<?php echo $info->geo_region?>" type="text"/></span>
						<span name="geo_region" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_geo_placenamen">Seo Geo Placename</label>
					<div class="formRight">
						<span class="oneTwo"><input name="geo_placename" id="param_geo_placename" value="<?php echo $info->geo_placename?>" type="text"/></span>
						<span name="geo_placename" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft">Og Image:</label>
					<div class="formRight">
						<div class="left">
							<input type="file" name="og_image" id="og_image" size="25">
							<img src="<?php echo base_url('upload/logo/'.$info->og_image)?>" style="width:100px;height:70px">
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="param_og_type">Og Type</label>
					<div class="formRight">
						<span class="oneTwo"><input name="og_type" id="param_og_type" value="<?php echo $info->og_type?>" type="text"/></span>
						<span name="og_type" class="autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft">Logo:</label>
					<div class="formRight">
						<div class="left">
							<input type="file" name="image" id="image" size="25">
							<img src="<?php echo base_url('upload/logo/'.$info->logo)?>" style="width:100px;height:70px">
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft">Favicon:</label>
					<div class="formRight">
						<div class="left">
							<input type="file" name="favicon" id="favicon" size="25">
							<img src="<?php echo base_url('upload/logo/'.$info->favicon)?>" style="width:100px;height:70px">
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label for="param_slogan" class="formLeft">Slogan: </label>
					<div class="formRight">
						<span class="oneTwo"><textarea style="height:300px;" cols="" rows="4" _autocheck="true" id="slogan" name="slogan"><?php echo $info->slogan?></textarea></span>
						<span class="autocheck" name="slogan_autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label for="param_site_title" class="formLeft">Chat zalo:<br/>
						<a href="https://drive.google.com/file/d/1750MozMFzqtHkg0zkP5KG6ECo308mx66/view?usp=sharing" target="_blank" style="color:red;">Tài liệu hướng dẩn Chat Zalo</a>
					</label>
					<div class="formRight">
						<span class="oneTwo"><textarea style="height:300px;" cols="" rows="4" _autocheck="true" id="param_zalo" name="zalo"><?php echo $info->zalo?></textarea></span>
						<span class="autocheck" name="site_title_autocheck"></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label for="param_site_title" class="formLeft">Chat facebook:<br/>
						<a href="https://drive.google.com/file/d/18YjdJhPfVprbr3xtcV3cWbxqMNTm22fj/view?usp=sharing" target="_blank" style="color:red;">Tài liệu hướng dẩn Chat Facebook</a>
					</label>
					<div class="formRight">
						<span class="oneTwo"><textarea style="height:300px;" cols="" rows="4" _autocheck="true" id="param_facebook" name="facebook"><?php echo $info->facebook?></textarea></span>
						<span class="autocheck" name="site_title_autocheck"></span>
						<div class="clear error" name="site_title_error"></div>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="formRow">
					<label class="formLeft" for="param_sort_order"><!-- <?php echo lang('sort_order'); ?> --></label>
					<div class="formRight">
						<input name="sort_order" id="param_sort_order"  class="left" value='<?php echo $info->sort_order?>'  style="width:100px;" type="hidden" />
						<span name="sort_order_autocheck" class="autocheck"></span>
						<div name="sort_order_error" class="clear error"></div>
					</div>
					<div class="clear"></div>
				</div>
				
           		<div class="formSubmit">
           			<input type="submit" value="<?php echo lang('button_update'); ?>" class="redB" />
           			<input type="reset" value="<?php echo lang('button_reset'); ?>" class="basic" />
           		</div>
        		<div class="clear"></div>
        		
			</div>
		</fieldset>
	</form>
	
</div>
