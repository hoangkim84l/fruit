<?php
Class Connecter extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        //load ra file model
        $this->load->model('connecter_model');
    }
    
    /*
     * Hiển thị danh sách liên kết
     */
    function index()
    {
        //lay tong so luong ta ca cac bai vai trong websit
        $total_rows = $this->connecter_model->get_total();
        $this->data['total_rows'] = $total_rows;
        
        //load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;//tong tat ca cac bài viết tren website
        $config['base_url']   = admin_url('connecter/index'); //link hien thi ra danh sach bài viết
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
        $name = $this->input->get('name');
        if($name)
        {
            $input['like'] = array('name', $name);
        }
       
        //lay danh sach bai viet
        $list = $this->connecter_model->get_list($input);
        $this->data['list'] = $list;
       
        //lay nội dung của biến message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        //load view
        $this->data['temp'] = 'admin/connecter/index';
        $this->load->view('admin/main', $this->data);
    }
    
    /*
     * Them bai viet moi
     */
    function add()
    {
        //load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
		
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name', 'Tên chủ vựa', 'required'); 
            
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
               
                //lay ten file anh minh hoa duoc update len
                $this->load->library('upload_library');
                $upload_path = './upload/connecter';
                $upload_data = $this->upload_library->upload($upload_path, 'image');  
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
				$name = $this->input->post('title');
                //luu du lieu can them
                $data = array(
                    'name'       => $this->input->post('name'),
                    'image_link' => $image_link,
                    'intro'      => $this->input->post('intro'),
                    'phone'      => $this->input->post('phone'),
                    'email'      => $this->input->post('email'),
                    'address'    => $this->input->post('address'),
                    'created'    => now(),
                ); 
                //them moi vao csdl
                if($this->connecter_model->create($data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('connecter'));
            }
        }
        
        
        //load view
        $this->data['temp'] = 'admin/connecter/add';
        $this->load->view('admin/main', $this->data);
    }
    
    /*
     * Chinh sua bài viết
     */
    function edit()
    {
        $id = $this->uri->rsegment('3');
        $connecter = $this->connecter_model->get_info($id);
        if(!$connecter)
        {
            //tạo ra nội dung thông báo
            $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
            redirect(admin_url('connecter'));
        }
        $this->data['connecter'] = $connecter;
       
       
        //load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name', 'Tên chủ vựa', 'required');
            
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
               
                //lay ten file anh minh hoa duoc update len
                $this->load->library('upload_library');
                $upload_path = './upload/connecter';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
				$name = $this->input->post('title');
                 //luu du lieu can them
                $data = array(
                    'name'       => $this->input->post('name'),
                    'intro'      => $this->input->post('intro'),
                    'phone'      => $this->input->post('phone'),
                    'email'      => $this->input->post('email'),
                    'address'    => $this->input->post('address'),
                    'created'    => now(),
                ); 
                if($image_link != '')
                {
                    $data['image_link'] = $image_link;
                }
                //them moi vao csdl
                if($this->connecter_model->update($connecter->id, $data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('connecter'));
            }
        }
        
        
        //load view
        $this->data['temp'] = 'admin/connecter/edit';
        $this->load->view('admin/main', $this->data);
    }
    
    /*
     * Xoa du lieu
     */
    function del()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Xóa bài viết thành công');
        redirect(admin_url('connecter'));
    }
    
    /*
     * Xóa nhiều bài viết
     */
    function delete_all()
    {
        //lay tat ca id bai viet muon xoa
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
        {
            $this->_del($id);
        }
    }
    
    /*
     *Xoa bài viết
     */
    private function _del($id)
    {
        $connecter = $this->connecter_model->get_info($id);
        if(!$connecter)
        {
            //tạo ra nội dung thông báo
            $this->session->set_flashdata('message', 'không tồn tại bài viết này');
            redirect(admin_url('connecter'));
        }
        //thuc hien xoa bài viết
        $this->connecter_model->delete($id);
        //xoa cac anh cua bài viết
        $image_link = './upload/connecter/'.$connecter->image_link;
        if(file_exists($image_link))
        {
            unlink($image_link);
        }
        
    }
}


