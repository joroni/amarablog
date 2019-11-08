<?php /* Template Name: My-Home */ ?>


<?php
//Identify current Post-Category-ID ermitteln
foreach((get_the_category()) as $category)
    {
    $postcat= $category->cat_ID;
    $catname =$category->cat_name;
    }
?>
<h2><?php echo $catname; ?></h2>
<?php $categories = get_categories("child_of=$postcat");
    foreach ($categories as $cat)
    { ?>
    <?php query_posts("cat=$cat->cat_ID&posts_per_page=-1"); ?>
    <h3><?php single_cat_title(); ?></h3>
    <?php while (have_posts()) : the_post(); ?>
    <ul>
        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
            <?php the_title(); ?></a>
        </li>
    </ul>
    <?php endwhile; ?>
    <?php } ?>
