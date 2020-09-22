<?php
Class Cart extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
    }
    /**
     * Description: Thêm sản phẩm vào giỏ hàng
     * Function: add()
     * @author: Di
     * @params: none
     * @return: add product to cart
     */
    function add()
    {
        //lay ra san pham muon them vao gio hang
        $this->load->model('product_model');
        $id = $this->uri->rsegment(3);
        $product = $this->product_model->get_info($id);
        if(!$product)
        {
            redirect();
        }
        //tong so san pham
        $qty = 1;
        $price = $product->price;
        if($product->discount > 0)
        {
            $price = $product->price - $product->discount;
        }
        
        //thong tin them vao gio hang
        $data = array();
        $data['id'] = $product->id;
        $data['qty'] = $qty;
        $data['name'] = url_title($product->name);
        $data['image_link']  = $product->image_link;
        $data['price'] = $price;
        $this->cart->insert($data);
        
        //chuyen sang trang danh sach san pham trong gio hang
        redirect(base_url('cart'));
    }
    /**
     * Description: Hiển thị sản phẩm trong giỏ hàng
     * Function: index()
     * @author: Di
     * @params: none
     * @return: Show record in cart
     */
    function index()
    {
        //thong gio hang
        $carts = $this->cart->contents();
        //tong so san pham co trong gio hang
        $total_items = $this->cart->total_items();
        
        $this->data['carts'] = $carts;
        $this->data['total_items']  =$total_items;
        
        $this->data['temp']  ='site/cart/index';
        $this->load->view('site/layout', $this->data);
    }
    /**
     * Description: Cập nhật giỏ hàng
     * Function: Update()
     * @author: Di
     * @params: none
     * @return: update quality and price
     */
    function update()
    {
        //thong gio hang
        $carts = $this->cart->contents();
        foreach ($carts as $key => $row)
        {
            //tong so luong san pham
            $total_qty = $this->input->post('qty_'.$row['id']);
            $data = array();
            $data['rowid'] = $key;
            $data['qty'] = $total_qty;
            $this->cart->update($data);
        }
        
        //chuyen sang trang danh sach san pham trong gio hang
        redirect(base_url('cart'));
    }
    /**
     * Description: Xóa sản phẩm ra khỏi giỏ hàng
     * Function: del()
     * @author: Di
     * @params: none
     * @return: remove record
     */
    function del()
    {
        $id = $this->uri->rsegment(3);
        $id = intval($id);
        //trường hợp xóa 1 sản phẩm nào đó trong giỏ hàng
        if($id > 0)
        {
            //thong gio hang
            $carts = $this->cart->contents();
            foreach ($carts as $key => $row)
            {
                if($row['id'] == $id)
                {
                    //tong so luong san pham
                    $data = array();
                    $data['rowid'] = $key;
                    $data['qty'] = 0;
                    $this->cart->update($data);
                }
            }
        }else{
            //xóa toàn bô giỏ hang
            $this->cart->destroy();
        }
        
        //chuyen sang trang danh sach san pham trong gio hang
        redirect(base_url('cart'));
    }
}