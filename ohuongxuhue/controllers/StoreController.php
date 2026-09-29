<?php
/**
 * Controller quản lý trang Hệ thống Cửa hàng & Showroom (StoreController)
 */

class StoreController extends BaseController {
    public function index() {
        $storeModel = new StoreModel();
        $stores = $storeModel->getAll();

        $this->render('store/index', [
            'pageTitle'  => 'Hệ Thống Cửa Hàng & Showroom Đặc Sản O Hương Xứ Huế',
            'currentNav' => 'store',
            'stores'     => $stores
        ]);
    }
}
