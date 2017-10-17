<?php

class Cart extends Controller
{
    public function getAllCart($params = false)
    {
        
    }
    
    public function getItemCart($params = false)
    {
        
    }
    
    public function postCart($params)
    {
        if(count($params) != 3){
            return ['status'=>400, 'clientCode'=>'0001'];
        }
        foreach($params as $key=>$val){
            if((int)$val>0) continue;
            else return  ['status'=>400, 'clientCode'=>'0001'];
        }
        $model = new CartModel();
        return $model->createCart($params); 
    }
    

    public function putCart($params)
    {

    }
}

