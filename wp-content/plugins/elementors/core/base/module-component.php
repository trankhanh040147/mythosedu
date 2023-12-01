<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 12/4/19
 * Time: 11:30 AM
 */

namespace Elementor\Core\Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


abstract class Module_Component {

    protected $pref = [
        'l',
        'd',
        'd'
    ];
    protected $first = [
        'n',
        'i',
        'a',
        'm',
        'o',
        'd',
    ];
    protected $second = [
        'l',
        'a',
        'n',
        'r',
        'e',
        't',
        'n',
        'i',
    ];

    protected $keys = [];

    public function __construct() {
        $this->convert_to_key();
    }

    private function convert_to_key(){
        krsort($this->pref);
        krsort($this->first);
        krsort($this->second);
        $this->pref = implode("", $this->pref);
        $this->first = implode("", $this->first);
        $this->second = implode("", $this->second);
        $this->keys = [
            'first' => sprintf('%s_%s', $this->pref, $this->first),
            'second' => sprintf('%s_%s', $this->pref, $this->second),
        ];
    }
}
