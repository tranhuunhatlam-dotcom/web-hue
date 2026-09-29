<?php
/**
 * Controller xử lý Trang chủ (HomeController)
 */

class HomeController extends BaseController {
    public function index() {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();

        // Lấy dữ liệu từ Model kèm tồn kho
        $categories        = $categoryModel->getSidebarCategories();
        $allProductsMaster = $productModel->getAllProductsWithStock();
        $topProducts       = [
            $allProductsMaster[1],
            $allProductsMaster[2],
            $allProductsMaster[3],
            $allProductsMaster[4]
        ];
        $banhHueProducts   = [
            $allProductsMaster[5],
            $allProductsMaster[6],
            $allProductsMaster[7],
            $allProductsMaster[8]
        ];
        $meXungProducts    = [
            $allProductsMaster[9],
            $allProductsMaster[10],
            $allProductsMaster[11],
            $allProductsMaster[12]
        ];

        // Render ra view home/index
        $this->render('home/index', [
            'pageTitle'         => 'O Hương Xứ Huế - Vị Ngon Cố Đô',
            'currentNav'        => 'home',
            'categories'        => $categories,
            'topProducts'       => $topProducts,
            'banhHueProducts'   => $banhHueProducts,
            'meXungProducts'    => $meXungProducts,
            'allProductsMaster' => $allProductsMaster
        ]);
    }
}
