<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付
 * Date: 2016/2/24
 * Time: 21:00
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

class MY_Loader extends CI_Loader{
    public function __construct()
    {
        parent::__construct();
    }

    public function switch_theme($theme = 'default')
    {
        $this->_ci_view_paths = array(APPPATH. 'templates/' . $theme . '/'     => TRUE);
//        print_r($this->_ci_view_paths);
    }



}

function CI()
{
    $CI = & get_instance();
    return $CI;
}
