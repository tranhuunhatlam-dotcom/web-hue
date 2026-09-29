<?php
/**
 * Controller xử lý Trang giới thiệu (AboutController)
 */

class AboutController extends BaseController {
    public function index() {
        $this->render('about/index', [
            'pageTitle'  => 'Giới thiệu - O Hương Xứ Huế',
            'currentNav' => 'about',
        ]);
    }
}
