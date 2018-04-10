<?php
/**
 * Copyright 2015  rasmusbihllarsen  (email : hello@rasmusbihllarsen.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

defined( 'ABSPATH' ) or die();

global $wpdb;

function execute_request( $args ) {
	$target_url = create_url( $args );
	$data = wp_remote_get( $target_url );
	var_dump( $data['body'] );
}

// Create an url based on 
function create_url( $args ) {
	global $base_url;
	
	$base_url = add_query_arg( 'wc-api', 'software-api', $base_url );
	
	return $base_url . '&' . http_build_query( $args );
}

?>
<style>
  #side {
    width:20%;
    text-align:center;
    padding-top:120px;
    float:right;
  }
  
  #side span {
    display:block;
  }
  
  #content {
    width:75%;
    float:left
  }
  
  #side, #content {
    display:block;
  }
  
  table{
    margin-top:75px;
  }
  
  tr td:first-child{
    width:80px;
  }
  
  td {
    vertical-align:top;
    padding:2px 0;
  }
  
  input[type="number"],
  input[type="text"], textarea {
    width:500px;
    border: 0px;
    color: #999999;
  }
  
  input[type="number"]:focus,
  input[type="text"]:focus, textarea:focus {
    color:black;
  }
  
  input[type="number"] {
    width:100px;
  }
  
  textarea {
    height:150px;
    font-family: 'Courier New', 'Courier', serif;
  }
  
  textarea:focus {
    border-left: 5px solid lightgray;
  }
  
  input[type="button"],
  input[type="submit"] {
    background: lightblue;
    border: 0px;
    padding: 10px 25px;
  }
  
  input[type="button"] {
    background:salmon;
  }
  
  .add-license{
    border:1px dashed lightblue;
    display:block;
    overflow:hidden;
    padding:25px 40px 27px;
    width:inherit;
    background: #f4f4f4;
    margin: 80px auto;
    float:left;
    clear:left;
  }
  
  .add-license input[type="text"] {
    height:39px;
    font-weight: 300;
  }
  
  .add-license input {
    float:left;
    clear:left;
  }
</style>
<div class="wrap">
  <div id="side">
    <span style="width:100%;text-align:left;margin-bottom:50px;">
      This is the <strong>Seasonal Custom CSS</strong>-plugin, by <a href="http://rblarsen.dk" rel="nofollow" target="_blank">rblarsen</a>. This plugin allows you to set specific dates where CSS should be added to your site.<br /><br /><em>An example of use, could be:</em><br />You want your site to have some red every Christmas to make your site look different than normal, when it is the holidays. You enter the name "Christmas CSS", from the 1st to the 26th of December and last you put in the CSS and save it. And now the CSS will be shown at Christmas!<br /><br /><h3>Need support?</h3>Are you in need of support in regards to this plugin, then visit the official <a href="http://rblarsen.dk/support" rel="nofollow" target="_blank">support-site</a>.
    </span>
    <span>AN</span>
    <a href="http://rblarsen.dk" rel="nofollow" target="_blank">
      <img src="http://rblarsen.dk/wp-content/uploads/2015/02/rblarsen.png" alt="A RBLARSEN PLUGIN" width="120" />
    </a>
    <span>PLUGIN</span>
  </div>
  
  <div id="content">
    <h2>Seasonal Custom CSS</h2>
    <table>
    <?php

    $getCSS = $wpdb->get_results( 'SELECT * FROM '.$wpdb->base_prefix . 'seasonal_custom_css ORDER BY id ASC' );

  $out = "";
  foreach($getCSS as $css){
    $out .= '<tr><td>';
    $out .= '<form action="'.plugin_dir_url( __FILE__ ).'send.php?type=edit" method="post">';
    $out .= '<label>'.__('Name', 'seasonal-css').':</label>';
    $out .= '</td><td colspan="3">';
    $out .= '<input type="hidden" name="id" value="'.$css->id.'" />';
    $out .= '<input type="text" name="name" id="name-'.$css->id.'" value="'.$css->name.'" />';
    $out .= '</td></tr><tr><td><label>'.__('From date', 'seasonal-css').':</label></td><td>';
    $out .= '<input type="number" name="date-from-day" id="date-from-day-'.$css->id.'" maxlength="2" value="'.date("d", strtotime($css->from_date)).'" placeholder="DD" /> - ';
    $out .= '<input type="number" name="date-from-month" id="date-from-month-'.$css->id.'" maxlength="2" value="'.date("m", strtotime($css->from_date)).'" placeholder="MM" />';
    $out .= '</td><td><label>'.__('To date', 'seasonal-css').':</label></td><td>';
    $out .= '<input type="number" name="date-to-day" id="date-to-day-'.$css->id.'" maxlength="2" value="'.date("d", strtotime($css->to_date)).'" placeholder="DD" /> - ';
    $out .= '<input type="number" name="date-to-month" id="date-to-month-'.$css->id.'" maxlength="2" value="'.date("m", strtotime($css->to_date)).'" placeholder="MM" />';
    $out .= '</td></tr><tr><td>';
    $out .= '<label>'.__('CSS', 'seasonal-css').':</label>';
    $out .= '</td><td colspan="3">';
    $out .= '<textarea name="text" id="text-'.$css->id.'">'.$css->custom_css.'</textarea>';
    $out .= '</td></tr><tr><td colspan="4" style="text-align:right;">';
    $out .= '<input type="button" onclick="window.location.href='."'".plugin_dir_url( __FILE__ )."send.php?type=delete&id=".$css->id."'".'" value="'.__('Delete', 'seasonal-css').'" />';
    $out .= '<input type="submit" value="'.__('Save', 'seasonal-css').'" />';
    $out .= '</form>';
    $out .= '</td></tr>';
    $out .= '<tr height="45"><td valign="middle" colspan="4"><hr /></td></tr>';
  }

  echo $out;

  // if(1 == 2){
    ?>
      <tr>
        <td>
          <form action="<?php echo plugin_dir_url( __FILE__ ); ?>send.php?type=add" method="post">
          <label for="name-new">Name:</label>
        </td>
        <td colspan="3">
          <input type="hidden" name="id-new" id="id-new" value="new" />
          <input type="text" name="name-new" id="name-new" value="" />
        </td>
      </tr>
      <tr>
        <td>
          <label for="date-from-day-new">From date:</label>
        </td>
        <td>
          <input type="number" name="date-from-day-new" id="date-from-day-new" maxlength="2" value="" placeholder="DD" /> - 
          <input type="number" name="date-from-month-new" id="date-from-month-new" maxlength="2" value="" placeholder="MM" />
        </td>
        <td>
          <label for="date-to-day-new">To date:</label>
        </td>
        <td>
          <input type="number" name="date-to-day-new" id="date-to-day-new" maxlength="2" value="" placeholder="DD" /> - 
          <input type="number" name="date-to-month-new" id="date-to-month-new" maxlength="2" value="" placeholder="MM" />
        </td>
      </tr>
      <tr>
        <td>
          <label for="text-new">CSS:</label>
        </td>
        <td colspan="3">
          <textarea name="text-new" id="text-new"></textarea>
        </td>
      </tr>
      <tr>
        <td colspan="4" style="text-align:right;">
          <input type="submit" value="Add new CSS" />
          </form>
        </td>
      </tr>
  </table>
  </div>
  <?php // } else { ?>
  <!-- </table>
  </div>
  <div class="add-license">
    <p>You need a license to add more periods.</p>
    <p>Already got a license? Write it here and let's get going!</p>
    <form action="<?php //echo plugin_dir_url( __FILE__ ); ?>send.php?type=activate_license" method="post">
      <input type="text" name="api-license" placeholder="License" />
      <input type="text" name="api-email" placeholder="License E-mail" />
      <input type="submit" style="float:right;" value="Activate" />
    </form>
    <p style="float:left;display:inline-block;clear:left;">If you don't have a license, you can <a href="http://rblarsen.dk/product/seasonal-custom-css-license/" rel="nofollow" target="_blank">buy one</a>.</p>
  </div> -->
  <?php //} ?>
</div>
