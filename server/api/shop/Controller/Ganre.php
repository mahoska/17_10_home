<?php

class Ganre extends Controller
{
    public function getAllGanre($params = false)
    {
        $model = new GanreModel();
        $data = $model->getAllGanres();
        return $data;
    }
    
    public function getItemGanre($params = false)
    {
        
    }
    
    public function postGanre($params)
    {

    }
    

    public function putGanre($params)
    {

    }
}

