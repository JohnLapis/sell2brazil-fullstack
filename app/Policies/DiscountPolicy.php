<?php

namespace App\Policies;

class DiscountPolicy {

    private static $instance;

    private function  __construct() {
        /* Lista de pares de desontos e funções que verificam se desconto é
         * aplicável ao produto.
         */
        $this->rules = [
            [
                0.15,
                function($p) {
                    return (5 <= $p['Quantity'] && $p['Quantity'] <= 9
                            && 500 <= $p['Quantity'] * $p['UnitPrice']);
                }
            ]
        ];
    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new DiscountPolicy();
        }
        return self::$instance;
    }
}
