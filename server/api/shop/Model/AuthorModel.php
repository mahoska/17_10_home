<?php

class AuthorModel extends Model
{

    public function getAllAuthors()
    {
        try{
            $sth = $this->pdo->query("SELECT id, name, surname FROM author"); 
            $collection = $this->getFetchAccoss($sth);
            return ['status'=>200, 'data'=>$collection];
        }catch(PDOException $err){
            file_put_contents('errors.txt', $err->getMessage(), FILE_APPEND); 
            return ['status'=>500, 'clientCode'=>'0006'];
        }
    }



}
