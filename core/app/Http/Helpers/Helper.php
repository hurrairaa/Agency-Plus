<?php
use App\BasicSetting as BS;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\Page;

if (! function_exists('setEnvironmentValue')) {
  function setEnvironmentValue(array $values)
  {

      $envFile = app()->environmentFilePath();
      $str = file_get_contents($envFile);

      if (count($values) > 0) {
          foreach ($values as $envKey => $envValue) {

              $str .= "\n"; // In case the searched variable is in the last line without \n
              $keyPosition = strpos($str, "{$envKey}=");
              $endOfLinePosition = strpos($str, "\n", $keyPosition);
              $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

              // If key does not exist, add it
              if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                  $str .= "{$envKey}={$envValue}\n";
              } else {
                  $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
              }

          }
      }

      $str = substr($str, 0, -1);
      if (!file_put_contents($envFile, $str)) return false;
      return true;

  }
}


if (! function_exists('convertUtf8')) {
    function convertUtf8( $value ) {
        return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
    }
}


if (! function_exists('make_slug')) {
    function make_slug($string) {
        $slug = preg_replace('/\s+/u', '-', trim($string));
        $slug = str_replace("/","",$slug);
        $slug = str_replace("?","",$slug);
        return $slug;
    }
}


if (! function_exists('make_input_name')) {
    function make_input_name($string) {
        return preg_replace('/\s+/u', '_', trim($string));
    }
}


if (! function_exists('getVersion')) {
    function getVersion($version) {
        $arr = explode("_", $version, 2);
        $version = $arr[0];
        return $version;
    }
}


if (! function_exists('hasCategory')) {
    function hasCategory($version) {
        if(strpos($version, "no_category") !== false){
            return false;
        } else {
            return true;
        }
    }
}

if (! function_exists('isDark')) {
    function isDark($version) {
        if(strpos($version, "dark") !== false){
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('slug_create') ) {
    function slug_create($val) {
        $slug = preg_replace('/\s+/u', '-', trim($val));
        $slug = str_replace("/","",$slug);
        $slug = str_replace("?","",$slug);
        return $slug;
    }
}


if (!function_exists('getHref') ) {
    function getHref($link) {
        $href = "#";

        if ($link["type"] == 'home') {
            $href = route('front.index');
        } else if ($link["type"] == 'services') {
            $href = route('front.services');
        } else if ($link["type"] == 'packages') {
            $href = route('front.packages');
        } else if ($link["type"] == 'portfolios') {
            $href = route('front.portfolios');
        } else if ($link["type"] == 'team') {
            $href = route('front.team');
        } else if ($link["type"] == 'career') {
            $href = route('front.career');
        } else if ($link["type"] == 'calendar') {
            $href = route('front.calendar');
        } else if ($link["type"] == 'gallery') {
            $href = route('front.gallery');
        } else if ($link["type"] == 'faq') {
            $href = route('front.faq');
        } else if ($link["type"] == 'products') {
            $href = route('front.product');
        } else if ($link["type"] == 'cart') {
            $href = route('front.cart');
        } else if ($link["type"] == 'checkout') {
            $href = route('front.checkout');
        } else if ($link["type"] == 'blogs') {
            $href = route('front.blogs');
        } else if ($link["type"] == 'rss') {
            $href = route('front.rss');
        } else if ($link["type"] == 'contact') {
            $href = route('front.contact');
        } else if ($link["type"] == 'custom') {
            if (empty($link["href"])) {
                $href = "#";
            } else {
                $href = $link["href"];
            }
        } else {
            $pageid = (int)$link["type"];
            $page = Page::find($pageid);
            $href = route('front.dynamicPage', [$page->slug, $page->id]);
        }

        return $href;
    }
}



if (!function_exists('create_menu') ) {
    function create_menu($arr) {
        echo '<ul style="z-index: 0;">';
            foreach ($arr["children"] as $el) {

                // determine if the class is 'submenus' or not
                $class = null;
                if (array_key_exists("children", $el)) {
                    $class = 'class="submenus"';
                }


                // determine the href
                $href = getHref($el);


                echo '<li '.$class.'>';
                    echo '<a  href="'.$href.'" target="'.$el["target"].'">'.$el["text"].'</a>';
                    if (array_key_exists("children", $el)) {
                        create_menu($el);
                    }
                echo '</li>';
            }
        echo '</ul>';
    }
}



if (!function_exists('hex2rgb') ) {
    function hex2rgb( $colour ) {
        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }
}


if (!function_exists('replaceBaseUrl') ) {
    function replaceBaseUrl($html) {
        $startDelimiter = 'src="';
        $endDelimiter = '/assets/front/img/summernote';
        // $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($html, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($html, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $html = substr_replace($html, url('/'), $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }

        return $html;
    }
}
?>
