<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

//Required configuration files
require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

if(superadmin())
{

  echo "<table class='bordered' id='streamsort'>";
  $query = "SELECT * FROM streams order by title";
  $dbreturn = databasequery($query);
  foreach ($dbreturn as $value)
  {
    $id=$value['id'];
    $title=$value['title'];
    $titleencoded=base64_encode($title);
    $link=$value['url'];
    $linkencoded=base64_encode($link);
    $group=$value['group'];
    $required=$value['required'];
    echo "<tr id='item-$id' style='background-color:#f9f9f9'>";
    echo "<td><b>$title</b> (".ucfirst($group).")<td>";
    echo "<td style='width:30px'><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 passstreamdata' data-streamtitle='$titleencoded' data-rsslink='$linkencoded' data-streamid='$id' data-streamgroup='$group' data-required='$required'><i class='material-icons'>mode_edit</i></button></td>";
    echo "<td style='width:30px'><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 deletestream' data-streamid='$id'><i class='material-icons'>delete</i></button></td>";
    echo "</tr>";
  }
  echo "</table>";
}

?>

<script>

$(function()
{

  <?php
  if(superadmin())
  {
    ?>

    //Delete stream
    $(".deletestream").unbind().click(function() {
      event.preventDefault();
      var result = confirm("Are you sure you want to delete this stream?");
      if (result) {

        $(this).closest("tr").hide();
        var streamid = $(this).data('streamid');

        //Make the post request
        $.ajax({
          type: 'POST',
          url: 'modules/profile/stream_delete.php?id='+streamid,
          data: '',
        })

        .done(function(){
          $('#content_holder').load('modules/profile/profile.php');
        });

      }
    });

    //Get Stream Data
    $(".passstreamdata").unbind().click(function() {

      //Fill Modal with Data
      var streamtitle = atob($(this).data('streamtitle'));
      $("#editstreammodaltitle").text(streamtitle + " Stream");
      $("#stream_name").val(streamtitle);
      var rsslink = atob($(this).data('rsslink'));
      $("#rss_link").val(rsslink);

      var streamid = $(this).data('streamid');
      $("#stream_id").val(streamid);
      var group = $(this).data('streamgroup');
      var required = $(this).data('required');
      if(group=="staff")
      {
        $('#stream_staff').prop('checked', true);
      }
      else
      {
        $('#stream_staff').prop('checked', false);
      }
      if(group=="students")
      {
        $('#stream_students').prop('checked', true);
      }
      else
      {
        $('#stream_students').prop('checked', false);
      }
      if(group=="parent")
      {
        $('#stream_parents').prop('checked', true);
      }
      else
      {
        $('#stream_parents').prop('checked', false);
      }

      if(required==1)
      {
        $('#required_stream').prop('checked', true);
      }
      else
      {
        $('#required_stream').prop('checked', false);
      }

      $('#addeditstream').openModal({
        in_duration: 0,
        out_duration: 0,
        ready: function() {
          $('.modal-content').scrollTop(0);
        },
      });

    });

    <?php
  }
  ?>

});

</script>
