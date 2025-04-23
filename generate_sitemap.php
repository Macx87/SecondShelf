<?php
/**
 * Sitemap Generator Script
 * This script generates a sitemap.xml file for the website
 */

// Include database connection
include "config/db_connect.php";

// Include SEO functions
include "includes/seo_functions.php";

// Generate sitemap
generate_sitemap($conn);

echo "Sitemap generated successfully!";
?>