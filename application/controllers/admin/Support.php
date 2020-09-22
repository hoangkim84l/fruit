<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		// Tai cac file thanh phan
		$this->load->model('support_model');
		$this->lang->load('admin/support');
	}
	/**
     * Description: Cập nhật thông tin hổ trợ
     * Function: edit()
     * @author: Di
     * @params: none
     * @return: Update new record
     */
	function edit()
	{
		///lay thong tin chi tiet cua hỗ trợ muon sua
		$id = $this->uri->rsegment('3');
		//lay thong tin cua hỗ trợ
		$info = $this->support_model->get_info($id);
		if(!$info)
		{
		     //gui thong bao that bai
             $this->session->set_flashdata('flash_message', 'Không tồn tại hỗ trợ này');
             redirect(admin_url('support'));
		}
		//load các file để validation form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
		//dieu kien
        $this->form_validation->set_rules('name', 'Tên hỗ trợ', 'required');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|numeric');
        $this->form_validation->set_rules('gmail', 'Email', 'valid_email');
       
        if($this->form_validation->run())
        {
			
			//lay ten file anh minh hoa duoc update len
			$this->load->library('upload_library');
			$upload_path = './upload/logo';
			$upload_data = $this->upload_library->upload($upload_path, 'image');
			$upload_og_image = $this->upload_library->upload($upload_path, 'og_image');
			$upload_favicon = $this->upload_library->upload($upload_path, 'favicon');
			$image_link = '';
			$og_image = '';
			$favicon = '';
			if(isset($upload_data['file_name']))
			{
				$image_link = $upload_data['file_name'];
			}
			if(isset($upload_og_image['file_name']))
			{
				$og_image = $upload_og_image['file_name'];
			}
			if(isset($upload_favicon['file_name']))
			{
				$favicon = $upload_favicon['file_name'];
			}
			
            //lay du lieu ma admin nhap vao form
            $data = array();
            $data['name']       = $this->input->post('name');//ten hỗ trợ
            $data['phone']      = $this->input->post('phone');
            $data['hotline']    = $this->input->post('hotline');
            $data['gmail']      = $this->input->post('gmail');
            $data['skype']      = $this->input->post('skype');
            $data['fanpage_fb']      	= $this->input->post('fanpage_fb');
            $data['fanpage_twitter']    = $this->input->post('fanpage_twitter');
            $data['	fanpage_linkedin']  = $this->input->post('fanpage_linkedin');
			$data['site_title'] = $this->input->post('site_title');
			$data['site_key']   = $this->input->post('site_key');
			$data['site_desc']  = $this->input->post('site_desc');
			$data['robots']  	= $this->input->post('robots');
			$data['author']  	= $this->input->post('author');
			$data['slogan']  	= $this->input->post('slogan');
			$data['copyright']  = $this->input->post('copyright');
			$data['geo_region'] = $this->input->post('geo_region');
			$data['geo_placename']  = $this->input->post('geo_placename');
			$data['og_type']  	= $this->input->post('og_type');
			$data['zalo']       = $this->input->post('zalo');
			$data['facebook']   = $this->input->post('facebook');			
            $data['sort_order'] = $this->input->post('sort_order');//vi tri sắp xếp
			
			if($image_link != '')
			{
				$data['logo'] = $image_link;
			}
			if($og_image != '')
			{
				$data['og_image'] = $og_image;
			}
			if($favicon != '')
			{
				$data['favicon'] = $favicon;
			}
				
            if($this->support_model->update($id, $data))
            {
                //gui thong bao thanh cong
                $this->session->set_flashdata('flash_message', 'Đã cập nhật hỗ trợ thành công');
            }
            else
            {
                //gui thong bao that bai
                $this->session->set_flashdata('flash_message', 'Đã có lỗi trong quá trình cập nhật');
            }
            //chuyen ve trang danh sach cac hỗ trợ
            redirect(admin_url('support'));
        }
        
		// Luu bien gui den view
		$this->data['info']   = $info;
		$this->data['action'] = current_url();
		
		// Hien thi view
		$this->data['temp'] = 'admin/support/edit';
		$this->load->view('admin/main', $this->data);
	}
	/**
     * Description: Lấy danh sách hổ trợ
     * Function: index()
     * @author: Di
     * @params: none
     * @return: List support
     */
	function index()
	{
		//lay danh sach ho tro
		$list = array();
		$list = $this->support_model->get_list();
		$this->data['list'] = $list;
		
		// Message
		$message = $this->session->flashdata('flash_message');
		if ($message)
		{
			$this->data['message'] = $message;
		}
		
		// Hien thi view
		$this->data['temp'] = 'admin/support/index';
		$this->load->view('admin/main', $this->data);
	}
	
}