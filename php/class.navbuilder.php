<?php

namespace navbuilderjz;

class Navbuilder
{
    protected $navBuilder;

    public function __construct($navArray)
    {
        $this->navBuilder = '<ul class="nav navbar-nav">'.self::buildNav('', $navArray).'</ul>';
        self::arrayLoop($navArray);
    }

    protected function removeKeySlash($text)
    {
        return preg_replace('/\//', '-', $text);
    }

    protected function replaceChar($text)
    {
        $replace[] = '/\(.*?\)/';
        $replace[] = '/&/';
        $replace[] = '/ +/';

        $replacement[] = '';
        $replacement[] = '';
        $replacement[] = ' ';

        $text = preg_replace($replace, $replacement, $text);

        if (substr($text, -1) == ' ') {
            return rtrim($text, ' ');
        } else {
            return $text;
        }
    }

    protected function urlFix($title)
    {
        $title = self::replaceChar($title);

        return str_replace(' ', '-', strtolower($title));
    }

    protected function linkReplace($url, $text)
    {
        return '<a href="'.self::urlFix($url).'">'.$text.'</a>';
    }

    protected function buildNav($baseUrl, $navVal)
    {
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

    protected function arrayLoop($navVal) {

        function moreLoop($navVal, $tryArray) {
            $navBuild = '';

            foreach ($navVal as $key => $value) {
                if (is_array($value)) {
                    if (is_string($key)) {
                        $navBuild .= $key.'<br>';
                    }

                    if (is_array($value)) {
                        foreach ($value as $newKey => $newValue) {
                            if (is_string($newKey)) {
                                $navBuild .= $key.' / '.$newKey.'<br>';
                            }
                            if (is_numeric($newKey)) {
                                $navBuild .= $key.' / '.$newValue.'<br>';
                            }

                            if (is_array($newValue)) {
                                foreach ($newValue as $newKey2 => $newValue2) {
                                    if (is_string($newKey2)) {
                                        $navBuild .= $key.' / '.$newKey.' / '.$newKey2.'<br>';
                                    }
                                    if (is_numeric($newKey2)) {
                                        $navBuild .= $key.' / '.$newKey.' / '.$newValue2.'<br>';
                                    }

                                    if (is_array($newValue2)) {
                                        foreach ($newValue2 as $newKey3 => $newValue3) {
                                            if (is_string($newKey3)) {
                                                $navBuild .= $key.' / '.$newKey.' / '.$newKey2.' / '.$newKey3.'<br>';
                                            }
                                            if (is_numeric($newKey3)) {
                                                $navBuild .= $key.' / '.$newKey.' / '.$newKey2.' / '.$newValue3.'<br>';
                                            }

                                            if (is_array($newValue3)) {
                                                foreach ($newValue3 as $newKey4 => $newValue4) {
                                                    if (is_string($newKey4)) {
                                                        $navBuild .= $key.' / '.$newKey.' / '.$newKey2.' / '.$newKey3.' / '.$newKey4.'<br>';
                                                    }
                                                    if (is_numeric($newKey4)) {
                                                        $navBuild .= $key.' / '.$newKey.' / '.$newKey2.' / '.$newKey3.' / '.$newValue4.'<br>';
                                                    }
                                                }
                                            }

                                        }
                                    }

                                }
                            }

                        }
                    }
                }
            }

            return $navBuild;
        }

        echo '<pre>';
        print_r(moreLoop($navVal, array()));
        echo '</pre>';

        //moreLoop($navVal, array());
    }

    public function __toString()
    {
        return $this->navBuilder;
    }
}
