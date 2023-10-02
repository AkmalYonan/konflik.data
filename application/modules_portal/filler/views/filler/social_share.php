<? $url = 'http://'.$_SERVER['HTTP_HOST'];  $uri=$_SERVER['REQUEST_URI'];  ?>
<? $style = ($page_title)?'padding:20px 0 10px':'padding:3px 0 0;' ?>
<style>
.rrssb-icon i {
	font-size:18px; color:#fff; line-height:30px
}
</style>
	<!--<div class="share-container clearfix" style="background:transparent; border-bottom:1px solid #ccc; </?=$style?> ">-->
	<div class="share-container clearfix" style="background:transparent; <?=$style?> ">
        <span class="label" style="color:#999">SHARE</span>
        <ul class="rrssb-buttons clearfix" style="width:200px; height:41px;">
            <li class="rrssb-facebook">
                <!-- Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
                https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$url.$uri?>" class="popup">
                    <span class="rrssb-icon">
                        <i class="fa fa-facebook"></i>
                    </span>
                    <span class="rrssb-text">facebook</span>
                </a>
            </li>
            <li class="rrssb-twitter">
                <!-- Replace href with your Meta and URL information  -->
                <a href="http://twitter.com/home?status=<?=rawurlencode($data_title)?>%20@brwa%20<?=$url.$uri?>" class="popup">
                    <span class="rrssb-icon">
                        <i class="fa fa-twitter"></i>
                   </span>
                    <span class="rrssb-text">twitter</span>
                </a>
            </li>
            <li class="rrssb-googleplus">
                <!-- Replace href with your meta and URL information.  -->
                <a href="https://plus.google.com/share?url=<?=rawurlencode($data_title)?>%20@brwa%20<?=$url.$uri?>" class="popup">
                    <span class="rrssb-icon">
                        <i class="fa fa-google-plus"></i>
                    </span>
                    <span class="rrssb-text">google+</span>
                </a>
            </li>
            <li class="rrssb-email">
                <!-- Replace subject with your message using URL Endocding: http://meyerweb.com/eric/tools/dencoder/ -->
                <a href="mailto:?subject=<?=rawurlencode($data_title)?>%20@brwa%20and%20&amp;body=<?=rawurlencode($url.$uri)?>">
                    <span class="rrssb-icon">
                        <i class="fa fa-at"></i>
                    </span>
                    <span class="rrssb-text">email</span>
                </a>
            </li>
        </ul>
        <!-- Buttons end here -->
    </div>