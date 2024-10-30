<?php
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
?>

<div class="wrap">
  <h2>Set up your Blibahblubah Options</h2>
  <p>This plugin gives you the ability to alter the behavior of your tag cloud when the user mouses over the tags.</p>
  <table>
  <tr><td>
  <form action="" method="post" name="blibahblubah_form">
    <input type="hidden" name="redirect" value="true" />
    <ol>
<?php
  echo "      <li>\n";
  echo "        Font Growth on mouseover: \n";
  echo "        <input type=\"text\" name=\"blibahblubah_fontsize\" size=10 value=\"" . $blibahblubah_fontsize . "\" />\n";
  echo "      </li>\n";
  echo "      <li>\n";
  echo "        Highlight Color on mouseover: \n";
  echo "        <input type=\"text\" name=\"blibahblubah_highlight\" size=10 value=\"" . $blibahblubah_highlight . "\" onchange=\"blibahblubah_highlightsetcolor();\" />\n";
  echo "        <select id=\"blibahblubah_highlight_select\" name=\"blibahblubah_highlight_select\" onchange=\"blibahblubah_highlightselectonchange();\">\n";
  if (($blibahblubah_highlight != "") &&
      ($blibahblubah_highlight != "FFFF99") &&
      ($blibahblubah_highlight != "87CEFA") &&
      ($blibahblubah_highlight != "90EE90") &&
      ($blibahblubah_highlight != "FFB6C1")) {
    $blibahblubah_highlight = "custom";
  }
  echo "          <option value=\"none\" " . ($blibahblubah_higlight == "" ? "selected=\"selected\"" : "") . ">none</option>\n";
  echo "          <option value=\"FFFF99\" " . ($blibahblubah_highlight == "FFFF99" ? "selected=\"selected\"" : "") . ">yellow highlight</option>\n";
  echo "          <option value=\"87CEFA\" " . ($blibahblubah_highlight == "87CEFA" ? "selected=\"selected\"" : "") . ">light-blue highlight</option>\n";
  echo "          <option value=\"90EE90\" " . ($blibahblubah_highlight == "90EE90" ? "selected=\"selected\"" : "") . ">light-green highlight</option>\n";
  echo "          <option value=\"FFB6C1\" " . ($blibahblubah_highlight == "FFB6C1" ? "selected=\"selected\"" : "") . ">pink highlight</option>\n";
  echo "          <option value=\"custom\" " . ($blibahblubah_highlight == "custom" ? "selected=\"selected\"" : "") . " disabled=\"disabled\">custom</option>\n";
  echo "        </select>\n";
  echo "        <a id=\"preview\"><span id=\"blibahblubah_highlightsample\">sample</span></a>\n";
  echo "      </li>\n";
  echo "      <li>\n";
  echo "        Font Decoration on mouseover: \n";
  echo "        <select id=\"blibahblubah_decorate\" name=\"blibahblubah_decorate\" onchange=\"blibahblubah_linkdecorateonchange();\">\n";
  echo "          <option value=\"none\" " .  ($blibahblubah_decorate == "none" ? "selected=\"selected\"" : "") . ">none</option>\n";
  echo "          <option value=\"ital\" " . ($blibahblubah_decorate == "ital" ? "selected=\"selected\"" : "") . ">italic</option>\n";
  echo "          <option value=\"smcp\" " . ($blibahblubah_decorate == "smcp" ? "selected=\"selected\"" : "") . ">small caps</option>\n";
  echo "          <option value=\"udub\" " . ($blibahblubah_decorate == "udub" ? "selected=\"selected\"" : "") . ">double underline</option>\n";
  echo "          <option value=\"udas\" " . ($blibahblubah_decorate == "udas" ? "selected=\"selected\"" : "") . ">dashed underline</option>\n";
  echo "          <option value=\"bold\" " . ($blibahblubah_decorate == "bold" ? "selected=\"selected\"" : "") . ">bold</option>\n";
  echo "          <option value=\"boun\" " . ($blibahblubah_decorate == "boun" ? "selected=\"selected\"" : "") . ">bold underline</option>\n";
  echo "          <option value=\"boit\" " . ($blibahblubah_decorate == "boit" ? "selected=\"selected\"" : "") . ">bold italic</option>\n";
  echo "        </select>\n";
  echo "        <a id=\"preview\"><span id=\"blibahblubah_decoratetext\">sample</span></a>\n";
  echo "      </li>\n";
  echo "      <li>\n";
  echo "        Bordering on mouseover: \n";
  echo "        <select id=\"blibahblubah_border\" name=\"blibahblubah_border\" onchange=\"blibahblubah_borderingonchange();\">\n";
  echo "          <option value=\"none\" " .  ($blibahblubah_border == "none" ? "selected=\"selected\"" : "") . ">none</option>\n";
  echo "          <option value=\"bxso\" " . ($blibahblubah_border == "bxso" ? "selected=\"selected\"" : "") . ">solid box</option>\n";
  echo "          <option value=\"bxda\" " . ($blibahblubah_border == "bxda" ? "selected=\"selected\"" : "") . ">dashed box</option>\n";
  echo "          <option value=\"bxdo\" " . ($blibahblubah_border == "bxdo" ? "selected=\"selected\"" : "") . ">dotted box</option>\n";
  echo "        </select>\n";
  echo "        <a id=\"preview\"><span id=\"blibahblubah_bordertext\">sample</span></a>\n";
?>
      </li>
      <br>
    </ol>
    <p><input type="submit" value="Save Settings" /></p>
  </form>
  </td>
  <td width="25%">
    <center>
      <h3>Sample Tag Cloud</h3>
      <?php wp_tag_cloud(); ?>
    </center>
  </td></tr>
  </table>
</div>

<script language="javascript" type="text/javascript"><!--
  function blibahblubah_linkdecorateonchange() {
    var decorate = document.blibahblubah_form.blibahblubah_decorate.options[document.blibahblubah_form.blibahblubah_decorate.selectedIndex].value;
    var linksampletext = document.getElementById('blibahblubah_decoratetext');
    /* clear old style */
    linksampletext.style.setProperty('background-color', document.bgColor);
    linksampletext.style.setProperty('border-style', 'none');
    linksampletext.style.setProperty('border-width', 'none');
    linksampletext.style.setProperty('font-weight', 'normal');
    linksampletext.style.setProperty('font-style', 'normal');
    linksampletext.style.setProperty('font-variant', 'normal');
    linksampletext.style.setProperty('text-decoration', 'none');
    switch (decorate) {
      /* Font Style */
      case 'ital':
        linksampletext.style.setProperty('font-style', 'italic');
        break;
      case 'smcp':
        linksampletext.style.setProperty('font-variant', 'small-caps');
        break;
      case 'udub':
        linksampletext.style.setProperty('border-bottom-style', 'double');
        linksampletext.style.setProperty('border-bottom-width', 'medium');
        break;
      case 'udas':
        linksampletext.style.setProperty('border-bottom-style', 'dashed');
        linksampletext.style.setProperty('border-bottom-width', 'thin');
        break;
      case 'bold':
        linksampletext.style.setProperty('font-weight', 'bold');
        break;
      case 'boun':
        linksampletext.style.setProperty('text-decoration', 'underline');
        linksampletext.style.setProperty('font-weight', 'bold');
        break;
      case 'boit':
        linksampletext.style.setProperty('font-weight', 'bold');
        linksampletext.style.setProperty('font-style', 'italic');
        break;
      case 'none':
      default:
        break;
    }
    return true;
  }

  function blibahblubah_borderingonchange() {
    var decorate = document.blibahblubah_form.blibahblubah_border.options[document.blibahblubah_form.blibahblubah_border.selectedIndex].value;
    var linksampletext = document.getElementById('blibahblubah_bordertext');
    /* clear old style */
    linksampletext.style.setProperty('border-style', 'none');
    linksampletext.style.setProperty('border-width', 'none');
    switch (decorate) {
      /* Bordering */
      case 'bxso':
        linksampletext.style.setProperty('border-style', 'solid');
        linksampletext.style.setProperty('border-width', 'thin');
        break;
      case 'bxda':
        linksampletext.style.setProperty('border-style', 'dashed');
        linksampletext.style.setProperty('border-width', 'thin');
        break;
      case 'bxdo':
        linksampletext.style.setProperty('border-style', 'dotted');
        linksampletext.style.setProperty('border-width', 'thin');
        break;
      case 'none':
      default:
        break;
    }
    return true;
  }

  function blibahblubah_highlightselectonchange() {
    var highlight = document.blibahblubah_form.blibahblubah_highlight_select.options[document.blibahblubah_form.blibahblubah_highlight_select.selectedIndex].value;
    var linksampletext = document.getElementById('blibahblubah_highlightsample');
    if (highlight == "none") {
      highlight = "";
    }
    document.blibahblubah_form.blibahblubah_highlight.value = highlight;
    blibahblubah_highlightsetcolor();
    return true;
  }

  function blibahblubah_highlightsetcolor() {
    var highlight = document.blibahblubah_form.blibahblubah_highlight.value;
    var linksampletext = document.getElementById('blibahblubah_highlightsample');
    if (highlight == "") {
      linksampletext.style.setProperty('background-color', document.bgColor);
    }
    else {
      linksampletext.style.setProperty('background-color', "#" + highlight);
    }
    return true;
  }

  /* run it initially at load time */
  blibahblubah_linkdecorateonchange();
  blibahblubah_highlightsetcolor();
  blibahblubah_borderingonchange();

//--></script>
