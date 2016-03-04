<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付 hi_php@163.com
 * Date: 2016/2/27
 * Time: 15:57
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
class Collect extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('collect_model','collect');
        $this->load->model('football_model','football');
        $this->load->model('football_peilv_model','football_peilv');

        $this->name = "采集管理";
    }

    //显示采集的规则列表
    public function index()
    {
        //查询条件。todo:
        $limit =  15;
        $offset = intval($this->input->get('per_page'));
        $result = $this->collect->select_list($limit,$offset);
        $this->load->library('pagination');
        $config['base_url'] = "http://zxq.cc/admin.php/collect/index";
        $config['total_rows'] = $this->collect->count();
        $this->pagination->initialize($config);
        $data['paginationstr'] = $this->pagination->create_links();
        $data['collectlist'] = $result;

        $data['tpl'] = "collect_index";
        $data['nav2'] ="规则管理";
        $this->load->view('common_admin',$data);

    }



    //添加采集。设置采集的一些参数。
    public function add()
    {
        $data['tpl'] = "collect_add";
        $data['nav2'] ="新建记录";
        $this->load->view('common_admin',$data);
    }


//    处理表单。
    public function add_form(){

        $this->form_validation->set_message('required', '{field} 必须不为空.');
        $this->form_validation->set_rules('collect_code', '采集编号', 'required');

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('collect_add');
            return;
        }

        $data = $this->input->post();

        $result = $this->collect->add($data);
        //success
        if ($result){
            redirect("collect/index");
        }else{
            show_error("添加采集出错","2000","呃呃呃。。。系统出现错误。");
        }
    }

    //编辑。
    public function editor(){
        $fid = $this->input->get('id');
        //赛事信息
        $collectinfo = $this->collect->find($fid);
        $data['collectinfo'] = $collectinfo;

        $data['tpl'] = "collect_editor";
        $data['nav2'] ="编辑记录";
        $this->load->view('common_admin',$data);

    }

    //编辑表单.处理请求。
    public function editor_form(){
        $this->form_validation->set_message('required', '{field} 必须不为空.');
        $this->form_validation->set_rules('collect_code', '比赛编码', 'required');

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('collect_editor');
            return;
        }
        $cid = $this->input->post('cid');


        $data = $this->input->post();
        unset($data['cid']);
        $result = $this->collect->editor($cid,$data);
        //success
        if ($result){
            redirect("collect/index");
        }else{
            show_error("编辑采集出错","2000","呃呃呃。。。系统出现错误。");
        }

    }

    public function delete(){
        $id = $this->input->post('id');

//        //检查是否存在赔率。
//        $peilvlist = $this->football_peilv->select_list_by_fid($id);
//        if (is_array($peilvlist) && count($peilvlist) >0){
//            echo "删除失败:该比赛下还存在赔率记录。请先去删除赔率信息";
//            exit(0);
//        }


        $result = $this->collect->delete($id);
        if($result){
            echo "删除成功";
        }else{
            echo "删除失败";
        }

    }

    /**
     * 返回固定格式的数据即可。
     * 从 http://info.sporttery.cn/football/hhad_list.php 获得数据
     */
    public function collectfromsporttery(){

    }




    //开启采集。
    public function start()
    {
        require APPPATH . '/libraries/phpQuery/phpQuery.php';
        $url = 'http://cp.zgzcw.com/lottery/jchtplayvsForJsp.action?lotteryId=47&type=jcmini';
        $curl = curl_init(); //开启curl
        $header[] = "User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0";
        $header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $header[] = "Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3";
        $header[] = "Connection: keep-alive";
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //是否输出 1 or true 是不输出 0  or false输出
        $html = curl_exec($curl); //执行curl操作
        curl_close($curl);
//        echo $html;
//        exit(0);
        #w将获取的结果，通过phpquery ,生成一个对象。
        phpquery::newDocumentHTML($html, 'utf-8');
        //beginBet
        $beginBets = pq(".beginBet");
        foreach ($beginBets as $beginBet) {
            $data = array();
            #获取比赛的编号
            $data['football_code'] = pq($beginBet)->find(".ah > i")->text();
            #获取排名 主队 客队
            $data['team1_rank'] = number(pq($beginBet)->find(".wh-4 > .pm")->text()) ;
            $data['team2_rank'] = number(pq($beginBet)->find(".wh-6 > .pm")->text());

            #比赛时间.需要格式化为int 比赛时间:2016-03-01 15:30
            $tempstr = pq($beginBet)->find(".wh-3 > span:last")->attr('title');
            $temp = str_replace("比赛时间:","",$tempstr);
            $data['football_date'] = strtotime($temp);




            #添加比赛的主队
            $data['football_team1'] = pq($beginBet)->find(".t-r")->find('a')->text();
            #添加比赛的客队
            $data['football_team2'] = pq($beginBet)->find(".t-l")->find('a')->text();
            #获取比赛的胜平负.多条记录
            $peilvs = pq($beginBet)->find('.wh-8')->find('.tz-area');
            $data_peilvs = array();
            foreach ($peilvs as $peilv ){
                //获得让球数
//                $data_peilv['peilv_type'] = pq($peilv)->find('rq')->text();
                $data_peilv = array();
                $data_peilv[] =  pq($peilv)->find('.rq')->text();
                $weisais = pq($peilv)->find('.weisai');
                foreach($weisais as $weisai){
                    $data_peilv[] = pq($weisai)->text();
                }
                $data_peilvs[] = $data_peilv;
            }
            $data['football_peilvlist'] = $data_peilvs;
            $datas[] = $data;
        }
        //数据库操作。
        $result = $this->data2mysql($datas);
//        wwf_dump($datas);
    }

    private function data2mysql($data = array()){

        foreach($data as $football){
            //处理数据。
            $footballdata = $football;
            unset($footballdata['football_peilvlist']);
            $footballdata['data_from'] = 1;
            //执行插入操作。
            $id = 0;
            $id = $this->football->add_id($footballdata);
            if($id == 0){
                return false;
            }
            //处理赔率。
            $peilvlist = $football['football_peilvlist'];
            //给赔率添加上其他的信息。修改数组为关联数组
            $peilvlist_datas = array();
            foreach($peilvlist as $item){
                if(count($item) < 4){
                    $item[1] =$item[2] = $item[3] = "0";
//                    continue;
                }
                $peilvlist_data = array();
                $peilvlist_data['football_code'] = $football['football_code'];
                $peilvlist_data['football_id'] = $id;
                $peilvlist_data['peilv_type'] = $item[0];
                $peilvlist_data['peilv_win'] = $item[1];
                $peilvlist_data['peilv_draw'] = $item[2];
                $peilvlist_data['peilv_fail'] = $item[3];

                $peilvlist_datas[] = $peilvlist_data;



            }
            $this->football_peilv->adds($peilvlist_datas);



        }


        echo '采集Ok';
        return True;
    }


}
