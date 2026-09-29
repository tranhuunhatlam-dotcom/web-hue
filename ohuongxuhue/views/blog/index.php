<?php
/**
 * View Trang Blog O Hương Xứ Huế
 * Bao gồm 2 chuyên mục: Góc Ẩm Thực & Góc Du Lịch
 * (Các bài viết cũ trong Góc Ẩm Thực đã được xóa theo yêu cầu)
 */
$theme_uri     = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
$home_url      = function_exists('home_url') ? home_url('/') : 'index.php';
$blogs         = $blogs ?? [];
$featuredBlog  = $featuredBlog ?? ($blogs[0] ?? null);
?>

<div class="blog-page-master">
    <!-- Header Banner -->
    <section class="blog-hero-banner">
        <div class="blog-hero-content">
            <nav class="blog-breadcrumb">
                <a href="<?php echo esc_url($home_url); ?>">Trang Chủ</a> &rsaquo; <span>Blog Cố Đô</span>
            </nav>
            <span class="blog-hero-tag">📰 Cẩm Nang Khám Phá Cố Đô</span>
            <h1 class="blog-hero-title">Blog Cố Đô: Ẩm Thực &amp; Du Lịch Xứ Huế</h1>
            <p class="blog-hero-desc">
                Nơi lưu giữ nét đẹp văn hóa ngàn năm, những câu chuyện di sản, hành trình du lịch khám phá và nghệ thuật thưởng thức tinh hoa xứ Cố Đô.
            </p>

            <!-- BỘ LỌC CHUYÊN MỤC BLOG: GÓC ẨM THỰC & GÓC DU LỊCH -->
            <div class="blog-tab-filter" style="margin-top: 25px; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <button type="button" class="btn-blog-tab active" onclick="filterBlogMvc('all', this)" style="padding: 10px 22px; border-radius: 25px; font-weight: 700; font-size: 14px; border: 2px solid #d4af37; cursor: pointer; background: #d4af37; color: #4A0E17;">
                    ✨ Tất Cả Bài Viết
                </button>
                <button type="button" class="btn-blog-tab" onclick="filterBlogMvc('am-thuc', this)" style="padding: 10px 22px; border-radius: 25px; font-weight: 700; font-size: 14px; border: 2px solid #d4af37; cursor: pointer; background: #ffffff; color: #4A0E17;">
                    🍲 Góc Ẩm Thực (Làm Mới)
                </button>
                <button type="button" class="btn-blog-tab" onclick="filterBlogMvc('du-lich', this)" style="padding: 10px 22px; border-radius: 25px; font-weight: 700; font-size: 14px; border: 2px solid #d4af37; cursor: pointer; background: #ffffff; color: #4A0E17;">
                    🏯 Góc Du Lịch Cố Đô
                </button>
            </div>
        </div>
    </section>

    <div class="blog-container">
        <!-- BÀI VIẾT NỔI BẬT (FEATURED HERO) -->
        <div id="blogFeaturedWrap">
            <?php if ($featuredBlog): ?>
                <div class="featured-blog-card" onclick="openBlogModal(<?php echo $featuredBlog['id']; ?>)">
                    <div class="featured-img-col">
                        <img src="<?php echo htmlspecialchars($featuredBlog['image']); ?>" alt="<?php echo htmlspecialchars($featuredBlog['title']); ?>">
                        <span class="featured-tag">★ Bài Viết Nổi Bật</span>
                    </div>
                    <div class="featured-info-col">
                        <div class="blog-meta-row">
                            <span class="meta-category"><?php echo htmlspecialchars($featuredBlog['category']); ?></span>
                            <span class="meta-dot">&bull;</span>
                            <span class="meta-date">📅 <?php echo htmlspecialchars($featuredBlog['date']); ?></span>
                            <span class="meta-dot">&bull;</span>
                            <span class="meta-read">⏳ <?php echo htmlspecialchars($featuredBlog['read_time']); ?></span>
                        </div>

                        <h2 class="featured-title"><?php echo htmlspecialchars($featuredBlog['title']); ?></h2>
                        <p class="featured-summary"><?php echo htmlspecialchars($featuredBlog['summary']); ?></p>

                        <div class="featured-author-row">
                            <div class="author-avatar">✍️</div>
                            <div class="author-info">
                                <strong><?php echo htmlspecialchars($featuredBlog['author']); ?></strong>
                                <span>Chuyên gia Khám phá Văn hóa Huế</span>
                            </div>
                            <button type="button" class="btn-read-featured">
                                Đọc Toàn Bộ Bài Viết &rarr;
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- DANH SÁCH CÁC BÀI VIẾT MỚI NHẤT -->
        <div class="blog-list-header">
            <h2 class="blog-section-title" id="mvcBlogTitle">Khám Phá Bài Viết Blog Mới Nhất</h2>
            <p class="blog-section-sub" id="mvcBlogSub">Những chia sẻ tâm huyết của những người con gắn bó máu thịt với di sản quê hương</p>
        </div>

        <div class="blog-grid" id="mvcBlogGrid">
            <?php foreach ($blogs as $b): 
                $bCatSlug = ($b['category_slug'] ?? '') ?: (($b['category'] === 'Góc Du Lịch') ? 'du-lich' : 'am-thuc');
            ?>
                <article class="blog-card" data-cat="<?php echo esc_attr($bCatSlug); ?>" onclick="openBlogModal(<?php echo $b['id']; ?>)">
                    <div class="blog-card-img">
                        <img src="<?php echo htmlspecialchars($b['image']); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>">
                        <span class="blog-category-badge"><?php echo htmlspecialchars($b['category']); ?></span>
                    </div>

                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span>📅 <?php echo htmlspecialchars($b['date']); ?></span>
                            <span>⏳ <?php echo htmlspecialchars($b['read_time']); ?></span>
                        </div>

                        <h3 class="blog-card-title"><?php echo htmlspecialchars($b['title']); ?></h3>
                        <p class="blog-card-excerpt"><?php echo htmlspecialchars($b['summary']); ?></p>

                        <div class="blog-card-footer">
                            <span class="author-name">✍️ <?php echo htmlspecialchars($b['author']); ?></span>
                            <span class="read-more-link">Đọc tiếp &rarr;</span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- KHỐI THÔNG BÁO KHI CHUYÊN MỤC ĐANG CẬP NHẬT -->
        <div id="mvcBlogEmptyNotice" style="display: none; text-align: center; padding: 50px 20px; background: #fff; border: 2px dashed #d4af37; border-radius: 16px; margin: 30px 0;">
            <div style="font-size: 48px; margin-bottom: 12px;">🍲</div>
            <h3 style="color: #7A1E2E; font-size: 20px; margin-bottom: 8px;">Góc Ẩm Thực Đang Được Cập Nhật</h3>
            <p style="color: #666; max-width: 500px; margin: 0 auto; line-height: 1.6;">
                Các bài viết cũ trong Góc Ẩm Thực đã được xóa để làm mới nội dung. Đội ngũ O Hương Xứ Huế đang biên soạn loạt bài viết độc quyền về công thức gia truyền và nghệ thuật ẩm thực cung đình. Xin quý khách vui lòng đón đọc!
            </p>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL ĐỌC BÀI VIẾT TỨC THÌ (BLOG READER MODAL) -->
<!-- ======================================================== -->
<div id="blogReadModal" class="quick-modal-overlay" onclick="closeBlogModal(event)">
    <div class="quick-modal-content blog-modal-box" onclick="event.stopPropagation()">
        <button type="button" class="quick-modal-close" onclick="closeBlogModal(null)">&times;</button>
        
        <div class="blog-modal-header">
            <div class="modal-category" id="modalBlogCat">Góc Du Lịch</div>
            <h2 id="modalBlogTitle">Tiêu Đề Bài Viết</h2>
            <div class="modal-author-bar">
                <span id="modalBlogAuthor">✍️ Tác giả</span>
                <span id="modalBlogDate">📅 16/09/2026</span>
                <span id="modalBlogReadTime">⏳ 5 phút</span>
            </div>
        </div>

        <div class="blog-modal-body">
            <div class="blog-modal-cover">
                <img id="modalBlogImg" src="" alt="Ảnh bài viết">
            </div>
            <p id="modalBlogSummary" class="blog-modal-summary"></p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            <div id="modalBlogContent" class="blog-modal-full-content"></div>
        </div>

        <div class="blog-modal-footer">
            <button type="button" class="btn-close-modal-bottom" onclick="closeBlogModal(null)">Đóng Cửa Sổ</button>
        </div>
    </div>
</div>

<script>
const mvcBlogsData = <?php echo json_encode($blogs, JSON_UNESCAPED_UNICODE); ?>;

function filterBlogMvc(cat, btn) {
    document.querySelectorAll('.btn-blog-tab').forEach(b => {
        b.style.background = '#ffffff';
        b.style.color = '#4A0E17';
    });
    if (btn) {
        btn.style.background = '#d4af37';
        btn.style.color = '#4A0E17';
    }

    const cards = document.querySelectorAll('#mvcBlogGrid .blog-card');
    const featuredWrap = document.getElementById('blogFeaturedWrap');
    const emptyNotice = document.getElementById('mvcBlogEmptyNotice');
    const title = document.getElementById('mvcBlogTitle');
    const sub = document.getElementById('mvcBlogSub');

    if (cat === 'am-thuc') {
        cards.forEach(c => c.style.display = 'none');
        featuredWrap.style.display = 'none';
        emptyNotice.style.display = 'block';
        title.textContent = 'Góc Ẩm Thực Cố Đô';
        sub.textContent = 'Chuyên mục đang được cập nhật các bài viết mới nhất';
    } else if (cat === 'du-lich') {
        let count = 0;
        cards.forEach(c => {
            if (c.getAttribute('data-cat') === 'du-lich') {
                c.style.display = '';
                count++;
            } else {
                c.style.display = 'none';
            }
        });
        featuredWrap.style.display = '';
        emptyNotice.style.display = count === 0 ? 'block' : 'none';
        title.textContent = 'Góc Du Lịch: Điểm Đến & Di Sản Cố Đô';
        sub.textContent = 'Cẩm nang hành trình khám phá vẻ đẹp thơ mộng xứ Huế';
    } else {
        cards.forEach(c => c.style.display = '');
        featuredWrap.style.display = '';
        emptyNotice.style.display = 'none';
        title.textContent = 'Khám Phá Tất Cả Bài Viết';
        sub.textContent = 'Gồm cả Góc Ẩm Thực và Góc Du Lịch Xứ Huế';
    }
}

function openBlogModal(id) {
    const blog = mvcBlogsData.find(b => b.id === id);
    if (!blog) return;
    document.getElementById('modalBlogCat').textContent = blog.category;
    document.getElementById('modalBlogTitle').textContent = blog.title;
    document.getElementById('modalBlogAuthor').textContent = '✍️ ' + blog.author;
    document.getElementById('modalBlogDate').textContent = '📅 ' + blog.date;
    document.getElementById('modalBlogReadTime').textContent = '⏳ ' + blog.read_time;
    document.getElementById('modalBlogImg').src = blog.image;
    document.getElementById('modalBlogSummary').textContent = blog.summary;
    document.getElementById('modalBlogContent').innerHTML = `<p style="font-size: 15px; line-height: 1.8; color: #333;">${blog.content}</p>`;

    const modal = document.getElementById('blogReadModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeBlogModal(event) {
    if (!event || event.target.id === 'blogReadModal' || event.target.classList.contains('quick-modal-close') || event.target.classList.contains('btn-close-modal-bottom')) {
        const modal = document.getElementById('blogReadModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}
</script>
