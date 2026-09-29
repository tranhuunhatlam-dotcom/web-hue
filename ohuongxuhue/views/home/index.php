<?php
/**
 * View Trang chủ O Hương Xứ Huế
 * Nhận dữ liệu từ HomeController: $categories, $topProducts, $banhHueProducts, $meXungProducts, $allProductsMaster
 */

$detailUrl       = function_exists('home_url') ? home_url('/?controller=product&action=detail&id=') : 'index.php?controller=product&action=detail&id=';
$checkoutUrl     = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() . '?sync_cart=1' : (function_exists('home_url') ? home_url('/thanh-toan/?sync_cart=1') : 'thanh-toan/?sync_cart=1');
$cartUrl         = function_exists('home_url') ? home_url('/?controller=cart') : 'index.php?controller=cart';
$theme_uri       = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
?>

<style>
/* CSS Nút Thêm vào giỏ & Mua ngay cho Card sản phẩm */
.card-btn-group {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
    margin-top: 12px;
}

.btn-add-cart-ajax {
    flex: 1;
    background: #fdf6e7;
    color: #8b1d24;
    border: 1.5px solid #d4af37;
    border-radius: 20px;
    padding: 8px 10px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-add-cart-ajax:hover {
    background: #d4af37;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.35);
}

.btn-buy-now {
    flex: 1;
    background: linear-gradient(135deg, #8b1d24 0%, #6b1218 100%);
    color: #ffffff !important;
    border: 1.5px solid #8b1d24;
    border-radius: 20px;
    padding: 8px 10px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none !important;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    transition: all 0.2s ease;
    white-space: nowrap;
    box-shadow: 0 3px 10px rgba(139, 29, 36, 0.25);
}

.btn-buy-now:hover {
    background: linear-gradient(135deg, #a0232b 0%, #7d161d 100%);
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(139, 29, 36, 0.45);
}

.product-img-link {
    display: block;
    text-decoration: none;
    position: relative;
    overflow: hidden;
    border-radius: 12px;
}

.product-img-link .product-img img {
    transition: transform 0.35s ease;
    display: block;
    width: 100%;
}

.product-card:hover .product-img img {
    transform: scale(1.06);
}

.product-title a {
    color: #3e2723;
    text-decoration: none;
    transition: color 0.2s;
}

.product-title a:hover {
    color: #8b1d24;
}

/* Toast thông báo thêm giỏ hàng */
.cart-toast-notification {
    position: fixed;
    bottom: 25px;
    right: 25px;
    background: #ffffff;
    border: 2px solid #d4af37;
    border-radius: 12px;
    padding: 16px 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 15px;
    transform: translateY(120%);
    opacity: 0;
    transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.cart-toast-notification.show {
    transform: translateY(0);
    opacity: 1;
}

.cart-toast-icon {
    font-size: 28px;
}

.cart-toast-content {
    font-size: 13px;
    color: #333;
}

.cart-toast-title {
    font-weight: 700;
    color: #8b1d24;
    font-size: 14px;
    margin-bottom: 2px;
}

.cart-toast-btns {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.cart-toast-btn-view {
    background: #fdf6e7;
    color: #8b5a2b;
    border: 1px solid #d4af37;
    padding: 5px 12px;
    border-radius: 14px;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
}

.cart-toast-btn-checkout {
    background: #8b1d24;
    color: #fff !important;
    padding: 5px 12px;
    border-radius: 14px;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
}
</style>

    <!-- BỐ CỤC 2 CỘT (CHỈ DÀNH CHO DANH MỤC VÀ BANNER) -->
    <div class="main-layout">
        
        <!-- Cột Trái: Danh Mục Đặc Sản Cố Đô Hoàng Gia -->
        <aside class="sidebar-categories">
            <div class="sidebar-title">
                <div class="sidebar-title-main">
                    <span>DANH MỤC ĐẶC SẢN</span>
                </div>
                <span class="sidebar-title-badge">CỐ ĐÔ</span>
            </div>
            <ul class="sidebar-list">
                <?php foreach ($categories as $index => $cat): 
                    $catName = $cat['name'];
                    $catBadge = $cat['badge'] ?? '';
                    $catBadgeCls = $cat['badge_cls'] ?? '';
                    $hasChildren = !empty($cat['children']);
                ?>
                    <li class="sidebar-item has-accordion">
                        <div class="accordion-header" onclick="toggleSidebarCategory(this)" role="button" tabindex="0" title="Nhấn để xem các loại <?php echo htmlspecialchars($catName); ?>">
                            <span class="sidebar-item-left">
                                <span class="sidebar-item-name"><?php echo htmlspecialchars($catName); ?></span>
                            </span>
                            <span class="sidebar-item-right">
                                <?php if (!empty($catBadge)): ?>
                                    <span class="sidebar-item-badge <?php echo htmlspecialchars($catBadgeCls); ?>"><?php echo htmlspecialchars($catBadge); ?></span>
                                <?php endif; ?>
                                <span class="sidebar-item-arrow">›</span>
                            </span>
                        </div>
                        <?php if ($hasChildren): ?>
                            <ul class="accordion-sub-list">
                                <?php foreach ($cat['children'] as $sub): ?>
                                    <li>
                                        <a href="<?php echo htmlspecialchars($sub['link']); ?>">
                                            <?php echo htmlspecialchars($sub['name']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <li class="sub-view-all">
                                    <a href="<?php echo htmlspecialchars($cat['link']); ?>">
                                        Xem tất cả danh mục này &rarr;
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Chân bảo chứng chất lượng ẩm thực Cố Đô -->
            <div class="sidebar-trust-box">
                <div class="trust-item">
                    <span>100% Nguyên liệu truyền thống Cố Đô</span>
                </div>
                <div class="trust-item">
                    <span>Đóng thùng xốp đá khô giao hỏa tốc</span>
                </div>
            </div>
        </aside>

        <!-- Cột Phải: Chỉ chứa Banner -->
        <div class="content-area">
            <section class="hero-section">
                <!-- 1. Cột Trái: Chữ Hương Vị Cố Đô -->
                <div class="hero-codo-left">
                    <h2>HƯƠNG VỊ CỐ ĐÔ</h2>
                    <p>Hương vị tinh túy cố đô nơi rạng danh nét ẩm thực Hương Xứ Huế</p>
                </div>
                
                <!-- 2. Cột Giữa: Ảnh Mâm Cỗ + Badge Đặc Sản Nổi Bật -->
                <div class="hero-codo-center">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/codo-main.jpg'); ?>" alt="Đặc sản Huế mâm cỗ truyền thống" class="codo-main-img">
                    <div class="codo-center-badge">
                        <h3>ĐẶC SẢN NỔI BẬT</h3>
                        <p>Bao năm theo mẹ gìn giữ hương vị Cố Đô, từng món ăn gắn kết hồn quê xứ Huế.</p>
                    </div>
                </div>

                <!-- 3. Cột Phải: 2 Ảnh Xếp Chồng -->
                <div class="hero-codo-right">
                    <div class="codo-sub-box">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/codo-salad.jpg'); ?>" alt="Mẹt bánh ít ram và bánh bèo Cố Đô Huế">
                    </div>
                    <div class="codo-sub-box">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/codo-banhep.jpg'); ?>" alt="Bánh canh Nam Phổ truyền thống xứ Huế">
                    </div>
                </div>
            </section>
        </div> 
        <!-- Đóng Cột Phải -->

    </div> 
    <!-- Đóng Bố Cục Chính 2 Cột -->


    <!-- ========================================== -->
    <!-- KHU VỰC TOP ĐẶC SẢN (KÉO RỘNG CÂN ĐỐI 1400PX) -->
    <!-- ========================================== -->
    <div style="max-width: 1400px; margin: 0 auto 55px auto; padding: 0 24px;">
        <section class="products-section reveal-on-scroll">
            <div class="section-title-wrapper">
                <h2 class="section-title">Top Đặc Sản Huế Nổi Bật</h2>
                <p class="section-subtitle">Tinh hoa ẩm thực Cố Đô lưu truyền ngàn đời, đậm đà phong vị sông Hương núi Ngự</p>
            </div>
            <div class="products-grid">
                <?php foreach ($topProducts as $item): ?>
                    <?php $itemUrl = $detailUrl . $item['id']; ?>
                    <div class="product-card">
                        <!-- Nhấn vào ảnh để xem chi tiết (qua trang chi tiết ở giữa) -->
                        <a href="<?php echo esc_url($itemUrl); ?>" class="product-img-link" title="Xem chi tiết <?php echo htmlspecialchars($item['name']); ?>">
                            <div class="product-img">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>
                        </a>
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="<?php echo esc_url($itemUrl); ?>" title="Xem chi tiết <?php echo htmlspecialchars($item['name']); ?>">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </a>
                            </h3>
                            <div class="product-price"><?php echo htmlspecialchars($item['price']); ?></div>
                            
                            <!-- 2 Nút: Thêm vào giỏ hàng & Mua ngay -->
                            <div class="card-btn-group">
                                <button type="button" class="btn-add-cart-ajax" onclick="addCartAjax(<?php echo $item['id']; ?>, '<?php echo addslashes($item['name']); ?>')" title="Thêm vào giỏ hàng">
                                    🛒 Thêm vào giỏ
                                </button>
                                <a href="?controller=cart&action=add&id=<?php echo $item['id']; ?>&redirect=<?php echo urlencode($checkoutUrl); ?>" class="btn-buy-now" title="Mua ngay đặc sản này">
                                    ⚡ Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>


    <!-- ========================================== -->
    <!-- KHU VỰC CÁC DANH MỤC LỚN BÊN DƯỚI -->
    <!-- ========================================== -->
    <div class="bottom-category-wrapper">
        
        <!-- Khối 1: BÁNH HUẾ TRUYỀN THỐNG (THEME XANH LỤC HOÀNG GIA & VÀNG) -->
        <div class="category-showcase-box theme-banh-hue reveal-on-scroll">
            <div class="showcase-header">
                <div class="showcase-title-group">
                    <div class="showcase-icon-badge">🥟</div>
                    <div>
                        <h3 class="showcase-title">BÁNH ÉP &amp; NEM TRÉ HUẾ</h3>
                        <span class="showcase-tagline">Đậm đà phong vị Cố Đô • Bánh ép giòn rụm, tré bò rơm lên men chuẩn vị</span>
                    </div>
                </div>
                <div class="showcase-pills">
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=banh-ep-hue')); ?>" class="showcase-pill-link active">Tất Cả Bánh Ép</a>
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=banh-ep-hue')); ?>" class="showcase-pill-link">Bánh Ép Khô</a>
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=nem-chua-hue')); ?>" class="showcase-pill-link">Nem Chua Huế</a>
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=tre-hue')); ?>" class="showcase-pill-link">Tré Bò Cố Đô</a>
                </div>
            </div>
            
            <div class="showcase-content">
                <!-- Thẻ điểm nhấn bên trái -->
                <div class="showcase-hero-card">
                    <div class="showcase-img-wrap">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/spotlight-banh.jpg'); ?>" alt="Đặc sản Bánh Huế truyền thống">
                        <div class="showcase-badge-floating">🌿 Tươi Ngon Chuẩn Vị</div>
                    </div>
                    <div class="showcase-card-overlay">
                        <div>
                            <h4>Bánh Ép &amp; Nem Tré Cố Đô</h4>
                            <p>Bánh ép Thuận An giòn rụm đậm vị, nem chua chùm lá ổi lên men truyền thống, tré bò cay nồng thơm ngát mùi riềng tiêu.</p>
                        </div>
                        <a href="<?php echo esc_url(home_url('/dac-san/?cat=banh-ep-hue')); ?>" class="showcase-cta-btn">Khám Phá Menu &rarr;</a>
                    </div>
                </div>

                <!-- Lưới sản phẩm bên phải -->
                <div class="showcase-products-grid">
                    <?php foreach ($banhHueProducts as $item): ?>
                        <?php $itemUrl = $detailUrl . $item['id']; ?>
                        <div class="product-card">
                            <a href="<?php echo esc_url($itemUrl); ?>" class="product-img-link" title="Xem chi tiết <?php echo htmlspecialchars($item['name']); ?>">
                                <div class="product-img">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                            </a>
                            <div class="product-info">
                                <h4 class="product-title">
                                    <a href="<?php echo esc_url($itemUrl); ?>" title="Xem chi tiết <?php echo htmlspecialchars($item['name']); ?>">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </a>
                                </h4>
                                <div class="product-price"><?php echo htmlspecialchars($item['price']); ?></div>
                                
                                <div class="card-btn-group">
                                    <button type="button" class="btn-add-cart-ajax" onclick="addCartAjax(<?php echo $item['id']; ?>, '<?php echo addslashes($item['name']); ?>')" title="Thêm vào giỏ hàng">
                                        🛒 Thêm vào giỏ
                                    </button>
                                    <a href="?controller=cart&action=add&id=<?php echo $item['id']; ?>&redirect=<?php echo urlencode($checkoutUrl); ?>" class="btn-buy-now" title="Mua ngay đặc sản này">
                                        ⚡ Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Khối 2: MÈ XỬNG & TRÀ CUNG ĐÌNH (THEME ĐỎ RUBY HOÀNG GIA & VÀNG) -->
        <div class="category-showcase-box theme-me-xung reveal-on-scroll">
            <div class="showcase-header">
                <div class="showcase-title-group">
                    <div class="showcase-icon-badge">🍬</div>
                    <div>
                        <h3 class="showcase-title">MÈ XỬNG, KẸO HUẾ &amp; TRÀ CUNG ĐÌNH</h3>
                        <span class="showcase-tagline">Thức quà tiến vua • Mè rang vàng ruộm, hạt sen Tịnh Tâm bùi béo trứ danh</span>
                    </div>
                </div>
                <div class="showcase-pills">
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=keo-hue')); ?>" class="showcase-pill-link active">Tất Cả Kẹo Huế</a>
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=tra-hue')); ?>" class="showcase-pill-link">Trà Cung Đình</a>
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=hat-sen-hue')); ?>" class="showcase-pill-link">Hạt Sen Huế</a>
                    <a href="<?php echo esc_url(home_url('/dac-san/?cat=mam-hue')); ?>" class="showcase-pill-link">Mắm Cố Đô</a>
                </div>
            </div>
            
            <div class="showcase-content">
                <!-- Thẻ điểm nhấn bên trái -->
                <div class="showcase-hero-card">
                    <div class="showcase-img-wrap">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/spotlight-mexung.jpg'); ?>" alt="Đặc sản Mè Xửng & Trà Cung Đình Huế">
                        <div class="showcase-badge-floating">👑 Đặc Sản Tiến Vua</div>
                    </div>
                    <div class="showcase-card-overlay">
                        <div>
                            <h4>Mè Xửng &amp; Trà Huế</h4>
                            <p>Thưởng thức miếng mè xửng bùi béo ngọt thanh, nhâm nhi tách trà cung đình thơm ngát hoa cúc hoa sen.</p>
                        </div>
                        <a href="<?php echo esc_url(home_url('/dac-san/?cat=me-xung')); ?>" class="showcase-cta-btn">Khám Phá Menu &rarr;</a>
                    </div>
                </div>

                <!-- Lưới sản phẩm bên phải -->
                <div class="showcase-products-grid">
                    <?php foreach ($meXungProducts as $item): ?>
                        <?php $itemUrl = $detailUrl . $item['id']; ?>
                        <div class="product-card">
                            <a href="<?php echo esc_url($itemUrl); ?>" class="product-img-link" title="Xem chi tiết <?php echo htmlspecialchars($item['name']); ?>">
                                <div class="product-img">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                            </a>
                            <div class="product-info">
                                <h4 class="product-title">
                                    <a href="<?php echo esc_url($itemUrl); ?>" title="Xem chi tiết <?php echo htmlspecialchars($item['name']); ?>">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </a>
                                </h4>
                                <div class="product-price"><?php echo htmlspecialchars($item['price']); ?></div>
                                
                                <div class="card-btn-group">
                                    <button type="button" class="btn-add-cart-ajax" onclick="addCartAjax(<?php echo $item['id']; ?>, '<?php echo addslashes($item['name']); ?>')" title="Thêm vào giỏ hàng">
                                        🛒 Thêm vào giỏ
                                    </button>
                                    <a href="?controller=cart&action=add&id=<?php echo $item['id']; ?>&redirect=<?php echo urlencode($checkoutUrl); ?>" class="btn-buy-now" title="Mua ngay đặc sản này">
                                        ⚡ Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div> 
    <!-- Đóng khu vực khối danh mục dưới -->

    <!-- Toast thông báo thêm giỏ hàng thành công -->
    <div id="cartToast" class="cart-toast-notification">
        <div class="cart-toast-icon">🛍️</div>
        <div class="cart-toast-content">
            <div class="cart-toast-title">Đã thêm vào giỏ hàng!</div>
            <div id="cartToastMsg">Sản phẩm đặc sản đã được thêm vào giỏ.</div>
            <div class="cart-toast-btns">
                <a href="<?php echo esc_url($cartUrl); ?>" class="cart-toast-btn-view">Xem Giỏ Hàng</a>
                <a href="<?php echo esc_url($checkoutUrl); ?>" class="cart-toast-btn-checkout">Thanh Toán Ngay &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Script xử lý thêm vào giỏ bằng Ajax, Toast và Accordion Danh Mục -->
    <script>
    function toggleSidebarCategory(headerEl) {
        const parent = headerEl.closest('.sidebar-item.has-accordion');
        if (!parent) return;
        const isAlreadyActive = parent.classList.contains('active');
        
        // Đóng tất cả các mục accordion khác để giữ sidebar gọn gàng
        document.querySelectorAll('.sidebar-item.has-accordion').forEach(function(item) {
            item.classList.remove('active');
        });
        
        // Nếu mục vừa bấm chưa mở thì mở ra
        if (!isAlreadyActive) {
            parent.classList.add('active');
        }
    }

    let toastTimeout = null;

    function addCartAjax(productId, productName) {
        fetch('index.php?controller=cart&action=add&id=' + productId + '&ajax=1')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng giỏ hàng trên header
                    const badges = document.querySelectorAll('.cart-count-badge, #headerCartCount');
                    badges.forEach(b => {
                        b.innerText = data.cart_count;
                        b.style.display = 'inline-block';
                    });

                    // Hiển thị Toast
                    const toast = document.getElementById('cartToast');
                    const toastMsg = document.getElementById('cartToastMsg');
                    if (toast && toastMsg) {
                        toastMsg.innerText = '"' + productName + '" đã được thêm vào giỏ hàng.';
                        toast.classList.add('show');

                        if (toastTimeout) clearTimeout(toastTimeout);
                        toastTimeout = setTimeout(() => {
                            toast.classList.remove('show');
                        }, 4000);
                    }
                } else {
                    alert(data.message || 'Không thể thêm sản phẩm vào giỏ.');
                }
            })
            .catch(err => {
                // Fallback nếu có lỗi mạng
                window.location.href = 'index.php?controller=cart&action=add&id=' + productId;
            });
    }
    </script>
