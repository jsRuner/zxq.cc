<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付
 * Date: 2016/3/1
 * Time: 13:42
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

$config['page_query_string'] = TRUE;
$config['reuse_query_string'] = True;

$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';

$config['prev_tag_open'] = '<li>';

$config['prev_tag_close'] = '</li>';

$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li><strong>';
$config['cur_tag_close'] = '</strong></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

$config['first_link'] = '第一页';

$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

$config['last_link'] = '最后一页';

$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';