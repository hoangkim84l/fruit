<?php
class Contact extends MY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		
		// Tai cac file thanh phan
		$this->load->model('contact_model');
		$this->lang->load('admin/contact');
	}
	/**
     * Description: Lấy danh sách liên hệ
     * Function: index()
     * @author: Di
     * @params: none
     * @return: get list contact
     */
	public function index()
	{
	   //Buoc 1:load thu vien phan trang
   	    $this->load->library('pagination');
   	    //Buoc 2:Cau hinh cho phan trang
   	    //lay tong so luong liên hệ tu trong csdl
   	    $total_rows = $this->contact_model->get_total();
   	    $config = array();
   	    $config['base_url']    = base_url('admin/contact/index');
   	    $config['total_rows']  = $total_rows;
   	    $config['per_page']    = 10;
   	    $config['uri_segment'] = 4;//phân đoạn 4
   	    $config['next_link']   = "Trang kế tiếp";
   	    $config['prev_link']   = "Trang trước";
   	    //Khoi tao phan trang
   	    $this->pagination->initialize($config);
   	    
   	    $input = array();
   	    $input['limit'] = array($config['per_page'], $this->uri->rsegment(3));
		//lay toan bo liên hệ
		$list = array();
		$list = $this->contact_model->get_list($input);
		$this->data['list'] = $list;
		$this->data['total_rows'] = $total_rows;
		
		// Message
		$message = $this->session->flashdata('flash_message');
		if ($message)
		{
			$this->data['message'] = $message;
		}
		
	 	// Hien thi view
		$this->data['temp'] = 'admin/contact/index';
		$this->load->view('admin/main', $this->data);
	}
	
  /**
     * Description: Xóa thông tin liên hệ
     * Function: del()
     * @author: Di
     * @params: none
     * @return: remove data to database
     */
	function del()
	{
	    $id = $this->uri->rsegment(3);
	    $this->_del($id);
	
	    //tạo ra nội dung thông báo
	    $this->session->set_flashdata('message', 'không tồn tại liên hệ này');
	    redirect(admin_url('contact'));
	}
	
	/**
     * Description: Xóa nhiều mục
     * Function: delete_all()
     * @author: Di
     * @params: none
     * @return: remove multi data to database
     */
	function delete_all()
	{
	    $ids = $this->input->post('ids');
	    foreach ($ids as $id)
	    {
	        $this->_del($id);
	    }
	}
	
	/**
     * Description: Kiểm tra dữ liệu có hay không
     * Function: _del()
     * @author: Di
     * @params: none
     * @return: none
     */
	private function _del($id)
	{
	    $contact = $this->contact_model->get_info($id);
	    if(!$contact)
	    {
	        //tạo ra nội dung thông báo
	        $this->session->set_flashdata('message', 'không tồn tại liên hệ này');
	        redirect(admin_url('contact'));
	    }
	    //thuc hien xoa san pham
	    $this->contact_model->delete($id);
	}	
}