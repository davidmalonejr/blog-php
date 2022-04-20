<div class="sidebar">
    <h2>Recent Articles</h2>
    <?php
    $sidebar = $db->query('SELECT articleTitle, articleSlug FROM techno_blog ORDER BY articleId DESC LIMIT 6');
    while ($rowData = $sidebar->fetch()) {
        echo ' <a href="http://localhost/blog-scratch/' . $rowData['articleSlug'] . '" >' . $rowData['articleTitle'] . ' </a >';
    }
    ?>

    <h2>Categories</h2>

    <?php
    $stmt = $db->query('SELECT categoryName, categorySlug FROM techno_category ORDER BY categoryId DESC');
    while ($rowData = $stmt->fetch()) {
        echo '<a href="http://localhost/blog-scratch/category/' . $rowData['categorySlug'] . '">' . $rowData['categoryName'] . '</a>';
    }
    ?>


    <h2>Tags </h2>
    <?php
    $tagsArray = [];
    $stmt = $db->query('select distinct LOWER(articleTags) as articleTags from techno_blog where articleTags != "" group by articleTags');
    while ($rowData = $stmt->fetch()) {
        $parts = explode(',', $rowData['articleTags']);
        foreach ($parts as $tag) {
            $tagsArray[] = $tag;
        }
    }

    $finalTags = array_unique($tagsArray);
    foreach ($finalTags as $tag) {
        echo "<a href='http://localhost/blog-scratch/tag/" . $tag . "'>" . ucwords($tag) . "</a>";
    }

    ?>



</div>