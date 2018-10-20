<?php
class Category{
	private $data;
    public function __construct( $data ){
        $this->data = json_decode($data);
    }
    private function add(){
    	return 'INSERT INTO d_category(c_name) VALUES("'.$this->data->name.'")';
    }
    private function upd(){
 		return 'update d_category set c_name="'.$this->data->name.'" where c_id='.$this->data->id;
    }
    private function del(){
    	return 'delete from d_category where c_id='.$this->data->id;
    }
    private function que(){
    	return 'select * from d_category';
    }
    public function getSql(){
        $methods = $this->data->opt;
        return $this->$methods();
    }
    public function getData(){
        return $this->data;
    }
}