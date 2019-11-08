<?php
/*
 Template Name: Home
 */


/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */


get_header();

//require(dirname(__FILE__)."\data.php");
?>



<section id="blog" class="clearfix">

<?php
   $type = 'post';
   $paged = (get_query_var('paged')) ? absint( get_query_var('paged') ) : 1;
   $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => 3, // To display the number of post per page 
        'paged' => $paged,
   );
    $query = new WP_Query( $args );

    if (have_posts()) :
?>
      <div class="container">

       <!--  <header class="section-header">
          <h3 class="section-title">Our blog</h3>
        </header> -->


        <?php
        // Start the loop.
        while ( $query->have_posts() ) : $query->the_post();
    ?>

        <div class="row">
          <div class="col-lg-12">
            <ul id="blog-flters" >
              <li data-filter="*" class="filter-active">All</li>
              <!-- <button ng-repeat="c in myCategories" data-filter=".filter-{{c.id}}">{{c.name}}</button> -->
           
             <!-- <button ng-repeat="c in myCategories" id="{{c.id}}"  ng-click="filterByCat({{c.name | lowercase}})">{{c.name}}</button> -->

            <!--  <li ng-repeat="c in myCategories" id="{{c.id}}"  data-filter=".filter-{{c.id}}" ng-click="filterByCat({{c.name | lowercase}})">{{c.name}}</li> 
            <li ng-repeat="c in myCategories" id="{{c.id}}"  data-filter=".filter-{{c.id}}">{{c.name}}</li>-->
            
            </ul>
          </div>
        </div>
        
        <div class="row blog-container" >
           
          <div class="col-lg-4 col-md-6 blog-item"  category="">
            <div class="blog-wrap">
            <?php
                if ( has_post_thumbnail() ) {
                    //the_post_thumbnail();
                        the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ), 'class'  => "img-fluid" ) );

                        /* You can try other resolution also

                            the_post_thumbnail();                  // without parameter => Thumbnail
                            the_post_thumbnail('thumbnail');       // Thumbnail
                            the_post_thumbnail('medium');          // Medium resolution
                            the_post_thumbnail('large');           // Large resolution
                            the_post_thumbnail( array(100,100) );  // Other resolutions 100px X 100px 
                        */

                }
            ?>
             <!--  <img ng-src="{{p.better_featured_image.media_details.sizes.medium_large.source_url}}"  onerror="this.src='img/thumbnail-default_2.jpg'" class="img-fluid" alt="{{p.better_featured_image.alt_text}}"> -->
              <div class="blog-info">
              <?php the_permalink(); // Link of the post ?>

<?php the_title( sprintf( '<h4 class="shadowtext blog-title"><a href="%s">', esc_url( the_excerpt() ) ), '</a></h4>' ); ?>

                <div class="blog-details">
                <p class="shadowtext block-with-text">
<?php echo the_excerpt(); ?></p>
                </div>
               <!--  <div>
                  <a href="casaamara/photos/14.jpg" class="link-preview" data-lightbox="blog" data-title="Web 3" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div> -->
              </div>
            </div>
          </div>

         



      </div>
      
      
<?php
// End the loop.
endwhile;
?>

<?php endif; ?>

    </section><!-- #blog -->
    



           
           

<?php
//get_footer();

