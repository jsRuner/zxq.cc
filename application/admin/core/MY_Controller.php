<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付 hi_php@163.com
 * Date: 2016/2/25
 * Time: 12:58
 * description:
 *////////////////////////////////////////////////////////////////////
//                            _ooOoo_                             //
//                           o8888888o                            //
//                           88" . "88                            //
//                           (| ^_^ |)                            //
//                           O\  =  /O                            //
//                        ____/`---'\____                         //
//                      .'  \\|     |//  `.                       //
//                     /  \\|||  :  |||//  \                      //
//                    /  _||||| -:- |||||-  \                     //
//                    |   | \\\  -  /// |   |                     //
//                    | \_|  ''\---/''  |   |                     //
//                    \  .-\__  `-`  ___/-. /                     //
//                  ___`. .'  /--.--\  `. . ___                   //
//                ."" '<  `.___\_<|>_/___.'  >'"".                //
//              | | :  `- \`.;`\ _ /`;.`/ - ` : | |               //
//              \  \ `-.   \_ __\ /__ _/   .-` /  /               //
//        ========`-.____`-.___\_____/___.-`____.-'========       //
//                             `=---='                            //
//        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^      //
//         佛祖保佑       永无BUG        永不修改                    //
//////////////////////////////////////////////////////////////////// 
class Admin_Controller extends CI_Controller
{
    /**
     * _admin
     * 保存当前登录用户的信息
     *
     * @var object
     * @access  public
     **/
    public $_admin = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->_check_login();
    }

    protected function _check_login()
    {
        if ( ! $this->session->userdata('uid'))
        {
            redirect('login');
        }
        else
        {
//            $this->_admin = array();
//            $this->_admin->status = 1;
//            $this->_admin = $this->user_mdl->get_full_user_by_username($this->session->userdata('uid'), 'uid');
//            if ($this->_admin->status != 1)
//            {
//                $this->session->set_flashdata('error', "此帐号已被冻结,请联系管理员!");
//                redirect('login');
//            }
        }
    }

}
