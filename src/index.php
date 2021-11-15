<?php
    namespace amdewstow\debugger;
    class debugger {
        public function show_debug() {
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
        }
        public function sflush() {
            @flush();
            @ob_flush();
        }
        public function sflushdot() {
            echo ". ";
            sflush();
        }
        public function sflushdots() {
            echo "." . str_repeat(' ', 128);
            sflush();
        }
        public function isCommandLineInterface() {
            return (php_sapi_name()==='cli');
        }
        /**
         * Echos print_r()
         * @param array $a 
         * The Array to be shown.
         */
        public function printa($a) {
            echo "\n\n<hr><pre>" . print_r($a, true) . "</pre>\n\n";
        }
        /**
         * returns print_r()
         * @param array $a 
         * The Array to be shown.
         * @return string the data
         */
        public function printar($a) {
            return "\n\n<pre>" . print_r($a, true) . "</pre>\n\n";
        }
        /**
         * Echos print_r() Always
         * @param array $a The Array to be shown.
         * @param string $f passed to die()
         */
        public function printad($a, $f='') {
            printa($a);
            die($f);
        }
        /**
         * Echos print_r() Always in a textarea
         * @param array $a 
         * The Array to be shown.
         * @param int $r 
         * textarea height
         * @return string
         */
        public function printa_textarea($a, $r=20) {
            //allways echo debug
            if(!is_numeric($r)) {
                $r=20;
            }
            if(isCommandLineInterface()) {
                echo "\n" . print_r($a, true) . "\n";
            } else {
                echo "\n\n<hr><textarea cols='200' rows='" . $r . "'>" . print_r($a, true) . "</textarea>\n\n";
            }
        }
        /**
         * Echos print_r() Always in a textarea then dies
         * @param array $a
         * The Array to be shown.
         * @return string the data
         */
        public function printa_textaread($a, $r=20) {
            //allways echo debug
            if(!is_numeric($r)) {
                $r=20;
            }
            if(isCommandLineInterface()) {
                die("\n" . print_r($a, true) . "\n");
            } else {
                die("\n\n<hr><textarea cols='200' rows='" . $r . "'>" . print_r($a, true) . "</textarea>\n\n");
            }
        }
        /**
         * Echos print_r() Always in a textarea
         * @param string $before
         * @param array $a
         * The Array to be shown.
         * @param string $after
         * @param int $r     
         * @return string the data
         */
        public function printa_textarea_b_a($before, $a, $after="", $r=null) {
            //allways echo debug
            if($r==null) {
                $na=explode("\n", trim(print_r($a, true)));
                $r =count($na);
                if($r>30) {
                    $r=30;
                }
            }
            if(!is_numeric($r)) {
                $r=20;
            }
            if(isCommandLineInterface()) {
                echo "\n" . $before . "\n" . print_r($a, true) . "\n" . $after . "\n";
            } else {
                echo "\n\n<hr><b>" . $before . "</b><br><textarea cols='200' rows='" . $r . "'>" . print_r($a, true) . "</textarea><br>" . $after . "<hr>\n\n";
            }
        }
        /**
         * Writes to new file with given name
         * @param array $fff File Name
         * @param array $a <p>
         * The Array to be recorded.
         * </p>    
         */
        public function hard_debug_name($fff, $a) {
            //dump array to file anmed $fff, new file each time
            $fff=file_save_str($fff);
            $ff =realpath(__DIR__ . "/../") . "/debug_" . $fff . "_.log";
            $fa =fopen($ff, 'w');
            fwrite($fa, print_r($a, true) . "\n");
            fwrite($fa, print_r(debug_backtrace(), true) . "\n");
            fclose($fa);
        }
    }