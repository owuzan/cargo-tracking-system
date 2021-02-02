(function ($) {
	"use strict";

  var init = function(){
    $('#datatable').DataTable({
    	columnDefs: [
	       { "orderable": false, "targets": [3,4,5] }
	    ]
    });
  }

  // for ajax to init again
  $.fn.dataTable.init = init;

})(jQuery);
