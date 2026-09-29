<?php
/**
 * Controller quản lý trang Tin tức / Cẩm nang ẩm thực (BlogController)
 */

class BlogController extends BaseController {
    public function index() {
        $blogModel = new BlogModel();
        $blogs = $blogModel->getAll();
        $featuredBlog = $blogModel->getFeatured();

        $this->render('blog/index', [
            'pageTitle'    => 'Cẩm Nang Ẩm Thực & Văn Hóa Xứ Huế - O Hương Xứ Huế',
            'currentNav'   => 'blog',
            'blogs'        => $blogs,
            'featuredBlog' => $featuredBlog
        ]);
    }
}
