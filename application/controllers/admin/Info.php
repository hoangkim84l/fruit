<?php
Class Info extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        //load ra file model
        $this->load->model('info_model');
    }
    
    /**
     * Description: Hiển thị dữ liệu (Giới thiệu, Hướng dẫn mua hàng)
     * Function: index()
     * @author: Di
     * @params: none
     * @return: get list info
     */
    function index()
    {
        //lay tong so luong ta ca cac bai vai trong websit
        $total_rows = $this->info_model->get_total();
        $this->data['total_rows'] = $total_rows;
        
        //load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;//tong tat ca cac bài viết tren website
        $config['base_url']   = admin_url('info/index'); //link hien thi ra danh sach bài viết
        $config['per_page']   = 5;//so luong bài viết hien thi tren 1 trang
        $config['uri_segment'] = 4;//phan doan hien thi ra so trang tren url
        $config['next_link']   = 'Trang kế tiếp';
        $config['prev_link']   = 'Trang trước';
        //khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);
        
        $segment = $this->uri->segment(4);
        $segment = intval($segment);
        
        $input = array();
        $input['limit'] = array($config['per_page'], $segment);
        
        //kiem tra co thuc hien loc du lieu hay khong
        $id = $this->input->get('id');
        $id = intval($id);
        $input['where'] = array();
        if($id > 0)
        {
            $input['where']['id'] = $id;
        }
       
        //lay danh sach bai viet
        $list = $this->info_model->get_list($input);
        $this->data['list'] = $list;
       
        //lay nội dung của biến message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        //load view
        $this->data['temp'] = 'admin/info/index';
        $this->load->view('admin/main', $this->data);
    }
    
    /**
     * Description: Cập nhật dữ liệu
     * Function: edit()
     * @author: Di
     * @params: none
     * @return: save new data to database
     */
    function edit()
    {
		
        $id = $this->uri->rsegment('3');
        $info = $this->info_model->get_info($id);
        if(!$info)
        {
            //tạo ra nội dung thông báo
            $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
            redirect(admin_url('info'));
        }
        $this->data['info'] = $info;
       
       
        //load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('content', 'Nội dung bài viết', 'required');
            
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
				$name = $this->input->post('title');
                 //luu du lieu can them
                $data = array(
                    'title'      => $this->input->post('title'),
                    'content'    => $this->input->post('content'),
                    'meta_desc'  => $this->input->post('meta_desc'),
                    'meta_key'   => $this->input->post('meta_key'),      
                    'created'    => now(),
                ); 
                //them moi vao csdl
                if($this->info_model->update($info->id, $data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('info'));
            }
        }
        //load view
        $this->data['temp'] = 'admin/info/edit';
        $this->load->view('admin/main', $this->data);
    }
}
