<?php
// 2020-05-19 v0.1 Marko Stanojevic 2017/0081


if( !function_exists('require_path'))
{
    /**
     * require all the files on the given path
     * 
     * @param path
     */
    function require_path($path)
    {
        foreach( glob($path . "/*.php" ) as $file)
            require_once($file);
    }
    
}
