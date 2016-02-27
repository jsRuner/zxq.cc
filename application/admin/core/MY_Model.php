<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付 hi_php@163.com
 * Date: 2016/2/26
 * Time: 13:02
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
class MY_Model extends CI_Model
{
    //主键
    protected $primary = 'id';
    //表名
    protected $table = NULL;
    //对象数据
    protected $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if (empty($this->table)) {
            $this->table = strtolower(substr(get_class($this), 0, -6));
        }
    }

    //查询指定条件的数据。这里限定是主键id。 例如1,2,3,4 或者1
    //todo :这里需要改进。支持其他查询条件。
    public function find($options = array()){
        if (is_string($options) || is_numeric($options)) {
            if (strpos($options, ',')) {
                $this->db->where_in($this->primary, explode(',', $options));
            } else {
                $this->db->where(array(($this->table.'.'.$this->primary) => $options));
            }
        }
        return $this->db->get($this->table)->row_array();
    }


    #插入数据。
    public function add($data = array()){

        #数据预处理。例如过滤 todo
        $facade_data = $data;
        #添加数据时间
        $data['add_time'] = time();
        $data['update_time'] = time();

        $result = $this->db->insert($this->table, $facade_data);

        return $result;

    }

    #查询数据.所有的。
    public function find_all(){
        $result = $this->db->get($this->table)->result_array();
        return $result;
    }

    /**
     * 删除数据.暂时只能处理1,2,3,4, 或者1
     */
    public function delete($options = array())
    {
        if(is_numeric($options)  || is_string($options)) {
            $primary = $this->primary;
            if(strpos($options, ',')) {
                $this->db->where_in($primary, explode(',', $options));
            }else{
                $this->db->where(array($primary => $options));
            }
        }else{
            return false;
        }

        $result = $this->db->delete($this->table);
        return $result;
    }

    //根据id进行编辑。
    public function editor($options = array(),$data = array()){
        if (! is_numeric($options)){
            return false;
        }
        $this->db->where(array($this->primary => $options));

        $data['update_time'] = time();
        $result = $this->db->update($this->table, $data);
        return $result;
    }


}
