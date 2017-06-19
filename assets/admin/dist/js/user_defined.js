
$(document).ready(function(){
		$(".delete_category").click(function(){
        		var call_url = $(this).val();
			var this_context = $(this);
			swal({
				title: "Are you sure?",
				text: "Your may not be able to recover!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
					context : this_context,
					method : "POST",
					url : call_url,
					success : function(response){
						if(response=="success"){
							swal("Deleted!", "Record deleted successfully.", "success");
							$(this).closest('.delete_row').hide();
						}else{
							swal("Error!", response, "error");
						}
					}
      				});

			});
    		});

		$(".dropzone").sortable({
                    items:'.dz-preview',
                    cursor: 'move',
                    opacity: 0.5,
                    containment: '.dropzone',
                    distance: 20,
                    tolerance: 'pointer'
                });
	});
