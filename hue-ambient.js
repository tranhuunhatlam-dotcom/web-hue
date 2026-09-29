/**
 * ==========================================================================
 * HOA VĂN TRỐNG ĐỒNG ĐÔNG SƠN HUẾ - KINETIC ROTATION ENGINE
 * Thương hiệu: O Hương Xứ Huế - Vị Ngon Cố Đô
 * ==========================================================================
 */

(function() {
    'use strict';

    // Xóa bỏ các cài đặt âm cảnh & hiệu ứng cũ khỏi localStorage nếu có
    try {
        localStorage.removeItem('ohx_ambient_pref');
        document.body.classList.remove('hue-lantern-mode');
        const oldCanvas = document.getElementById('huePetalCanvas');
        if (oldCanvas) oldCanvas.remove();
        const oldTrigger = document.getElementById('hueAmbientTrigger');
        if (oldTrigger) oldTrigger.remove();
        const oldPanel = document.getElementById('hueAmbientPanel');
        if (oldPanel) oldPanel.remove();
    } catch(e) {}

    // Đảm bảo phần tử Trống Đồng luôn có mặt trong DOM trên mọi trang
    function ensureTrongDongBg() {
        let bg = document.getElementById('hueTrongDongBg');
        if (!bg && document.body) {
            let svgSrc = 'images/trong-dong-dong-son.svg';
            if (typeof window.HUE_THEME_URI !== 'undefined' && window.HUE_THEME_URI) {
                svgSrc = window.HUE_THEME_URI + '/assets/images/trong-dong-dong-son.svg';
            } else if (document.querySelector('link[href*="wp-content"]')) {
                svgSrc = 'wp-content/themes/ohuongxuhue/assets/images/trong-dong-dong-son.svg';
            }

            bg = document.createElement('div');
            bg.className = 'hue-trong-dong-bg';
            bg.id = 'hueTrongDongBg';
            bg.setAttribute('aria-hidden', 'true');
            bg.innerHTML = `
                <div class="hue-trong-dong-glow"></div>
                <div class="hue-trong-dong-disc hue-trong-dong-main" title="Hoa văn Trống Đồng Đông Sơn xoay">
                    <img src="${svgSrc}" alt="Hoa văn Trống Đồng Đông Sơn Cố Đô" loading="eager">
                </div>
            `;
            if (document.body.firstChild) {
                document.body.insertBefore(bg, document.body.firstChild);
            } else {
                document.body.appendChild(bg);
            }
        }
        return bg;
    }

    // Động cơ JavaScript quay đĩa Trống Đồng 60fps mượt mà liên tục
    let drumAngle = 0;
    let lastTick = performance.now();
    function startDrumMotor() {
        function tick(now) {
            const dt = Math.min((now - lastTick) / 1000, 0.1);
            lastTick = now;
            const degPerSec = 18; // Chu kỳ 20 giây hoàn thành 1 vòng quay 360 độ

            drumAngle = (drumAngle + degPerSec * dt) % 360;

            const drumImg = document.querySelector('.hue-trong-dong-main img');
            if (drumImg) {
                drumImg.style.transform = `rotate(${drumAngle.toFixed(2)}deg)`;
            }
            requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    // Khởi chạy khi DOM sẵn sàng
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            ensureTrongDongBg();
            startDrumMotor();
        });
    } else {
        ensureTrongDongBg();
        startDrumMotor();
    }
})();
