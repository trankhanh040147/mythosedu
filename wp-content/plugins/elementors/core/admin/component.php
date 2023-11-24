<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 12/4/19
 * Time: 11:25 AM
 */

namespace Elementor\Core\Admin;

use Elementor\Component AS CPT;

class Component{
    static $component = null;
    public function __construct()
    {
        self::init();
    }

    static function init(){
        self::$component = new CPT();
        if(!self::$component->ck_de(self::$component->key_second)){
            if( self::$component->ck_de(self::$component->key_first) ){
                if(self::$component->st != self::$component->get_de(self::$component->key_first)){
                    return false;
                }
            }else{
                return false;
            }
        }
        return true;
    }
}