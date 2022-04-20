<?php require('includes/config.php');

$stmt = $db->prepare('SELECT articleId,articleDescrip, articleSlug ,articleTitle, articleContent, articleTags, articleDate  FROM techno_blog WHERE articleSlug = :articleSlug');
$stmt->execute(array(':articleSlug' => $_GET['id']));
$row = $stmt->fetch();


//if post does not exists redirect user.
if ($row['articleId'] == '') {
    header('Location: ./');
    exit;
}
?>

<?php include("head.php");  ?>

<title><?php echo $row['articleTitle']; ?>-Techno Smarter</title>
<meta name="description" content="<?php echo $row['articleDescrip']; ?>">
<meta name="keywords" content="<?php echo $row['articleTags'];?>">

<?php include("header.php");  ?>
<div class="container">
    <div class="content">


        <?php
        echo '<h1> Show Page </h1>';
        echo '<div>';
        echo '<h1>' . $row['articleTitle'] . '</h1>';

        echo '<p>Posted on ' . date('jS M Y H:i:s', strtotime($row['articleDate'])) . ' in ';

        $stmt2 = $db->prepare('SELECT categoryName, categorySlug   FROM techno_category, techno_cat_links WHERE techno_category.categoryId = techno_cat_links.categoryId AND techno_cat_links.articleId = :articleId');
        $stmt2->execute(array(':articleId' => $row['articleId']));

        $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $links = array();
        foreach ($catRow as $cat) {
            $links[] = "<a href='category/" . $cat['categorySlug'] . "'>" . $cat['categoryName'] . "</a>";
        }
        echo implode(", ", $links);

        echo '</p>';
      

        echo '<p>Tagged as: ';
        $links = array();
        $parts = explode(',', $row['articleTags']);
        foreach ($parts as $tags) {
            $links[] = "<a href='" . $tags . "'>" . $tags . "</a>";
        }
        echo implode(", ", $links);
        echo '</p>';

        echo '<hr>';
        echo '<p>' . $row['articleContent'] . '</p>';

        echo '</div>';
        ?>


    </div>

    <?php //sidebar content 
    
    include("sidebar.php"); 
     echo $row;?>
    
</div>
<div style="width:100%;max-width:100%;">
<div style="width: 80%; margin:0 auto; text-align:center;">
<?php 

$baseUrl="http://localhost/blog-scratch/"; 
 $slug=$row['articleSlug']; 
  $articleIdc=$row['articleId']; 

?>             

     <p style="text-align:center;"><strong>Share </strong></p>
              <ul>
                  
                <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $baseUrl.$slug; ?>"> <img src="assets/images/facebook.png" ></a>
                
                <a target="_blank" href="http://twitter.com/share?text=Visit the link &url=<?php echo $baseUrl.$slug; ?>&hashtags=blog,technosmarter,programming,tutorials,codes,examples,language,development">
 <img src="assets/images/twitter.png" ></a>
               
                <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $baseUrl.$slug; ?>"> <img src="assets/images/linkedin.png" ></a>
                
                 <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo $baseUrl.$slug; ?>">
 <img src="assets/images/pinterest.png" ></a>
              </ul>

              <h2> Recomended Posts:</h2>
<?php

// run query//select by current id and display the next 5 blog posts 

$recom= $db->query("SELECT * from techno_blog where articleId> $articleIdc order by articleId ASC limit 2");

// look through query
       while($row1 = $recom->fetch()){
         echo '<h2><a href="'.$row1['articleSlug'].'">'.$row1['articleTitle'].'</a></h2>';
}
?>

<h2> Previous Posts:</h2>
<?php

// run query//select by current id and display the previous 5 posts

$previous= $db->query("SELECT * from techno_blog where articleId< $articleIdc order by articleId DESC limit 3");

// look through query
       while($row1 = $previous->fetch()){
         echo '<h2><a href="'.$row1['articleSlug'].'">'.$row1['articleTitle'].'</a></h2>';

}


?>
</div>
</div>
<?php include("footer.php");  ?>