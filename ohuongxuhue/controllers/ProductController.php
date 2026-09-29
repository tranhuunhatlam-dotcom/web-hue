<?php
/**
 * Controller Quản lý sản phẩm (ProductController)
 * Xử lý hiển thị trang chi tiết sản phẩm, tìm kiếm AJAX thông minh và đánh giá phản hồi
 */

class ProductController extends BaseController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    /**
     * Trang chi tiết sản phẩm đặc sản kèm Đánh giá & Phản hồi thực tế
     */
    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;

        // Lấy thông tin sản phẩm theo ID kèm số lượng tồn kho
        $product = $this->productModel->findProductByIdWithStock($id);

        // Lấy danh sách sản phẩm tương tự
        $relatedProducts = $this->productModel->getRelatedProducts($id, 4);

        // Lấy danh sách đánh giá & thống kê sao từ ReviewModel
        require_once __DIR__ . '/../models/ReviewModel.php';
        $reviewModel = new ReviewModel();
        $reviews     = $reviewModel->getReviewsByProductId($id);
        $ratingStats = $reviewModel->getProductRatingStats($id);

        // Render ra view product/detail
        $this->render('product/detail', [
            'pageTitle'       => $product['name'] . ' - O Hương Xứ Huế',
            'currentNav'      => 'product',
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
            'reviews'         => $reviews,
            'ratingStats'     => $ratingStats
        ]);
    }

    /**
     * API Tìm kiếm thông minh tức thì (Live AJAX Search)
     */
    public function ajax_search() {
        header('Content-Type: application/json; charset=utf-8');

        $query = sanitize_text_field($_GET['q'] ?? '');
        $cat   = sanitize_text_field($_GET['cat'] ?? '');

        if (mb_strlen($query, 'UTF-8') < 1 && empty($cat)) {
            echo json_encode(['success' => true, 'products' => []]);
            exit;
        }

        $allProducts = $this->productModel->getAllProductsWithStock();
        $results = [];

        $qLower = mb_strtolower($query, 'UTF-8');
        $qPlain = $this->stripAccents($query);
        $catLower = mb_strtolower($cat, 'UTF-8');

        foreach ($allProducts as $p) {
            $nameLower = mb_strtolower($p['name'] ?? '', 'UTF-8');
            $descLower = mb_strtolower($p['description'] ?? '', 'UTF-8');
            $cNameLower = mb_strtolower($p['category'] ?? '', 'UTF-8');

            $namePlain = $this->stripAccents($p['name'] ?? '');
            $descPlain = $this->stripAccents($p['description'] ?? '');

            $matchKeyword = empty($query) || (
                mb_strpos($nameLower, $qLower) !== false || 
                mb_strpos($descLower, $qLower) !== false ||
                mb_strpos($namePlain, $qPlain) !== false ||
                mb_strpos($descPlain, $qPlain) !== false
            );
            $matchCategory = empty($cat) || (mb_strpos($cNameLower, $catLower) !== false || mb_strpos($nameLower, $catLower) !== false);

            if ($matchKeyword && $matchCategory) {
                $detailUrl = function_exists('home_url') ? home_url('/?controller=product&action=detail&id=' . $p['id']) : 'index.php?controller=product&action=detail&id=' . $p['id'];
                $results[] = [
                    'id'       => $p['id'],
                    'name'     => $p['name'],
                    'price'    => $p['price'],
                    'image'    => $p['image'],
                    'category' => $p['category'] ?? 'Đặc sản Cố Đô',
                    'stock'    => $p['stock'] ?? 100,
                    'link'     => $detailUrl
                ];
            }
        }

        // Giới hạn 6 kết quả gợi ý nhanh
        $topResults = array_slice($results, 0, 6);

        echo json_encode([
            'success'  => true,
            'count'    => count($results),
            'products' => $topResults
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Tiếp nhận gửi đánh giá & ảnh thực tế từ khách hàng
     */
    public function submit_review() {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            exit;
        }

        $productId = intval($_POST['product_id'] ?? 0);
        $userName  = sanitize_text_field($_POST['user_name'] ?? '');
        $userPhone = sanitize_text_field($_POST['user_phone'] ?? '');
        $rating    = intval($_POST['rating'] ?? 5);
        $comment   = sanitize_text_field($_POST['comment'] ?? '');
        $photoUrl  = sanitize_text_field($_POST['photo_url'] ?? '');

        if ($productId <= 0 || empty($userName) || empty($comment)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ họ tên và nội dung cảm nhận!']);
            exit;
        }

        require_once __DIR__ . '/../models/ReviewModel.php';
        $reviewModel = new ReviewModel();
        $ok = $reviewModel->addReview($productId, $userName, $userPhone, $rating, $comment, $photoUrl);

        if ($ok) {
            echo json_encode([
                'success' => true,
                'message' => 'Cảm ơn bạn đã gửi đánh giá! Phản hồi của bạn đã được hiển thị công khai.'
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi lưu đánh giá, vui lòng thử lại!']);
        }
        exit;
    }

    /**
     * Trang toàn bộ danh mục Đặc Sản Huế kèm Bộ lọc đa tiêu chí
     */
    public function all() {
        $allProducts = $this->productModel->getAllProductsWithStock();
        $catFilter   = isset($_GET['cat']) ? sanitize_text_field(strtolower(trim($_GET['cat']))) : '';
        $priceFilter = isset($_GET['price']) ? sanitize_text_field(trim($_GET['price'])) : '';
        $sortBy      = isset($_GET['sort']) ? sanitize_text_field(trim($_GET['sort'])) : 'default';

        // 1. Lọc theo danh mục
        if (!empty($catFilter)) {
            $allProducts = array_filter($allProducts, function($p) use ($catFilter) {
                $catName = strtolower($p['category'] ?? '');
                $pName   = strtolower($p['name'] ?? '');

                if ($catFilter === 'banh-ep-hue' || $catFilter === 'banh-ep' || $catFilter === 'banh-hue' || $catFilter === 'banh-loc' || $catFilter === 'banh-nam') {
                    return strpos($catName, 'bánh') !== false || strpos($pName, 'bánh') !== false;
                }
                if ($catFilter === 'mam-hue' || $catFilter === 'mam' || $catFilter === 'mam-tom-chua') {
                    return strpos($catName, 'mắm') !== false || strpos($pName, 'mắm') !== false;
                }
                if ($catFilter === 'tra-hue' || $catFilter === 'tra-cung-dinh' || $catFilter === 'tra') {
                    return strpos($catName, 'trà') !== false || strpos($pName, 'trà') !== false;
                }
                if ($catFilter === 'keo-hue' || $catFilter === 'me-xung' || $catFilter === 'keo') {
                    return strpos($catName, 'kẹo') !== false || strpos($catName, 'mè') !== false || strpos($pName, 'kẹo') !== false || strpos($pName, 'mè') !== false;
                }
                if ($catFilter === 'tre-hue' || $catFilter === 'tre') {
                    return strpos($catName, 'tré') !== false || strpos($pName, 'tré') !== false;
                }
                if ($catFilter === 'hat-sen-hue' || $catFilter === 'hat-sen' || $catFilter === 'sen') {
                    return strpos($catName, 'sen') !== false || strpos($pName, 'sen') !== false;
                }
                if ($catFilter === 'nem-chua-hue' || $catFilter === 'nem-chua' || $catFilter === 'nem') {
                    return strpos($catName, 'nem') !== false || strpos($pName, 'nem') !== false;
                }
                if ($catFilter === 'combo' || $catFilter === 'qua') {
                    return strpos($catName, 'combo') !== false || strpos($pName, 'combo') !== false || strpos($pName, 'quà') !== false;
                }
                if ($catFilter === 'an-vat') {
                    return strpos($catName, 'ăn vặt') !== false || strpos($pName, 'khô') !== false || strpos($pName, 'bánh ép') !== false;
                }
                return true;
            });
            $allProducts = array_values($allProducts);
        }

        // 2. Lọc theo khoảng giá
        if (!empty($priceFilter)) {
            $allProducts = array_filter($allProducts, function($p) use ($priceFilter) {
                // Tách số từ chuỗi giá (ví dụ "45.000₫" -> 45000)
                $rawPrice = preg_replace('/[^0-9]/', '', (string)$p['price']);
                $val = intval($rawPrice);

                if ($priceFilter === 'under_50k') {
                    return $val > 0 && $val < 50000;
                }
                if ($priceFilter === '50_100k') {
                    return $val >= 50000 && $val <= 100000;
                }
                if ($priceFilter === '100_200k') {
                    return $val > 100000 && $val <= 200000;
                }
                if ($priceFilter === 'above_200k') {
                    return $val > 200000;
                }
                return true;
            });
            $allProducts = array_values($allProducts);
        }

        // 3. Sắp xếp sản phẩm
        if ($sortBy === 'price_asc') {
            usort($allProducts, function($a, $b) {
                $pA = intval(preg_replace('/[^0-9]/', '', (string)$a['price']));
                $pB = intval(preg_replace('/[^0-9]/', '', (string)$b['price']));
                return $pA <=> $pB;
            });
        } elseif ($sortBy === 'price_desc') {
            usort($allProducts, function($a, $b) {
                $pA = intval(preg_replace('/[^0-9]/', '', (string)$a['price']));
                $pB = intval(preg_replace('/[^0-9]/', '', (string)$b['price']));
                return $pB <=> $pA;
            });
        }

        $this->render('product/catalog', [
            'pageTitle'    => 'Đặc Sản Xứ Huế Trứ Danh - Bánh, Mè Xửng, Trà, Mắm Cố Đô',
            'currentNav'   => 'dac-san',
            'products'     => $allProducts,
            'catFilter'    => $catFilter,
            'priceFilter'  => $priceFilter,
            'sortBy'       => $sortBy
        ]);
    }

    private function stripAccents($str) {
        $str = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $str);
        $str = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $str);
        $str = preg_replace('/[íìỉĩị]/u', 'i', $str);
        $str = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $str);
        $str = preg_replace('/[úùủũụưứừửữự]/u', 'u', $str);
        $str = preg_replace('/[ýỳỷỹỵ]/u', 'y', $str);
        $str = preg_replace('/[đ]/u', 'd', $str);
        return mb_strtolower($str, 'UTF-8');
    }
}

