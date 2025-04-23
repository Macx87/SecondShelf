<?php

/**
 * SEO Functions for Second-Hand Books Website
 * This file contains functions for optimizing the website for search engines
 */

/**
 * Generate meta tags for SEO optimization
 *
 * @param string $title The page title
 * @param string $description The page description
 * @param string $keywords The page keywords
 * @param string $canonical The canonical URL
 * @param string $image The page image URL (optional)
 * @return string HTML meta tags
 */
function generate_meta_tags($title, $description, $keywords, $canonical, $image = '')
{
    $meta = "";

    // Basic meta tags
    $meta .= "<meta name=\"description\" content=\"" . htmlspecialchars($description) . "\">\n";
    $meta .= "<meta name=\"keywords\" content=\"" . htmlspecialchars($keywords) . "\">\n";

    // Canonical URL
    $meta .= "<link rel=\"canonical\" href=\"" . htmlspecialchars($canonical) . "\">\n";

    // Open Graph meta tags
    $meta .= "<meta property=\"og:title\" content=\"" . htmlspecialchars($title) . "\">\n";
    $meta .= "<meta property=\"og:description\" content=\"" . htmlspecialchars($description) . "\">\n";
    $meta .= "<meta property=\"og:url\" content=\"" . htmlspecialchars($canonical) . "\">\n";
    $meta .= "<meta property=\"og:type\" content=\"website\">\n";

    // Add image if provided
    if (!empty($image)) {
        $meta .= "<meta property=\"og:image\" content=\"" . htmlspecialchars($image) . "\">\n";
    }

    // Twitter Card meta tags
    $meta .= "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    $meta .= "<meta name=\"twitter:title\" content=\"" . htmlspecialchars($title) . "\">\n";
    $meta .= "<meta name=\"twitter:description\" content=\"" . htmlspecialchars($description) . "\">\n";

    if (!empty($image)) {
        $meta .= "<meta name=\"twitter:image\" content=\"" . htmlspecialchars($image) . "\">\n";
    }

    return $meta;
}

/**
 * Generate JSON-LD structured data for a book
 *
 * @param array $book The book data
 * @param string $url The book URL
 * @return string JSON-LD script tag
 */
function generate_book_structured_data($book, $url)
{
    $structured_data = array(
        "@context" => "https://schema.org",
        "@type" => "Product",
        "name" => $book['title'],
        "description" => $book['description'],
        "image" => !empty($book['image']) ? get_base_url() . "/uploads/" . $book['image'] : get_base_url() . "/assets/default-book.jpg",
        "url" => $url,
        "offers" => array(
            "@type" => "Offer",
            "price" => $book['price'],
            "priceCurrency" => "INR",
            "availability" => "https://schema.org/InStock",
            "seller" => array(
                "@type" => "Organization",
                "name" => "Second-Hand Books Platform"
            )
        )
    );

    if (!empty($book['author'])) {
        $structured_data["author"] = array(
            "@type" => "Person",
            "name" => $book['author']
        );
    }

    return "<script type=\"application/ld+json\">" . json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "</script>\n";
}

/**
 * Generate JSON-LD structured data for the website
 *
 * @return string JSON-LD script tag
 */
function generate_website_structured_data()
{
    $structured_data = array(
        "@context" => "https://schema.org",
        "@type" => "WebSite",
        "name" => "Second-Hand Books Platform",
        "url" => get_base_url(),
        "potentialAction" => array(
            "@type" => "SearchAction",
            "target" => get_base_url() . "/index.php?search={search_term_string}",
            "query-input" => "required name=search_term_string"
        ),
        "description" => "Find and sell second-hand books online. Connect with book lovers for affordable and sustainable reading."
    );

    return "<script type=\"application/ld+json\">" . json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "</script>\n";
}

/**
 * Get the base URL of the website
 *
 * @return string The base URL
 */
function get_base_url()
{
    // When running from command line, use a default host
    if (php_sapi_name() == 'cli') {
        return 'http://localhost/secondhand_books/';
    }

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script_name = dirname($_SERVER['SCRIPT_NAME']);

    // Remove 'index.php' from the path if it exists
    $base_path = $script_name;
    if (substr($base_path, -9) === 'index.php') {
        $base_path = dirname($base_path);
    }

    // Ensure the path ends with a slash
    if (substr($base_path, -1) !== '/') {
        $base_path .= '/';
    }

    return $protocol . '://' . $host . $base_path;
}

/**
 * Generate a sitemap.xml file
 *
 * @param object $conn Database connection
 */
function generate_sitemap($conn)
{
    $base_url = get_base_url();
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Add static pages
    $static_pages = array(
        '' => '1.0', // Homepage
        'about.php' => '0.8',
        'sell.php' => '0.7',
        'auth/login.php' => '0.6',
        'auth/signup.php' => '0.6'
    );

    foreach ($static_pages as $page => $priority) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($base_url . $page) . "</loc>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>" . $priority . "</priority>\n";
        $xml .= "  </url>\n";
    }

    // Add dynamic book pages
    $sql = "SELECT id, title FROM books";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($base_url . "book.php?id=" . $row['id']) . "</loc>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.9</priority>\n";
            $xml .= "  </url>\n";
        }
    }

    $xml .= '</urlset>';

    // Write to file
    file_put_contents(dirname(__DIR__) . '/sitemap.xml', $xml);
}

/**
 * Add hreflang tags for multilingual support
 *
 * @param string $canonical The canonical URL
 * @return string HTML hreflang tags
 */
function generate_hreflang_tags($canonical)
{
    // For future multilingual support
    $hreflang = "";
    $hreflang .= "<link rel=\"alternate\" hreflang=\"en\" href=\"" . htmlspecialchars($canonical) . "\">\n";
    return $hreflang;
}

/**
 * Generate robots meta tag
 *
 * @param bool $index Whether to index the page
 * @param bool $follow Whether to follow links on the page
 * @return string HTML robots meta tag
 */
function generate_robots_meta($index = true, $follow = true)
{
    $robots = "<meta name=\"robots\" content=\"";
    $robots .= $index ? "index" : "noindex";
    $robots .= ",";
    $robots .= $follow ? "follow" : "nofollow";
    $robots .= "\">\n";
    return $robots;
}

/**
 * Add page-specific meta tags
 *
 * @param string $page The current page
 * @param array $data Additional data for the page
 * @return string HTML meta tags
 */
function get_page_meta_tags($page, $data = array())
{
    $base_url = get_base_url();
    $canonical = $base_url . $page;

    // Default values
    $title = "Second-Hand Books Platform";
    $description = "Find and sell second-hand books online. Connect with book lovers for affordable and sustainable reading.";
    $keywords = "second-hand books, used books, buy books, sell books, affordable books";
    $image = "";
    $structured_data = "";

    // Page-specific values
    switch ($page) {
        case 'index.php':
            if (isset($_GET['search'])) {
                $search_term = htmlspecialchars($_GET['search']);
                $title = "Search results for '{$search_term}' - Second-Hand Books Platform";
                $description = "Browse second-hand books matching '{$search_term}'. Find affordable books from our collection.";
                $keywords .= ", {$search_term}, book search";
                $canonical .= "?search=" . urlencode($_GET['search']);
            } else {
                $title = "Second-Hand Books Platform - Buy & Sell Used Books Online";
            }
            $structured_data = generate_website_structured_data();
            break;

        case 'book.php':
            if (isset($data['book'])) {
                $book = $data['book'];
                $title = htmlspecialchars($book['title']) . " by " . htmlspecialchars($book['author']) . " - Second-Hand Books";
                $description = "Buy '" . htmlspecialchars($book['title']) . "' by " . htmlspecialchars($book['author']) . ". " . substr(strip_tags($book['description']), 0, 150) . "...";
                $keywords .= ", " . htmlspecialchars($book['title']) . ", " . htmlspecialchars($book['author']);
                $canonical .= "?id=" . $book['id'];

                if (!empty($book['image'])) {
                    $image = $base_url . "uploads/" . $book['image'];
                }

                $structured_data = generate_book_structured_data($book, $canonical);
            }
            break;

        case 'about.php':
            $title = "About Us - Second-Hand Books Platform";
            $description = "Learn about our second-hand book platform. Our mission is to connect book lovers and promote sustainable reading.";
            $keywords .= ", about us, book platform, sustainable reading";
            break;

        case 'sell.php':
            $title = "Sell Your Books - Second-Hand Books Platform";
            $description = "List your second-hand books for sale. Reach potential buyers and give your books a new home.";
            $keywords .= ", sell books, list books, book selling";
            break;

        case 'profile.php':
            $title = "Your Profile - Second-Hand Books Platform";
            $description = "Manage your profile and book listings on the Second-Hand Books Platform.";
            $keywords .= ", user profile, manage books, book listings";
            // Add noindex for user profiles for privacy
            $robots = generate_robots_meta(false, true);
            break;

        default:
            // Default values already set
            break;
    }

    // Generate meta tags
    $meta = generate_meta_tags($title, $description, $keywords, $canonical, $image);

    // Add robots meta if set
    if (isset($robots)) {
        $meta .= $robots;
    }

    // Add hreflang tags
    $meta .= generate_hreflang_tags($canonical);

    // Add structured data
    if (!empty($structured_data)) {
        $meta .= $structured_data;
    }

    return $meta;
}

/**
 * Add SEO-friendly URL structure
 *
 * @param string $type The type of URL
 * @param array $params Parameters for the URL
 * @return string The SEO-friendly URL
 */
function get_seo_url($type, $params = array())
{
    $base_url = get_base_url();

    switch ($type) {
        case 'book':
            if (isset($params['id']) && isset($params['title'])) {
                // Create a slug from the title
                $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9-]+/', '-', $params['title']), '-'));
                return $base_url . "book.php?id=" . $params['id'] . "&slug=" . $slug;
            }
            break;

        case 'search':
            if (isset($params['query'])) {
                return $base_url . "index.php?search=" . urlencode($params['query']);
            }
            break;

        default:
            return $base_url . $type;
    }

    return $base_url;
}

/**
 * Add page load optimization
 */
function optimize_page_load()
{
    // Output buffering for faster page load
    ob_start();

    // Set cache headers for static content
    $cache_time = 3600; // 1 hour
    header("Cache-Control: max-age={$cache_time}, public");
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + $cache_time) . " GMT");

    // Compress output
    if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
        ini_set('zlib.output_compression', 'On');
        ini_set('zlib.output_compression_level', '5');
    }
}
