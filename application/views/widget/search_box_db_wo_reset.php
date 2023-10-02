<?php 
	$q=$this->input->get_post("q",TRUE);
	$q=$q?$q:"";
?>

           <div class='input-append'>
           <input class="input" id="q" name="q"  type="text" value="<?=$q?>" placeholder="Search..." /> <button type="submit" class='add-on btn'><i class="icon-search"></i>&nbsp;</button>
           </div>
                        