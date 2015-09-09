<?php

    namespace navbuilderjz;

    class Navbuilder {
        protected $navBuilder;

        public function __construct($navArray) {
            $this->navBuilder = '<ul class="nav navbar-nav">'.self::buildNav('', $navArray).'</ul>';
        }

        protected function removeKeySlash($text) {
            return preg_replace('/\//', '-', $text);
        }

        protected function replaceChar($text) {
            $replace = [];
            $replace[0] = '/\(.*?\)/';
            $replace[1] = '/&/';
            $replace[2] = '/ +/';

            $replacement = [];
            $replacement[0] = '';
            $replacement[1] = '';
            $replacement[2] = ' ';

            $text = preg_replace($replace, $replacement, $text);

            if (substr($text, -1) == ' ') {
                return rtrim($text, ' ');
            } else {
                return $text;
            }
        }

        protected function urlFix($title) {
            $title = self::replaceChar($title);
            return str_replace(' ', '-', strtolower($title));
        }

        protected function linkReplace($url, $text) {
            return '<a href="'.self::urlFix($url).'">'.$text.'</a>';
        }

        protected function buildNav($baseUrl, $navVal) {
            $navBuild = '';

            foreach ($navVal as $key => $value) {
                if (is_string($key)) {
                    $navBuild .= '<li>'.self::linkReplace($baseUrl.self::removeKeySlash($key), $key).'';
                    $baseUrl .= $key.'/';
                }

                if (is_numeric($key)) {
                    $navBuild .= '<li>'.self::linkReplace($baseUrl.self::removeKeySlash($value), $value).'</li>';
                }

                if (is_array($value)) {
                    $navBuild .= '<ul>'.self::buildNav($baseUrl, $value).'</ul></li>';
                    //$baseUrl = '';
                }
            }

            return $navBuild;
        }

        public function __toString() {
            return $this->navBuilder;
        }
    }