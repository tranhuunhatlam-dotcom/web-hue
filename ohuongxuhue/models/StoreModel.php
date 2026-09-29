<?php
/**
 * Model quản lý danh sách hệ thống Cửa hàng & Showroom O Hương Xứ Huế
 */

class StoreModel extends BaseModel {
    private static $stores = [
        [
            'id'          => 1,
            'name'        => 'Showroom Cố Đô (Trụ Sở Chính)',
            'type'        => 'Trụ sở & Showroom Trải Nghiệm',
            'badge'       => 'Trụ Sở Chính',
            'address'     => '128 Nguyễn Huệ, Phường Vĩnh Ninh, Thành phố Huế',
            'phone'       => '0234 388 9999 - 0905 123 456',
            'email'       => 'codo@ohuongxuhue.vn',
            'hours'       => '06:30 - 22:30 (Mở cửa tất cả các ngày)',
            'image'       => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=80',
            'services'    => [
                'Không gian thưởng trà cung đình miễn phí',
                'Xem nghệ nhân làm mè xửng tại chỗ',
                'Đóng thùng xốp & hút chân không máy bay',
                'Chấp nhận thanh toán thẻ & QR Code'
            ]
        ],
        [
            'id'          => 2,
            'name'        => 'Không Gian Làng Nghề Kim Long',
            'type'        => 'Cơ sở sản xuất & Showroom Quà Tặng',
            'badge'       => 'Làng Nghề Truyền Thống',
            'address'     => '45 Đường Kim Long, Phường Kim Long, Thành phố Huế (Cách chùa Thiên Mụ 500m)',
            'phone'       => '0234 359 8888',
            'email'       => 'kimlong@ohuongxuhue.vn',
            'hours'       => '07:00 - 21:00 (Mỗi ngày)',
            'image'       => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80',
            'services'    => [
                'Trải nghiệm gói bánh lọc cùng nghệ nhân',
                'Mua mè xửng nóng hổi vừa mới ra lò',
                'Bãi đỗ xe ô tô & xe du lịch 45 chỗ rộng rãi',
                'Miễn phí thử các vị mắm & bánh đặc sản'
            ]
        ],
        [
            'id'          => 3,
            'name'        => 'Đại Diện Phân Phối Miền Nam (TP. Hồ Chí Minh)',
            'type'        => 'Chi nhánh phân phối & Giao hàng hỏa tốc',
            'badge'       => 'Trung Tâm Miền Nam',
            'address'     => '268 Hai Bà Trưng, Phường Tân Định, Quận 1, TP. Hồ Chí Minh',
            'phone'       => '0938 789 101',
            'email'       => 'hcm@ohuongxuhue.vn',
            'hours'       => '08:00 - 21:30',
            'image'       => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=600&q=80',
            'services'    => [
                'Giao nhanh 2h nội thành TP.HCM',
                'Đầy đủ mặt hàng tươi & khô chuyển từ Huế vào mỗi sáng',
                'Tư vấn set quà doanh nghiệp số lượng lớn'
            ]
        ],
        [
            'id'          => 4,
            'name'        => 'Đại Diện Phân Phối Miền Bắc (Hà Nội)',
            'type'        => 'Chi nhánh phân phối & Giao hàng hỏa tốc',
            'badge'       => 'Trung Tâm Miền Bắc',
            'address'     => '88 Phố Huế, Phường Ngô Thì Nhậm, Quận Hai Bà Trưng, Hà Nội',
            'phone'       => '0912 345 678',
            'email'       => 'hanoi@ohuongxuhue.vn',
            'hours'       => '08:00 - 21:30',
            'image'       => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80',
            'services'    => [
                'Giao hàng nội thành Hà Nội trong ngày',
                'Đặc sản gửi tàu hỏa & máy bay tươi ngon',
                'Hỗ trợ xuất hóa đơn VAT công ty'
            ]
        ]
    ];

    public function getAll() {
        return self::$stores;
    }
}
