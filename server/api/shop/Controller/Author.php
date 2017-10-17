<?php

class Author extends Controller
{
    public function getAllAuthor($params = false)
    {
        $model = new AuthorModel();
        $data = $model->getAllAuthors();
        return $data;
    }
    
    public function getItemBAuthor($params = false)
    {
        
    }
    
    public function postAuthor($params)
    {

    }
    

    public function putAuthor($params)
    {

    }
}

