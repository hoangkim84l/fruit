<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		// Tai cac file thanh phan
		$this->load->model('support_model');
		$this->lang->load('admin/support');
	}
	
	
/*
 * ------------------------------------------------------
 *  Rules params
 * ------------------------------------------------------
 */
	
	
/*
 * ------------------------------------------------------
 *  Action handle
 * ------------------------------------------------------
 */
	/**
	 * Them moi
	 */
	function add()
	{
		
		//load các file để validation form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        //dieu kien
        $this->form_validation->set_rules('name', 'Tên hỗ trợ', 'required');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|numeric');
        $this->form_validation->set_rules('gmail', 'Email', 'valid_email');
        
        if($this->form_validation->run())
        {
            //lay du lieu ma admin nhap vao form
            $data = array();
            $data['name']       = $this->input->post('name');//ten hỗ trợ
            $data['phone']      = $this->input->post('phone');
            $data['yahoo']      = $this->input->post('yahoo');
            $data['gmail']      = $this->input->post('gmail');
            $data['skype']      = $this->input->post('skype'); 
            $data['sort_order'] = $this->input->post('sort_order');//vi tri sắp xếp
            if($this->support_model->create($data))
            {
                //gui thong bao thanh cong
                $this->session->set_flashdata('flash_message', 'Đã thêm hỗ trợ thành công');
            }
            else
            {
                //gui thong bao that bai
                $this->session->set_flashdata('flash_message', 'Đã có lỗi trong quá trình thêm');
            }
            //chuyen ve trang danh sach cac hỗ trợ
            redirect(admin_url('support'));
        }
        
		// Luu bien gui den view
		$this->data['action'] = current_url();
		
		// Hien thi view
		$this->data['temp'] = 'admin/support/add';
		$this->load->view('admin/main', $this->data);
	}

	/**
	 * Chinh sua
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
			$image_link = '';
			if(isset($upload_data['file_name']))
			{
				$image_link = $upload_data['file_name'];
			}
			
            //lay du lieu ma admin nhap vao form
            $data = array();
            $data['name']       = $this->input->post('name');//ten hỗ trợ
            $data['phone']      = $this->input->post('phone');
            $data['hotline']    = $this->input->post('hotline');
            $data['gmail']      = $this->input->post('gmail');
            $data['skype']      = $this->input->post('skype');
			$data['site_title']      = $this->input->post('site_title');
			$data['site_key']      = $this->input->post('site_key');
			$data['site_desc']      = $this->input->post('site_desc');
			$data['zalo']      = $this->input->post('zalo');
			$data['facebook']      = $this->input->post('facebook');			
            $data['sort_order'] = $this->input->post('sort_order');//vi tri sắp xếp
			
			if($image_link != '')
			{
				$data['logo'] = $image_link;
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
	 * Xoa du lieu
	 */
	function del()
	{
	    ///lay thong tin chi tiet cua hỗ trợ muon xóa
		$id = $this->uri->rsegment('3');
		//lay thong tin cua hỗ trợ
		$info = $this->support_model->get_info($id);
		if(!$info)
		{
		     //gui thong bao that bai
             $this->session->set_flashdata('flash_message', 'Không tồn tại hỗ trợ này');
             redirect(admin_url('support'));
		}
	    //thuc hien xoa
		if($this->support_model->delete($id))
		{
		   //gui thong bao that bai
           $this->session->set_flashdata('flash_message', 'Đã xóa hỗ trợ thành công');
		}
		else
		{
		   //gui thong bao that bai
           $this->session->set_flashdata('flash_message', 'Có lỗi trong quá trình xóa');
		}
		redirect(admin_url('support'));
	}
	
/*
 * ------------------------------------------------------
 *  List handle
 * ------------------------------------------------------
 */
	/**
	 * Danh sach
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