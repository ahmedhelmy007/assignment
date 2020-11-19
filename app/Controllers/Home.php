<?php namespace App\Controllers;

use App\Models\Categories;
use CodeIgniter\Controller;

class Home extends BaseController
{
    /**
    */
    public function index()
    {
        return view('welcome_message');
    }

    /**
    */
	public function assignment()
	{
        $model = new Categories();

        $data['rootCategories'] = $model
            ->where('parent_id =', null)
            ->orwhere('parent_id', 0)
            ->findAll();
        //$data['rootCategories'] = $model->findAll();

		echo view('home_index', $data);
	}

	/**
     *  fetch all children categories of a parent category, if no children categories then create a couple of dummy ones
	 */
    public function getchildren($parentId)
    {
        $categoriesModel = new Categories();

        $children= $categoriesModel->where('parent_id ='. $parentId)->findAll();
        $parent= $categoriesModel->asArray()->where(['id '=> $parentId])->first();
        //building array of current parent children elements
        if($children){
            foreach ($children as $child){
                $result[$child['id']]=$child['name'];
            }
        }else{
            //inserting dummy children
            $dummyCat1= new $categoriesModel();
            $dummyCat2= new $categoriesModel();

            $dummyCat1Name= 'SUB '. $parent['name'] . ' 1';
            $dummyCat1Data = [
                'parent_id' => $parentId,
                'name'    => $dummyCat1Name
            ];

            $dummyCat2Name= 'SUB '. $parent['name'] . ' 2';
            $dummyCat2Data = [
                'parent_id' => $parentId,
                'name'    => $dummyCat2Name
            ];
            //get ids of inserted children
            $id1 = $categoriesModel->insert($dummyCat1Data);
            $dummyCat1Id = $dummyCat1->insertID();

            $id2 = $categoriesModel->insert($dummyCat2Data);
            $dummyCat2Id = $dummyCat2->insertID();

            $result[$dummyCat1Id]=$dummyCat1Name;
            $result[$dummyCat2Id]=$dummyCat2Name;
        }

        echo json_encode($result);
    }

    /**
     * Creates an initial root category (category with no parent)
     */
    public function createrootcat(){
        $categoriesModel = new Categories();
        $rootCat= new $categoriesModel();
        $rootCatData = [
            'parent_id' => null,
            'name'    => 'A'
        ];
        $categoriesModel->insert($rootCatData);

        return redirect()->to('assignment');
//        return redirect()->route('assignment');
    }
}
