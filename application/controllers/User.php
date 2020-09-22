<?php
Class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    /**
     * Description: Kiểm tra email tồn tại hay chưa
     * Function: check_email()
     * @author: Di
     * @params: none
     * @return: true or false
     */
    function check_email()
    {
        $email = $this->input->post('email');
        $where = array('email' => $email);
        //kiêm tra xem email đã tồn tại chưa
        if($this->user_model->check_exists($where))
        {
            //trả về thông báo lỗi
            $this->form_validation->set_message(__FUNCTION__, 'Email đã tồn tại');
            return false;
        }
        return true;
    }
    /**
     * Description: Đăng k1i thành viên
     * Function: register()
     * @author: Di
     * @params: none
     * @return: Save data
     */
    function register()
    {
        //neu dang dang nhap thi chuyen ve trang thong tin thanh vien
        if($this->session->userdata('user_id_login'))
        {
            redirect(site_url('user'));
        }
        
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[8]');
            $this->form_validation->set_rules('email', 'Email đăng nhập', 'required|valid_email|callback_check_email');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]');
            $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'matches[password]');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
            $this->form_validation->set_rules('address', 'Địa chỉ', 'required');
  
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
                //them vao csdl
                $password = $this->input->post('password');
                $password = md5($password);
                
                $data = array(
                    'name'     => $this->input->post('name'),
                    'email'    => $this->input->post('email'),
                    'phone'    => $this->input->post('phone'),
                    'address'  => $this->input->post('address'),
                    'password' => $password,
                    'created'  => now(),
                );
                if($this->user_model->create($data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Đăng ký thành viên thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                //chuyen tới trang danh sách quản trị viên
                redirect(site_url());
            }
        }
        
        //hiển thị ra view
        $this->data['temp'] = 'site/user/register';
        $this->load->view('site/layout', $this->data);
    }
    /**
     * Description: Kiểm tra đăng nhập
     * Function: login()
     * @author: Di
     * @params: none
     * @return: Check session and redirect
     */
    function login()
    {
        //neu dang dang nhap thi chuyen ve trang thong tin thanh vien
        if($this->session->userdata('user_id_login'))
        {
            redirect(site_url('user'));
        }
        
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if($this->input->post())
        {
            $this->form_validation->set_rules('email', 'Email đăng nhập', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]');
            $this->form_validation->set_rules('login' ,'login', 'callback_check_login');
            if($this->form_validation->run())
            {
                //lay thong tin thanh vien
                $user = $this->_get_user_info();
                //gắn session id của thành viên đã đăng nhập
                $this->session->set_userdata('user_id_login', $user->id);
                
                $this->session->set_flashdata('message', 'Đăng nhập thành công');
                redirect();
            }
        }
        
        //hiển thị ra view
        $this->data['temp'] = 'site/user/login';
        $this->load->view('site/layout', $this->data);
    }
    /**
     * Description: Kiểm tra thông tin đăng nhập đúng hay không
     * Function: check_login()
     * @author: Di
     * @params: none
     * @return: true or false
     */
    function check_login()
    {
        $user = $this->_get_user_info();
        if($user)
        {
            return true;
        }
        $this->form_validation->set_message(__FUNCTION__, 'Không đăng nhập thành công');
        return false;
    }
    /**
     * Description: Lấy thông tin thành viên
     * Function: _get_user_info()
     * @author: Di
     * @params: none
     * @return: none
     */
    private function _get_user_info()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password = md5($password);
        
        $where = array('email' => $email , 'password' => $password);
        $user = $this->user_model->get_info_rule($where);
        return $user;
    }
    /**
     * Description: Cập nhật thông tin thành viên
     * Function: edit()
     * @author: Di
     * @params: none
     * @return: save new data
     */
    function edit()
    {
        if(!$this->session->userdata('user_id_login'))
        {
            redirect(site_url('user/login'));
        }
        //lay thong tin cua thanh vien
        $user_id = $this->session->userdata('user_id_login');
        $user = $this->user_model->get_info($user_id);
        if(!$user)
        {
            redirect();
        }
        $this->data['user']  = $user;
        

        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $password = $this->input->post('password');
            
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[8]');
            if($password)
            {
                $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]');
                $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'matches[password]');
            }
            
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
            $this->form_validation->set_rules('address', 'Địa chỉ', 'required');
        
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
                //them vao csdl
                $data = array(
                    'name'     => $this->input->post('name'), 
                    'phone'    => $this->input->post('phone'),
                    'address'  => $this->input->post('address'),
                );
                if($password)
                {
                    $data['password'] = md5($password);
                }
                if($this->user_model->update($user_id, $data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Chỉnh sửa thông tin thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không thành công');
                }
                //chuyen tới trang danh sách quản trị viên
                redirect(site_url('user'));
            }
        }
        
        //hiển thị ra view
        $this->data['temp'] = 'site/user/edit';
        $this->load->view('site/layout', $this->data);
    }
    /**
     * Description: Hiển thị thông tin thành viên
     * Function: index()
     * @author: Di
     * @params: none
     * @return: none
     */
    function index()
    {
        if(!$this->session->userdata('user_id_login'))
        {
            redirect();
        }
        $user_id = $this->session->userdata('user_id_login');
        $user = $this->user_model->get_info($user_id);
        if(!$user)
        {
            redirect();
        }
        $this->data['user']  = $user;
        
        //hiển thị ra view
        $this->data['temp'] = 'site/user/index';
        $this->load->view('site/layout', $this->data);
    }
    /**
     * Description: Thực hiện đăng xuất
     * Function: logout()
     * @author: Di
     * @params: none
     * @return: check and remove session user_id_login
     */
    function logout()
    {
        if($this->session->userdata('user_id_login'))
        {
            $this->session->unset_userdata('user_id_login');
        }
        $this->session->set_flashdata('message', 'Đăng xuất thành công');
        redirect();
    }
}

