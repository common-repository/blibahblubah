<?php
/*
Plugin Name: blibahblubah
Plugin URI: http://ehogan.itis5am.com:8080/blibahblubah
Description: Blibahblubah is a plugin that allows the blogger to setup a tag cloud that changes on mouseover.
Version: 1.1
Author: Ed Hogan
Author URI: http://ehogan.itis5am.com:8080/
*/
/*  blibahblubah v1.1 Plugin for WordPress 
    Copyright (C) 2008 Edward P. Hogan    

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

  /************************************
   * blibahblubah hooks
   ************************************/

  /* filters to alter content */
  add_filter('wp_tag_cloud', 'blibahblubah_filter__wp_tag_cloud', 99);
  /* actions to alter behavior */
  add_action('admin_menu', 'blibahblubah_add_pages');

  /************************************
   * blibahblubah options functions
   ************************************/

  function blibahblubah_is_authorized() {
    global $user_level;
    if (function_exists("current_user_can")) {
      return current_user_can('activate_plugins');
    }
    else {
      return $user_level > 5;
    }
  }

  function blibahblubah_add_pages() {
    /* add option page */
    add_options_page('Blibahblubah', 'Blibahblubah', 8, 'blibahblubah_options', 'blibahblubah_options_page');
  }

  function blibahblubah_options_page() {
    global $ol_flash, $_POST;
    if (!blibahblubah_is_authorized()) {
      $ol_flash = "You do not have sufficient privilges.";
      return;
    }
    /* get options settings */
    if (isset($_POST['blibahblubah_fontsize'])) {
      update_option('blibahblubah_fontsize', $_POST['blibahblubah_fontsize']);
      $ol_flash = "Your settings have been saved.";
    }
    if (isset($_POST['blibahblubah_highlight'])) {
      $post_highlight = $_POST['blibahblubah_highlight'];
      if ($post_highlight == "none") {
        $post_highlight = "";
      }
      update_option('blibahblubah_highlight', $post_highlight);
      $ol_flash = "Your settings have been saved.";
    }
    if (isset($_POST['blibahblubah_decorate'])) {
      update_option('blibahblubah_decorate', $_POST['blibahblubah_decorate']);
      $ol_flash = "Your settings have been saved.";
    }
    if (isset($_POST['blibahblubah_border'])) {
      update_option('blibahblubah_border', $_POST['blibahblubah_border']);
      $ol_flash = "Your settings have been saved.";
    }
    /* get options from database */
    $blibahblubah_fontsize = get_option('blibahblubah_fontsize');
    $blibahblubah_highlight = get_option('blibahblubah_highlight');
    $blibahblubah_decorate = get_option('blibahblubah_decorate');
    $blibahblubah_border = get_option('blibahblubah_border');
    if ($blibahblubah_fontsize == "") {
      $blibahblubah_fontsize = 0;
    }
    if ($blibahblubah_decorate == "") {
      $blibahblubah_decorate = "none";
    }
    /* draw options page */
    include("blibahblubah_options.php");
  }
   
  /************************************
   * blibahblubah filter
   ************************************/
   
  function blibahblubah_filter__wp_tag_cloud($tag_cloud_content) {
    /* get options */
    $blibahblubah_fontsize = get_option('blibahblubah_fontsize');
    $blibahblubah_highlight = get_option('blibahblubah_highlight');
    $blibahblubah_decorate = get_option('blibahblubah_decorate');
    $blibahblubah_border = get_option('blibahblubah_border');
    /* alter the tag cloud */
    $out_tag_cloud_content = "";
    $out_css_style = "<style type=\"text/css\">\n<!--\n";
    $tags = explode("\n", $tag_cloud_content);
    //error_log(print_r($tags, TRUE));
    foreach ($tags as $tag) {
      /* each $tag looks like:
       * [0] => <a href='http://somelink' class='tag-link-12' title='1 topic' style='font-size: 8pt;'>blibahblubah</a>\n */
      /* find the font-size and the tag-link */
      $style = strstr($tag, "style='font-size: ");
      $class = strstr($tag, "class='tag-link-");
      /* if anything failed bail out */
      if (($style == FALSE) || ($class == FALSE)) {
        $out_tag_cloud_content .= $tag . "\n";
        continue;
      }
      /* find the end of the link */
      $endoflink = strstr($style, "pt;'>");
      if ($endoflink == FALSE) {
        $out_tag_cloud_content .= $tag . "\n";
        continue;
      }
      /* do the sscanfs for some info */
      $status1 = sscanf($style, "style='font-size: %dpt;'", $fontsize);
      $status2 = sscanf($class, "class='tag-link-%d'", $classnumber);
      if (($status1 != 1) || ($status2 != 1)) {
        $out_tag_cloud_content .= $tag . "\n";
        continue;
      }
      /* strip out the style since it replaces the generated CSS */
      $out_tag_cloud_content .= substr($tag, 0, strlen($tag) - strlen($style)) . substr($endoflink, 4) . "\n";
      
      /* do the css work */
      $css_link = "A.tag-link-" . $classnumber . ":link {text-decoration: none; font-size: " . $fontsize . "pt;}\n";
      $css_hover = "A.tag-link-" . $classnumber . ":hover {";
      /* FONT-SIZE */
      if ($blibahblubah_fontsize > 0) {
        $css_hover .= "font-size: " . ($fontsize + $blibahblubah_fontsize) . "pt; ";
      }
      /* HIGHLIGHT */
      if ($blibahblubah_highlight != "") {
        $css_hover .= "background-color: #" . $blibahblubah_highlight . "; ";
      }
      /* BORDER STYLE */
      switch($blibahblubah_border) {
        case 'bxso':
          $css_hover .= "border-style: solid; ";
          $css_hover .= "border-width: thin; ";
          break;
        case 'bxda':
          $css_hover .= "border-style: dashed; ";
          $css_hover .= "border-width: thin; ";
          break;
        case 'bxdo':
          $css_hover .= "border-style: dotted; ";
          $css_hover .= "border-width: thin; ";
          break;
        case 'none':
        default:
          break;
      }
      /* setup css_hover and mouseout decorate commands */
      switch($blibahblubah_decorate) {
        case 'ital':
          $css_hover .= "font-style: italic; ";
          break;
        case 'smcp':
          $css_hover .= "font-variant: small-caps; ";
          break;
        case 'udub':
          $css_hover .= "border-bottom-style: double; ";
          $css_hover .= "border-bottom-width: medium; ";
          break;
        case 'udas':
          $css_hover .= "border-bottom-style: dashed; ";
          $css_hover .= "border-bottom-width: thin; ";
          break;
        case 'bold':
          $css_hover .= "font-weight: bold; ";
          break;
        case 'boun':
          $css_hover .= "font-weight: bold; ";
          $css_hover .= "text-decoration: underline; ";
          break;
        case 'boit':
          $css_hover .= "font-weight: bold; ";
          $css_hover .= "font-style: italic; ";
          break;
        case 'none':
        default:
          break;
      }
      $css_hover .= "}\n";
      $out_css_style .= $css_link . $css_hover;
    }
    $out_css_style .= "//-->\n</style>\n";
    
    return $out_css_style . $out_tag_cloud_content;

  }

?>
