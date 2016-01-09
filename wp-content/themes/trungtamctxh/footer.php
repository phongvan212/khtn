		<footer id="footer">
                <div class="copyright container">
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <address>
							  <strong>© <?php echo date('Y'); ?> <?php bloginfo( 'sitename' ); ?></strong><br>
							  Địa chỉ: Số 06 Trần Văn Ơn, phường Phú Hòa, tp Thủ Dầu Một, Bình Dương<br>							  
							  <abbr title="Phone">Điện thoại:</abbr> (0650) 3.844.028<br>
							  <abbr title="Website">Website:</abbr> <a href="http://khtn.tdmu.edu.vn" alt="khtn.tdmu.edu.vn">khtn.tdmu.edu.vn</a>
						</address>
                    </div>
                </div>
        </footer>
</div> <!--end #container -->
 <?php wp_footer(); ?>

<script type="text/javascript">
	$(document).ready(function () {
		   var docHeight = $(window).height();
		   var footerHeight = $('#footer').height();
		   var footerTop = $('#footer').position().top + footerHeight;

		   if (footerTop < docHeight) {
		    $('#footer').css('margin-top',  (docHeight - footerTop) + 'px');
		   }

		   $(".rpwe_widget").addClass("panel panel-primary");
		   $(".rpwe_widget>.widgettitle").addClass("panel-heading");
		   $(".rpwe_widget>.rpwe-block ").addClass("panel-body");
		   $(".widget_text").addClass("btn btn-success btn-block");
		   $(".widget_text:first").removeClass("btn-success").addClass("btn-primary");
		   $(".widget_text:last").removeClass("btn-info").addClass("btn-info");
		   $(".widget_text>h3>a").append("<spand class='badge pull-right'><i class='fa fa-long-arrow-right'></i></spand>");
		   $(".breadcrumbs").addClass("breadcrumb");
		   $("input").addClass("form-control");
		   $("textarea").addClass("form-control");
		   $(".wpcf7-submit").addClass("btn btn-primary");
		   $(".widget_calendar>.widgettitle").addClass("alert alert-title");
		   $(".widget_calendar>.widgettitle").after("<hr/>");
		   $("#visits_counter_widget>.widgettitle").addClass("alert alert-title");
		   $("#visits_counter_widget>.widgettitle").after("<hr/>")
		   $("img").addClass("img-responsive");
		   $("table").addClass("table");
		   $("#s").attr("placeholder", "Tìm kiếm");
		   $("#s").addClass("must-wrap");
		   $("#searchsubmit").replaceWith("<spand class='input-group-btn must-wrap'><button id='searchsubmit' type='submit' class='btn btn-primary'><i class='fa fa-search'></i></button></spand>");
		   $(".must-wrap").wrapAll("<div class='input-group'></div>");
		   $(".screen-reader-text").replaceWith("");
		   if ($("#myFrame").length > 0)
            {
                var resInterval = setInterval(function () {
                    if ($("#myFrame").contents().find("#pdfHeight").val() != "") {
                        var hgt = 0;
                        hgt = $("#myFrame").contents().find("#pdfHeight").val() * 1;
                        $("#myFrame").css({ "height": hgt + "px" }).fadeTo('10');
                    }
                }, 75);
            }
		  });
		function resizeIframe(obj)
        {
            obj.style.height = 1200 + "px";
        }
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71852651-1', 'auto');
  ga('send', 'pageview');

</script>

</body> <!--end body-->
</html> <!--end html -->