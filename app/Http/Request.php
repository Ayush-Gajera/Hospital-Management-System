<?php
namespace app\Http;
class Request{
    public function getPath(){
    $path=$_SERVER["REQUEST_URI"] ?? "/";
    $position =strpos($path,"?");
    return $position===false?$path :substr($path,0,$position);
    }
    public function getMethod(){
        $method=$_SERVER["REQUEST_METHOD"];
        return strtolower($method);
    }
    public function getBody(){
        $body=[];
        if($this->getMethod()=="get"){
            foreach($_GET as $key=>$value){
                $body[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        if($this->getMethod()=="post"){
            foreach($_POST as $key =>$value){
                $body[$key]=filter_input(INPUT_POST,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        return $body;

    }
}
