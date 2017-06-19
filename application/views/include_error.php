<?php

if(!empty($errors)){
	foreach($errors as $error){
		echo '<div class="has-error">';
		echo '<label class="control-label"><i class="fa fa-times-circle-o"> '.$error.' </i></label>';
		echo "</div>";
	}
}

echo validation_errors('<div class="has-error"><label class="control-label"><i class="fa fa-times-circle-o"> ', ' </i></label></div>');

if(!empty($success_message)){
	foreach($success_message as $success){
                echo '<div class="has-error">';
                echo '<label class="control-label"><i class="fa fa-check"> '.$success.' </i></label>';
                echo "</div>";
        }

}
?>
