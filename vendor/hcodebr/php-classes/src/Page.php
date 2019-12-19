<?php

namespace  Hcode;
use Rain\Tpl;

class Page
{

    private $tpl;
    private $options = [];
    private $defaults = [
        "data"=>[]
    ];

    public function __construct($options = array(), $tpl_dir = "/views/")
    {
        $this->options = array_merge($this->defaults, $options);

        // config
        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure( $config );

        $this->tpl = new Tpl();

        $this->setData($this->options["data"]);

        $this->tpl->draw("header");

    }

    private function setData($data = array()){
        foreach ($data as $key => $value){
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($templateName, $data = array(), $returnHtml = false){

        $this->setData($data);
       return $this->tpl->draw($templateName, $returnHtml);

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->tpl->draw("footer");
    }

}