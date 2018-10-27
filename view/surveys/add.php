<?php
require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../core/I18n.php");
$view = ViewManager::getInstance();
$user = $view->getVariable("user");
$view->setVariable("title", "Add survey");
?>

<div class="container" id="main">
  <form action="index.php?controller=surveys&amp;action=add" method="POST">
    <div class="row">
      <div class="col">
	<div class="container">
	  <div class="form-group">
	    <input type="text" name="title" class="form-control-lg main-control" placeholder="<?= i18n("Title"); ?>"></input>
	  </div>
	  <div class="form-group">
	    <input type="text" name="description" class="form-control" placeholder="<?= i18n("Description"); ?>"></input>
	  </div>
	  <!--  Campo de envío de correos (para entrega 4):    
		
		<div class="form-group">
		  <input type="text" class="form-control" name="correos" id="entry_correos" placeholder="Introduce aquí los correos"></input>
		  <script>
		    $("#entry_correos").tokenfield();
		  </script>
		</div> -->
	  
	  <input type="hidden" id="entry_date_num" name="num_dates" value=""/>
	  <div class="container col-md-8 col-lg-6 col-xl-4">
	    <div class="row">
	      <span><?= i18n("In which dates will you meet?"); ?></span>
	    </div>
	    <div class="form-group row" id="entry_date_list">
	      <!-- insert date pickers here -->
	    </div>
	    <div class="form-group row">
	      <a href="#" id="entry_add_date" class="btn btn-block btn-light">
		<span class="fas fa-plus"></span>
	      </a>
	      <script>
                
$(function() {
    add_date();
});

function add_date() {
    if(typeof add_date.date_num == 'undefined') {
	add_date.date_num = 1;
    }
    var date_num = add_date.date_num;
    var date_id = "entry_date" + date_num;
    var date_name = "date" + date_num;
    
    date_list = $("#entry_date_num").val().split(" ");
    date_list.push(date_num);
    $("#entry_date_num").val(date_list.join(" "));
    
    $("#entry_date_list").append(`
				 <div id="${date_id}_group" class="input-group date">
				 <input type="text" 
				 id="${date_id}_day"
				 name="${date_name}_day"
				 class="form-control datetimepicker-input col-6" 
				 data-toggle="datetimepicker" 
				 data-target="#${date_id}_day" 
				 placeholder="<?= i18n("Day...") ?>"></input>
				 <input type="text"
				 id="${date_id}_start"
				 name="${date_name}_start"
				 class="form-control datetimepicker-input col-3"
				 data-toggle="datetimepicker"
				 data-target="#${date_id}_start"
				 placeholder="<?= i18n("Begin...") ?>"></input>
				 <input type="text"
				 id="${date_id}_end"
				 name="${date_name}_end"
				 class="form-control datetimepicker-input col-3"
				 data-toggle="datetimepicker"
				 data-target="#${date_id}_end"
				 placeholder="<?= i18n("End...") ?>"></input>
				 <div class="input-group-append">
				 <div class="input-group-text">
				 <i id="${date_id}_del" class="fa fa-times"></i>
				 </div>
				 </div>
				 </div>
				 `);
    
    $("#" + date_id + "_day").datetimepicker({
	format: 'YYYY-MM-DD'
    });
    $("#" + date_id + "_start").datetimepicker({
	format: 'HH:mm:00'
    });
    $("#" + date_id + "_start").on("change.datetimepicker", function(e) {
	$("#" + date_id + "_end").datetimepicker("minDate", e.date);
    });
    $("#" + date_id + "_end").datetimepicker({
	format: 'HH:mm:00'
    });
    $("#" + date_id + "_del").click(function() {
	$("#" + date_id + "_group").remove();
	// remove removed date from num_dates
	str_date_num = $("#entry_date_num").val().split(" ")
            .filter(d => d != date_num).join(" ");
	$("#entry_date_num").val(str_date_num);
    });
    add_date.date_num++;
}

var date_ctr = 1;
$("#entry_add_date").click(function() {
    add_date(date_ctr);
    date_ctr++;
});
	      </script>
	    </div>
	  </div>
	    <button type="submit" class="btn btn-light" name="submit">
	      <?= i18n("Ok, submit") ?>
	    </button>
	</div>
      </div>
  </form>
  </div>
</div>
