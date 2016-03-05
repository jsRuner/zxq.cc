<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付 hi_php@163.com
 * Date: 2016/2/26
 * Time: 13:01
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
class Football_peilv_model extends MY_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    //根据条件。获取所有的。传入fid 返回该比赛对应的所有赔率
    public function select_list_by_fid($options = array()){
        if (!is_numeric($options)){
            return false;
        }
        $this->db->where(array('football_id' => $options));
        return $this->db->get($this->table)->result_array();
    }

    //根据条件。获取所有的。传入fid 返回该比赛对应的所有赔率
    public function select_list_by_fid_order_peilvdate($options = array()){
        if (!is_numeric($options)){
            return false;
        }
        $this->db->where(array('football_id' => $options));
        $this->db->order_by('peilv_date','asc');
        return $this->db->get($this->table)->result_array();
    }


    public function select_list_by_fid_order($options = array()){
        if (!is_numeric($options)){
            return false;
        }
        $this->db->where(array('football_id' => $options));
        $this->db->order_by('peilv_type','peilv_date');
        return $this->db->get($this->table)->result_array();
    }



    //取得上一次的赔率。条件是fid peilv_type
    public function find_last($fid,$pei_type){
        $this->db->where('football_id',$fid);
        $this->db->where('peilv_type',$pei_type);
        return $this->db->get($this->table)->row_array();
    }

    //取得赔率所影响的下一次赔率记录。
    public function find_next($peilv_trend_id)
    {
        $this->db->where('peilv_trend_id',$peilv_trend_id);
        return $this->db->get($this->table)->row_array();
    }

    //取得比赛id。赔率类型的数目记录
    public function select_list_num_group_fid_type($peilv_type){
        $sql = "select football_id,peilv_type, count(*) AS peilv_change_num from zxq_football_peilv where peilv_type = $peilv_type group by football_id,peilv_type;";
        return $this->db->query($sql)->result_array();
    }

    //有条件的分页查询
    public function select_list_option($limit,$offset,$option){
        $this->db->where_in('football_id',$option);
        return $this->db->get($this->table, $limit,$offset)->result_array();
    }





}
