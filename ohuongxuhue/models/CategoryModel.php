<?php
/**
 * Model quản lý danh mục đặc sản O Hương Xứ Huế (Đa tầng: Danh mục cha & Danh mục con)
 */

class CategoryModel extends BaseModel {
    /**
     * Lấy danh sách danh mục hiển thị trên sidebar kèm danh mục con
     */
    public function getSidebarCategories() {
        static $catCache = null;
        if ($catCache !== null) {
            return $catCache;
        }

        $base = function_exists('home_url') ? home_url('/dac-san/?cat=') : 'index.php?controller=dac-san&cat=';

        // 7 danh mục chuẩn theo đúng giao diện với các danh mục con xổ xuống khi bấm
        $defaultCats = [
            [
                'id'       => 1,
                'name'     => 'Bánh Ép Huế (Khô, Dẻo, Thuận An)',
                'slug'     => 'banh-ep-hue',
                'link'     => $base . 'banh-ep-hue',
                'badge'    => 'BÁN CHẠY',
                'badge_cls'=> 'badge-0',
                'children' => [
                    ['name' => 'Bánh Ép Khô Huế', 'slug' => 'banh-ep-kho-hue', 'link' => $base . 'banh-ep-kho-hue'],
                    ['name' => 'Bánh Ép Dẻo Huế', 'slug' => 'banh-ep-deo-hue', 'link' => $base . 'banh-ep-deo-hue'],
                    ['name' => 'Bánh Ép Thuận An', 'slug' => 'banh-ep-thuan-an', 'link' => $base . 'banh-ep-thuan-an'],
                    ['name' => 'Bánh Bèo, Bánh Nậm, Bánh Lọc', 'slug' => 'banh-beo-nam-loc', 'link' => $base . 'banh-beo-nam-loc'],
                ]
            ],
            [
                'id'       => 2,
                'name'     => 'Mắm Huế (Tôm Chua, Ruốc, Nêm, Cá Rò, Sò)',
                'slug'     => 'mam-hue',
                'link'     => $base . 'mam-hue',
                'badge'    => 'CHÍNH GỐC',
                'badge_cls'=> 'badge-1',
                'children' => [
                    ['name' => 'Mắm Tôm Chua Thượng Hạng', 'slug' => 'mam-tom-chua', 'link' => $base . 'mam-tom-chua'],
                    ['name' => 'Mắm Ruốc Huế Gia Truyền', 'slug' => 'mam-ruoc-hue', 'link' => $base . 'mam-ruoc-hue'],
                    ['name' => 'Mắm Nêm & Mắm Cá Rò', 'slug' => 'mam-nem-ca-ro', 'link' => $base . 'mam-nem-ca-ro'],
                    ['name' => 'Mắm Sò Lăng Cô', 'slug' => 'mam-so-lang-co', 'link' => $base . 'mam-so-lang-co'],
                ]
            ],
            [
                'id'       => 3,
                'name'     => 'Trà Cung Đình & Trà Sen Huế',
                'slug'     => 'tra-hue',
                'link'     => $base . 'tra-hue',
                'badge'    => 'THẢO MỘC',
                'badge_cls'=> 'badge-2',
                'children' => [
                    ['name' => 'Trà Cung Đình 16 Vị Đức Phượng', 'slug' => 'tra-cung-dinh', 'link' => $base . 'tra-cung-dinh'],
                    ['name' => 'Trà Sen Hồ Tịnh Tâm', 'slug' => 'tra-sen-hue', 'link' => $base . 'tra-sen-hue'],
                    ['name' => 'Cà Phê Muối Đặc Sản Xứ Huế', 'slug' => 'ca-phe-muoi', 'link' => $base . 'ca-phe-muoi'],
                ]
            ],
            [
                'id'       => 4,
                'name'     => 'Kẹo Huế (Mè Xửng, Kẹo Gừng, Đậu Phộng)',
                'slug'     => 'keo-hue',
                'link'     => $base . 'keo-hue',
                'badge'    => 'NGỰ THIỆN',
                'badge_cls'=> 'badge-3',
                'children' => [
                    ['name' => 'Mè Xửng Dẻo Kim Long Truyền Thống', 'slug' => 'me-xung-deo', 'link' => $base . 'me-xung-deo'],
                    ['name' => 'Mè Xửng Giòn, Kẹo Mè Đen', 'slug' => 'me-xung-gion', 'link' => $base . 'me-xung-gion'],
                    ['name' => 'Kẹo Gừng, Kẹo Đậu Phộng Hoàng Gia', 'slug' => 'keo-gung-dau-phong', 'link' => $base . 'keo-gung-dau-phong'],
                ]
            ],
            [
                'id'       => 5,
                'name'     => 'Tré Bò & Tré Heo Xứ Huế',
                'slug'     => 'tre-hue',
                'link'     => $base . 'tre-hue',
                'badge'    => '',
                'badge_cls'=> '',
                'children' => [
                    ['name' => 'Tré Bò Cố Đô Truyền Thống', 'slug' => 'tre-bo-hue', 'link' => $base . 'tre-bo-hue'],
                    ['name' => 'Tré Heo Rơm Xứ Huế', 'slug' => 'tre-heo-hue', 'link' => $base . 'tre-heo-hue'],
                    ['name' => 'Tré Thập Cẩm Ăn Liền', 'slug' => 'tre-thap-cam', 'link' => $base . 'tre-thap-cam'],
                ]
            ],
            [
                'id'       => 6,
                'name'     => 'Hạt Sen Huế (Khô, Tươi, Sấy, Mứt)',
                'slug'     => 'hat-sen-hue',
                'link'     => $base . 'hat-sen-hue',
                'badge'    => '',
                'badge_cls'=> '',
                'children' => [
                    ['name' => 'Hạt Sen Khô Hồ Tịnh Tâm', 'slug' => 'hat-sen-kho', 'link' => $base . 'hat-sen-kho'],
                    ['name' => 'Hạt Sen Tươi Bóc Vỏ', 'slug' => 'hat-sen-tuoi', 'link' => $base . 'hat-sen-tuoi'],
                    ['name' => 'Hạt Sen Sấy Giòn Ăn Liền', 'slug' => 'hat-sen-say-gion', 'link' => $base . 'hat-sen-say-gion'],
                    ['name' => 'Mứt Hạt Sen Hoàng Cung', 'slug' => 'mut-hat-sen', 'link' => $base . 'mut-hat-sen'],
                ]
            ],
            [
                'id'       => 7,
                'name'     => 'Nem Chua Huế (Nem Thịt, Nem Tré, Nem Bò)',
                'slug'     => 'nem-chua-hue',
                'link'     => $base . 'nem-chua-hue',
                'badge'    => '',
                'badge_cls'=> '',
                'children' => [
                    ['name' => 'Nem Chua Làng Sình Truyền Thống', 'slug' => 'nem-chua-lang-sinh', 'link' => $base . 'nem-chua-lang-sinh'],
                    ['name' => 'Nem Bò Cố Đô', 'slug' => 'nem-bo-hue', 'link' => $base . 'nem-bo-hue'],
                    ['name' => 'Chả Cua & Chả Bò Cố Đô', 'slug' => 'cha-cua-cha-bo', 'link' => $base . 'cha-cua-cha-bo'],
                ]
            ],
        ];

        $catCache = $defaultCats;
        return $defaultCats;
    }
}
