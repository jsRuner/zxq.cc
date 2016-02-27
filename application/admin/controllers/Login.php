<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * DiliCMS
 *
 * 一款基于并面向CodeIgniter开发者的开源轻型后端内容管理系统.
 *
 * @package     DiliCMS
 * @author      DiliCMS Team
 * @copyright   Copyright (c) 2011 - 2012, DiliCMS Team.
 * @license     http://www.dilicms.com/license
 * @link        http://www.dilicms.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * DiliCMS 用户登录/退出控制器
 *
 * @package     DiliCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Jeongee
 * @link        http://www.dilicms.com
 */
class Login extends CI_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return \Login
     */
    public function __construct()
    {
        parent::__construct();
//        $this->load->database();
        $this->load->library('session');
    }

    // ------------------------------------------------------------------------

    /**
     * 默认入口
     *
     * @access  public
     * @return  void
     */
    public function index()
    {
        if ($this->session->userdata('uid'))
        {
            redirect('welcome');
        }
        else
        {
            $this->load->view('login_index');
        }
    }


    // ------------------------------------------------------------------------

    /**
     * 退出
     *
     * @access  public
     * @return  void
     */
    public function quit()
    {
        $this->session->sess_destroy();
        redirect('login/index');
    }

    // ------------------------------------------------------------------------

    /**
     * 用户登录验证
     *
     * @access  public
     * @return  void
     */
    public function login_post()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);


//        $this->session->set_userdata('uid', 1);
//        redirect('Welcome/index');
//        exit();

        if ($username AND $password)
        {
            $admin = array();
            if ($username == "zxq")
            {


				if ($password == "123456")
                {
                    //登录成功。
                    $this->session->set_userdata('uid', 1);
                    redirect('Welcome/index');
                }
                else
                {

                    $this->session->set_flashdata('error', "密码不正确!");
                    show_error("密码不正确","","呃呃。。出现错误。不要着急");
                }
            }
            else
            {
                $this->session->set_flashdata('error', '不存在的用户!');
                show_error("不存在的用户","","呃呃。。出现错误。不要着急");

            }
        }
        else
        {
            $this->session->set_flashdata('error', '用户名和密码不能为空!');
            show_error("用户和密码不能为空","","呃呃。。出现错误。不要着急");
        }

//        redirect(setting('backend_access_point') . '/login');
    }

    // ------------------------------------------------------------------------

}

/* End of file login.php */
/* Location: ./admin/controllers/login.php */