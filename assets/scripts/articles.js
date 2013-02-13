	function pageselectCallbackAssigned(page_index, jq){
        // Get number of elements per pagionation page from form
        var items_per_page_assigned = $('#items_per_page').val();

        var max_elem = Math.min(items_per_page_assigned, (members_assigned -(items_per_page_assigned*(page_index))));

        $.ajax({
			url: site_url+'admin/ajax_assigned',
			type:'POST',
			data:{
					start:page_index*items_per_page_assigned,
					limit: max_elem,
					action: 'category'
				},
			success: function(data){
					$('#assined_table').html(data);
				}
		});
        // Prevent click event propagation
        return false;
    }
	
	function pageselectCallbackClaimed(page_index, jq){
        // Get number of elements per pagionation page from form
        var items_per_page_claimed = $('#items_per_page').val();

        var max_elem = Math.min(items_per_page_claimed, (members_claimed -(items_per_page_claimed*(page_index))));

        $.ajax({
			url: site_url+'admin/ajax_claimed',
			type:'POST',
			data:{
					start:page_index*items_per_page_claimed,
					limit: max_elem,
					action: 'claimed'
				},
			success: function(data){
					$('#claimed_table').html(data);
				}
		});
        // Prevent click event propagation
        return false;
    }
	
	function pageselectCallbackAvailable(page_index, jq){
        // Get number of elements per pagionation page from form
        var items_per_page_available = $('#items_per_page').val();

        var max_elem = Math.min(items_per_page_available, (members_available -(items_per_page_available*(page_index))));

        $.ajax({
			url: site_url+'admin/ajax_available',
			type:'POST',
			data:{
					start:page_index*items_per_page_available,
					limit: max_elem,
					action: 'category'
				},
			success: function(data){
					$('#available_table').html(data);
				}
		});
        // Prevent click event propagation
        return false;
    }

	function getPageForAssignedArticles(){
        var opt4 = {callback: pageselectCallbackAssigned};
        // Collect options from the text fields - the fields are named like their option counterparts
        $("#items_per_page").each(function(){
            opt4[this.name] = this.className.match(/numeric/) ? parseInt(this.value) : this.value;
        });
        return opt4;
    }
	
	function getPageForClaimedArticles(){
        var opt4 = {callback: pageselectCallbackClaimed};
        // Collect options from the text fields - the fields are named like their option counterparts
        $("#items_per_page").each(function(){
            opt4[this.name] = this.className.match(/numeric/) ? parseInt(this.value) : this.value;
        });
        return opt4;
    }
	
	function getPageForAvailableArticles(){
        var opt4 = {callback: pageselectCallbackAvailable};
        // Collect options from the text fields - the fields are named like their option counterparts
        $("#items_per_page").each(function(){
            opt4[this.name] = this.className.match(/numeric/) ? parseInt(this.value) : this.value;
        });
        return opt4;
    }
	
	 $(document).ready(function(){

		 $('#wait').css('display','block');
		 //Pagination for Assigned Articles
		 var optInit = getPageForAssignedArticles();
		 $("#Pagination_assigned").pagination(members_assigned, optInit); 

		 //Pagination for Claimed Articles
		 var optInit2 = getPageForClaimedArticles();
		 $("#Pagination_claimed").pagination(members_claimed, optInit2); 
		 
		 //Pagination for Available Articles
		 var optInit3 = getPageForAvailableArticles();
		 $("#Pagination_available").pagination(members_available, optInit3); 
		 
     });	