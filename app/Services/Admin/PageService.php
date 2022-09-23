<?php

namespace App\Services\Admin;

use App\Models\Page;
use \Illuminate\Support\Str;
use App\Services\BaseService; 

class PageService extends BaseService
{

    protected $model;

    public function __construct()
    {
        $this->model = Page::class;
    }

    public function storeOrUpdate($data, $id = null)
    {
        try {
            // Load additional data
            // $data['slug'] = Str::slug($data['title']);
            $data['template_id'] = (int) $data['template_id'];
            if($id == null){                 
                $data['created_by'] = auth()->id();                
            } else {
                $data['updated_by'] = auth()->id();
            }
            // Call patent method
            return parent::storeOrUpdate($data, $id);
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }
}
