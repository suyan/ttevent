<?php
class PageModel extends RelationModel{
    protected $_link = array(
                            'Category' => array(
                                                'mapping_type' => BELONGS_TO,
                                                'class_name' => 'Category',
                                                'mapping_name' => 'category',
                                                'foreign_key' => 'category_id',
                                                'mapping_fields'=>array('id','name'),
                                                ),
                            );

    protected $_validate = array(
                                array('name','require','名字必须'), 
                                array('url','url','地址错误'), 
                                );

    protected $_auto = array(
                             array('category_id',1),
                             );

    public function getUserPages($user_id){
        $Model = new Model();
        $category_table = C('DB_PREFIX').'category';
        $page_table = C('DB_PREFIX').'page';
        $categories = $Model->query("
                                    SELECT category_id,$category_table.name as category_name
                                    FROM $page_table
                                    LEFT JOIN $category_table
                                    ON $page_table.category_id=$category_table.id
                                        AND user_id=$user_id
                                    GROUP BY category_id
                                    ORDER By COUNT(*)
                                    ");
        foreach($categories as $key=>$category){
            $category_id=$category['category_id'];
            $category['pages']=$Model->query("
                                             SELECT *
                                             FROM $page_table 
                                             WHERE category_id=$category_id
                                             ORDER BY count
                                             ");
            $categories[$key]=$category;
        }
        return $categories;
    }
}