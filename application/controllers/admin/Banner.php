<?php
Class Banner extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        //load ra file model
        $this->load->model('banner_model');
    }
    
    /**
     * Description: Lấy danh sách banner, lọc theo mã số và tiêu đề, phân trang
     * Function: index()
     * @author: Di
     * @params: none
     * @return: list of banner
     */
    function index()
    {
        //lay tong so luong ta ca cac bai vai trong website
        $total_rows = $this->banner_model->get_total();
        $this->data['total_rows'] = $total_rows;
        
        //load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;//tong tat ca banner tren website
        $config['base_url']   = admin_url('banner/index'); //link hien thi ra danh sach
        $config['per_page']   = 5;//so luong banner hien thi tren 1 trang
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
        $title = $this->input->get('title');
        if($title)
        {
            $input['like'] = array('title', $title);
        }
       
        //lay danh sach banner
        $list = $this->banner_model->get_list($input);
        $this->data['list'] = $list;
       
        //lay nội dung của biến message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        //load view
        $this->data['temp'] = 'admin/banner/index';
        $this->load->view('admin/main', $this->data);
    }
    
    /**
     * Description: Thêm banner mới
     * Function: add()
     * @author: Di
     * @params: none
     * @return: save array date to database
     */
    function add()
    {
       
        //load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
		
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('title', 'Tiêu đề bài viết', 'required');
            
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
                //lay ten file anh minh hoa duoc update len
                $this->load->library('upload_library');
                $upload_path = './upload/banner';
                $upload_data = $this->upload_library->upload($upload_path, 'image');  
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
				$name = $this->input->post('title');
                //luu du lieu can them
                $data = array(
                    'title'      => $this->input->post('title'),
                    'image_link' => $image_link,
                    'created'    => now(),
                ); 
                //them moi vao csdl
                if($this->banner_model->create($data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('banner'));
            }
        }
        //load view
        $this->data['temp'] = 'admin/banner/add';
        $this->load->view('admin/main', $this->data);
    }
    
    /**
     * Description: Chỉnh sửa thông tin của banner
     * Function: edit()
     * @author: Di
     * @params: none
     * @return: save new data to database
     */
    function edit()
    {
        $id = $this->uri->rsegment('3');
        $banner = $this->banner_model->get_info($id);
        if(!$banner)
        {
            //tạo ra nội dung thông báo
            $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
            redirect(admin_url('banner'));
        }
        $this->data['banner'] = $banner;
    
        //load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('title', 'Tiêu đề bài viết', 'required');
            
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
               
                //lay ten file anh minh hoa duoc update len
                $this->load->library('upload_library');
                $upload_path = './upload/banner';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
				$name = $this->input->post('title');
                 //luu du lieu can them
                $data = array(
                    'title'      => $this->input->post('title'),
                    'created'    => now(),
                ); 
                if($image_link != '')
                {
                    $data['image_link'] = $image_link;
                }
                //them moi vao csdl
                if($this->banner_model->update($banner->id, $data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('banner'));
            }
        }
        
        
        //load view
        $this->data['temp'] = 'admin/banner/edit';
        $this->load->view('admin/main', $this->data);
    }
    
    /**
     * Description: Xóa dữ liệu
     * Function: del()
     * @author: Di
     * @params: none
     * @return: remove picture from database
     */
    function del()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Xóa bài viết thành công');
        redirect(admin_url('banner'));
    }
    
   /**
     * Description: Xóa nhiều mục
     * Function: delete_all()
     * @author: Di
     * @params: none
     * @return: remove list banner
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
    
    /**
     * Description: Kiểm tra có image trong folder banner hay khong có thì remove luôn
     * Function: _del()
     * @author: Di
     * @params: $id
     * @return: remove image from folder
     */
    private function _del($id)
    {
        $banner = $this->banner_model->get_info($id);
        if(!$banner)
        {
            //tạo ra nội dung thông báo
            $this->session->set_flashdata('message', 'không tồn tại bài viết này');
            redirect(admin_url('banner'));
        }
        //thuc hien xoa bài viết
        $this->banner_model->delete($id);
        //xoa cac anh cua bài viết
        $image_link = './upload/banner/'.$banner->image_link;
        if(file_exists($image_link))
        {
            unlink($image_link);
        }
    }
}