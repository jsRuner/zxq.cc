<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付 hi_php@163.com
 * Date: 2016/2/24
 * Time: 21:08
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
class Home_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
//        $this->load->database();
//        $this->load->library('session');
        $this->load->switch_theme('default');

    }

    protected function _template($template, $data = array())
    {
//        $data['tpl'] = $template;
        $this->load->view($template, $data);
    }

}
