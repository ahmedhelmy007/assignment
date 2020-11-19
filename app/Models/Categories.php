<?php namespace App\Models;

use CodeIgniter\Model;

class Categories extends Model
{
    protected $allowedFields= ['name', 'parent_id'];

    protected $table = 'categories';

//    public function getCategories($level = false)
//    {
//        if ($level === false)
//        {
//            return $this->findAll();
//        }
//
//        return $this->asArray()
//            ->where(['level' => $level])
//            ->first();
//    }
}