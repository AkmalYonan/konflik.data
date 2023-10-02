<?php echo $this->load->view("test/header");?>
<div id="maincontainer" class="clearfix">
<?php echo $this->load->view("test/menu");?>
<div id="contentwrapper">
<div class="main_content">
	<div class="row-fluid">
    <div class="span12">
    <?php echo isset($content)?$content:"Test Kacang";?>
    </div></div><!-- /end fluid -->
</div>
</div><!-- /content wrapper-->
<a class="sidebar_switch ttip_r on_switch" href="javascript:void(0)" oldtitle="Hide Sidebar" aria-describedby="ui-tooltip-2">Sidebar switch</a>
<div class="sidebar">
	<?php echo isset($sidebar)?$sidebar:$this->load->view("test/sidebar");?>
</div>
</div><!-- end container-->
<script src="assets/app/admin/js/jquery.debouncedresize.min.js"></script>
<script src="assets/app/admin/js/jquery.cookie.min.js"></script>
<script src="assets/app/admin/js/antiscroll/antiscroll.js"></script>
<script>
	gebo_sidebar = {
        init: function() {
			// sidebar onload state
			if($(window).width() > 979){
                if(!$('body').hasClass('sidebar_hidden')) {
                    if( $.cookie('gebo_sidebar') == "hidden") {
                        $('body').addClass('sidebar_hidden');
                        $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title','Show Sidebar');
                    }
                } else {
                    $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title','Show Sidebar');
                }
            } else {
                $('body').addClass('sidebar_hidden');
                $('.sidebar_switch').removeClass('on_switch').addClass('off_switch');
            }

			//gebo_sidebar.info_box();
			//* sidebar visibility switch
            $('.sidebar_switch').click(function(){
                $('.sidebar_switch').removeClass('on_switch off_switch');
                if( $('body').hasClass('sidebar_hidden') ) {
                    $.cookie('gebo_sidebar', null);
                    $('body').removeClass('sidebar_hidden');
                    $('.sidebar_switch').addClass('on_switch').show();
                    $('.sidebar_switch').attr( 'title', "Hide Sidebar" );
                } else {
                    $.cookie('gebo_sidebar', 'hidden');
                    $('body').addClass('sidebar_hidden');
                    $('.sidebar_switch').addClass('off_switch');
                    $('.sidebar_switch').attr( 'title', "Show Sidebar" );
                }
				//gebo_sidebar.info_box();
				gebo_sidebar.update_scroll();
				$(window).resize();
            });
			//* prevent accordion link click
            $('.sidebar .accordion-toggle').click(function(e){e.preventDefault()});
        },
		info_box: function(){
			var s_box = $('.sidebar_info');
			var s_box_height = s_box.actual('height');
			s_box.css({
				'height'        : s_box_height
			});
			$('.push').height(s_box_height);
			$('.sidebar_inner').css({
				'margin-bottom' : '-'+s_box_height+'px',
				'min-height'    : '100%'
			});
        },
		make_active: function() {
			var thisAccordion = $('#side_accordion');
			thisAccordion.find('.accordion-heading').removeClass('sdb_h_active');
			var thisHeading = thisAccordion.find('.accordion-body.in').prev('.accordion-heading');
			if(thisHeading.length) {
				thisHeading.addClass('sdb_h_active');
			}
		},
        make_scroll: function() {
            antiScroll = $('.antiScroll').antiscroll().data('antiscroll');
        },
        update_scroll: function() {
			if($('.antiScroll').length) {
				if( $(window).width() > 979 ){
					$('.antiscroll-inner,.antiscroll-content').height($(window).height() - 40);
				} else {
					$('.antiscroll-inner,.antiscroll-content').height('400px');
				}
				antiScroll.refresh();
			}
        }
    };
	
	$(function(){
		var lastWindowHeight = $(window).height();
		var lastWindowWidth = $(window).width();
		$(window).on("debouncedresize",function() {
			if($(window).height()!=lastWindowHeight || $(window).width()!=lastWindowWidth){
				lastWindowHeight = $(window).height();
				lastWindowWidth = $(window).width();
				gebo_sidebar.update_scroll();
				/*if(!is_touch_device()){
                    $('.sidebar_switch').qtip('hide');
                }*/
			}
		});
		
		gebo_sidebar.init();
		gebo_sidebar.make_active();
		gebo_sidebar.make_scroll();
		gebo_sidebar.update_scroll();
	});
</script>
<?php echo $this->load->view("test/footer");?>

