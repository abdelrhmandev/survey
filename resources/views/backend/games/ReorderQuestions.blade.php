<div class="footer clearfix">
			<div class="footer-inner">
				2018 &copy;  


 	 

 
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
		<!-- end: FOOTER -->
 

		
		
				<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="{{ asset('assets/plugins/respond.min.js') }}"></script>
		<script src="{{ asset('backend/assets/plugins/excanvas.min.js') }}"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

	 



		<!--<![endif]-->
		<script src="{{ asset('backend/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js') }}"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
		<script src="{{ asset('backend/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('backend/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}"></script>
		<script src="{{ asset('backend/assets/plugins/blockUI/jquery.blockUI.js') }}"></script>
		<script src="{{ asset('backend/assets/plugins/iCheck/jquery.icheck.min.js') }}"></script>
		<script src="{{ asset('backend/assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js') }}"></script>
		
		
	 

		<script src="{{ asset('backend/assets/plugins/less/less-1.5.0.min.js') }}"></script>

		<script src="{{ asset('backend/assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
		<script src="{{ asset('backend/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js') }}"></script>
		<script src="{{ asset('backend/assets/plugins/switchery/switchery.min.js') }}"></script>		
		<script src="{{ asset('backend/assets/js/main.js') }}"></script>		

	 
		<!-- end: MAIN JAVASCRIPTS -->

		
		
				<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->	


		<script src="{{ asset('backend/dist/js/bootstrap-iconpicker-iconset-all.min.js') }}"></script>
		<script src="{{ asset('backend/dist/js/bootstrap-iconpicker.min.js') }}"></script>



	  
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		
		
		 

		
		
		
 

 


		
		  


 
		
		
		
		<script>
			jQuery(document).ready(function() {
				Main.init();
 			    FormElements.init();
			});

		$("#selectall").click(function(){
		$(".individual").prop("checked",$(this).prop("checked"));
		});


			
		</script>

    <script type="text/javascript">

    $(document).ready(function () { // confirm delete 

        $('[data-toggle=confirmation]').confirmation({

            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }

        });
        $(document).on('confirm', function (e) {
            var ele = e.target;
            location.href = ele;	       

        });

    });
</script>
 <script type="text/javascript">

$(document).ready(function() {
$(".add-more").click(function(){ 
var html = $(".copy").html();
$(".after-add-more").after(html);
});
$("body").on("click",".remove",function(){ 

$(this).parents(".control-group").remove();

});
});
</script>




<script>
	/////////////////// validate minimum image width and height  
$(document).ready(function(){
    $("#image_id").change(function(){
     
     

    /*
    var fileUpload = document.getElementById("image_id");
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {

                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;


                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    // alert(width);
                    // alert(height);
                    if (width < 1400 || height < 400) {
                       $("#image_width_height_validation").removeClass('hidden');
                        return false;
                    }else{
	                    $("#image_width_height_validation").addClass('hidden');	
                    }
               
                };
 
            }
        }
    }*/



    /*
    var fileUpload = document.getElementById("input");
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {

                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;


                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    alert(width);
                    alert(height);
                    if (width < 1400 || height < 400) {
                       $("#image_width_height_validation").removeClass('hidden');
                        return false;
                    }else{
	                    $("#image_width_height_validation").addClass('hidden');	
                    }
               
                };
 
            }
        }
    }
    */
 



    });
});
</script>

  <!-- this script use to re order records -->

 
   <script type="text/javascript">
  $(function () {  
    $("#tablecontents" ).sortable({
      items: "tr",
      cursor: 'move',
      opacity: 0.6,
      update: function() {
          sendReorderLisingsToServer();
      }
    });

    function sendReorderLisingsToServer() {

      var order = [];
      $('tr.row1').each(function(index,element) {
        order.push({
          id: $(this).attr('data-id'),                   
          position: index + 1
        });
      });

      $.ajax({
        type: "POST", 
        dataType: "json", 
        url: "{!! route('admin.ReorderLisings') !!}",
	     data: {
	         order:order,
	         table_name: 'game_question', 
	         _token: '{{csrf_token()}}'
	        }, 
      });
	 $("#reorder").removeClass('hidden');
    }
  });

</script>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////// -->





	</body>
	<!-- end: BODY -->

</html>