<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage GenderHub
 * @since GenderHub 1.0
 */
$funded_by = method_exists('GH_Site_Settings', 'gh_funded_by') ? GH_Site_Settings::gh_funded_by() : NULL;
$delivered_by = method_exists('GH_Site_Settings', 'gh_delivered_by') ? GH_Site_Settings::gh_delivered_by() : NULL;
$social_media_links = method_exists('GH_Site_Settings', 'gh_social_media_links') ? '<h5>Connect</h5>'.GH_Site_Settings::gh_social_media_links() : NULL;

?>
<?php if(!is_front_page()) : ?>

    </div>

    </div>

    </section>
<?php endif; ?>
<footer>

    <div class="paddingleftright inner outer">

        <div class="col4">
            <?php echo $funded_by; ?>
        </div>

        <div class="col4">
            <?php echo $delivered_by; ?>
        </div>

        <div class="col4 more">
            <h5>More...</h5>
            <?php wp_nav_menu( array('menu' => 'Footer More Menu') ); ?>
        </div>

        <div class="col4 more">
            <h5>More...</h5>
            <?php wp_nav_menu( array('menu' => 'Main Sections Menu', 'depth' => 1) ); ?>
        </div>

        <div class="col4">
            <?php echo $social_media_links; ?>
        </div>

    </div>

</footer>

<?php

if(is_front_page()) { ?>

    <script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery("#slider li.active").fadeIn();
            jQuery("#lightSlider").lightSlider({
                gallery:true,
                item:1,
                //vertical:true,
                //verticalHeight:500,
                //vThumbWidth:200,
                thumbItem:6,
                thumbMargin:4,
                thumbWidth:100,
                slideMargin:0
            });
            jQuery("#slider li.lslide").fadeIn();

        });

    </script>

<?php } ?>

<script type="text/javascript">
jQuery( "nav li a" ).not( "nav li li a" ).each(function( index ) {
    jQuery( this ).attr('href','#');
});

jQuery('#searchicon').click(function(){
    jQuery('header.site [id=searchform]').toggleClass('active');
});

jQuery('.menuicon').click(function(){
    jQuery('nav').toggleClass('active');
    jQuery('nav').toggleClass('mobnav');
});

jQuery( "nav li a" ).not( "nav li li a" ).click(function( event ) {
    event.preventDefault();
});


jQuery( "#arealinks .col4" ).click(function(){
	jQuery(this).toggleClass('active');
});

jQuery( "nav.mobnav li" ).click(function(){
	jQuery(this).toggleClass('active');
});

jQuery( "header" ).hover(function(){
    jQuery( "nav li" ).removeClass('active');
});

jQuery( "nav li" ).not( "nav li li, nav.mobnav li" ).hover(function(){
    jQuery(this).addClass('active');
}, function(){
    
    jQuery(this).removeClass('active');
});

jQuery( "nav" ).not( "nav.mobnav" ).hover(function(){
    jQuery('nav').toggleClass('active');
}, function(){
    
    jQuery('nav').toggleClass('active');
});
</script>
<script type="text/javascript">

    jQuery( "form.searchandfilter li.sf-level-0").children('ul').before('<div class="expand-arrow"></div>');

    var listparent = document.getElementsByClassName("expand-arrow");
    var i;

    for (i = 0; i < listparent.length; i++) {
        listparent[i].onclick = function() {
            jQuery(this).parent().toggleClass("active");

        }
    }
</script>
<script type="text/javascript">
    function $_GET(param) {
        var vars = {};
        window.location.href.replace( location.hash, '' ).replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function( m, key, value ) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );

        if ( param ) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }

    var searchphrase = $_GET('s').replace(/\+/g, ' ');
    jQuery('.sf-field-search .sf-input-text').val(searchphrase);
</script>

<?php
wp_footer();?>
</body>
</html>