<?php

abstract class BaseController 
{
    public function GetContext(): array 
    {
        return [];
    }
    
    abstract public function Get();
}

?>
