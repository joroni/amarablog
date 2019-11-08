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

    

<section id="blog" class="clearfix ng-scope">
<?php
   $type = 'post';
   $paged = (get_query_var('paged')) ? absint( get_query_var('paged') ) : 1;
   $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => 10, // To display the number of post per page 
        'paged' => $paged,
   );
    $query = new WP_Query( $args );

    if (have_posts()) :
?>
      <div class="container">

       <!--  <header class="section-header">
          <h3 class="section-title">Our blog</h3>
        </header> -->



        <div class="row">
          <div class="col-lg-12">
            <!-- <ul id="blog-flters" > -->
              <?php $categories =  get_categories();
echo '<ul id="blog-flters">';
?>  <li data-filter="*" class="filter-active">All</li><?php
foreach  ($categories as $category) {
  echo '<li data-filter=.filter-'. strtolower($category->cat_name).'>'. $category->cat_name .'</li>';
}
echo '</ul>'; ?>
            
              <!-- <button ng-repeat="c in myCategories" data-filter=".filter-{{c.id}}">{{c.name}}</button> -->
           
             <!-- <button ng-repeat="c in myCategories" id="{{c.id}}"  ng-click="filterByCat({{c.name | lowercase}})">{{c.name}}</button> -->

            <!--  <li ng-repeat="c in myCategories" id="{{c.id}}"  data-filter=".filter-{{c.id}}" ng-click="filterByCat({{c.name | lowercase}})">{{c.name}}</li> 
            <li ng-repeat="c in myCategories" id="{{c.id}}"  data-filter=".filter-{{c.id}}">{{c.name}}</li>-->
            
            <!-- </ul> -->
          </div>
        </div>
        
        <div class="row blog-container" >
           
        <?php
        // Start the loop.
        while ( $query->have_posts() ) : $query->the_post();
    ?>
          <div class="col-lg-4 col-md-6 blog-item  filter-<?php $cat = get_the_category(); $category=$cat[0]->cat_name; echo strtolower($category);  ?>" >
              
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
              <?/*php the_permalink(); // Link of the post */?>

<?php the_title( sprintf( '<h4 class="shadowtexts truncate blog-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>

               
                <div class="blog-details">
                <p class="shadowtexts block-with-text">

                <?php the_category(', '); ?> | 
<span class="entry-date"><?php echo get_the_date(); ?></span>


                </p>
                </div>
               <!--  <div>
                  <a href="casaamara/photos/14.jpg" class="link-preview" data-lightbox="blog" data-title="Web 3" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div> -->

              </div>
            </div>
          </div>
                      
          <?php
// End the loop.
endwhile;
?>

<?php endif; ?>
         



      </div>
      


    </section><!-- #blog -->
    



    <?/*php 
        $terms = get_terms( 'category', array(
        'hide_empty' => false,
        'order_by' => 'name',
        'order' => 'ASC',
        'number' => 100,
        'taxonomy' => 'category'
    ) );

         //print_r($terms);

         foreach($terms as  $termss)
        {
        //echo "<br/>";
         //echo $termss->term_id;
            //echo "<br/>";
            ?>
        <h1> <?php echo $termss->name; ?></h1>
         <?php 
            //echo "<br/>";
          //echo $termss->slug;


           $query =  query_posts("category_name='$termss->name'&showposts=5");
        //print_r($query);
        foreach($query as  $querys)
        {
        //$querys->ID;
        ?>
        <h3><?php echo $querys->post_title; ?></h3>

        <p><?php echo $querys->post_content; ?></p>

    <?php   //echo "<br/>";
        }
      }
*/?>

           
           

<?php
get_footer();