/**
 * ==========================================================================
 * BẢN ĐỒ TƯƠNG TÁC ẨM THỰC CỐ ĐÔ - LIVING MAP & AUTHENTIC PHOTO SHOWCASE
 * Thương hiệu: O Hương Xứ Huế - Vị Ngon Cố Đô
 * Phiên bản: 3.0 Hiện đại & Cao cấp
 * ==========================================================================
 */

(function() {
    'use strict';

    if (window.__HUE_FOOD_MAP_INITIALIZED__) return;
    window.__HUE_FOOD_MAP_INITIALIZED__ = true;

    // HÀM CHUYỂN ĐỔI ĐƯỜNG DẪN ẢNH TƯƠNG THÍCH MỌI MÔI TRƯỜNG (WP & HTML TĨNH)
    function getAssetUrl(relPath) {
        if (!relPath) return '';
        if (relPath.startsWith('http://') || relPath.startsWith('https://') || relPath.startsWith('data:')) {
            return relPath;
        }
        const themeUri = (typeof window.HUE_THEME_URI !== 'undefined' && window.HUE_THEME_URI) 
            ? window.HUE_THEME_URI.replace(/\/+$/, '') 
            : '';

        let clean = relPath.replace(/^\/+/, '');
        if (themeUri) {
            if (!clean.startsWith('assets/')) {
                clean = 'assets/' + clean;
            }
            return themeUri + '/' + clean;
        }
        if (clean.startsWith('assets/')) {
            clean = clean.replace(/^assets\//, '');
        }
        return clean;
    }

    // DỮ LIỆU ĐỊA LINH & ẢNH CHÂN THỰC ĐẶC SẢN HUẾ (100% ẢNH THỰC TẾ XỨ HUẾ)
    const HUE_SPOTS = {
        dainoi: {
            id: 'dainoi',
            name: 'Đại Nội & Hoàng Cung Huế',
            tag: 'Ẩm Thực Cung Đình Triều Nguyễn',
            icon: '🏰',
            rating: '★ 4.9 (1.280+ đánh giá)',
            verse: 'Ai về xứ Huế mộng mơ / Thưởng trà ngự thiện ngắm đài lầu son',
            desc: 'Đỉnh cao ẩm thực cung đình Huế thể hiện ở sự tinh tế, thanh nhã và cầu kỳ từ khâu chọn nguyên liệu đến nghệ thuật trình bày. Từng búp trà ướp hương sen hồ Tịnh Tâm, từng hạt sen trần tươi đều được tuyển lựa nghiêm ngặt theo quy chế ngự trù dâng vua thưởng nguyệt.',
            tips: 'Khi thưởng thức trà Cung Đình, hãy dùng kèm chút Mứt Sen Trần hoặc Mè Xửng Cố Đô giòn tan. Nhấp từng ngụm nhỏ để cảm nhận vị thảo mộc thanh thoát dần chuyển hóa thành vị ngọt hậu dịu sâu nơi cuống họng.',
            category: 'cungdinh',
            gallery: [
                { url: 'images/codo-main.jpg', caption: 'Mâm Cỗ Hoàng Cung Cố Đô Huế - Đỉnh cao ngự trù dâng yến tiệc hoàng triều' },
                { url: 'images/products/p3_tra_cung_dinh.jpg', caption: 'Trà Cung Đình Nhất Dạ Đế Vương 16 vị thảo mộc quý' },
                { url: 'images/codo-salad.jpg', caption: 'Món tráng miệng hoàng cung kết hợp hoa trái Huế xưa' }
            ],
            products: [
                {
                    id: 7,
                    name: 'Trà Cung Đình Nhất Dạ Đế Vương',
                    price: '120.000₫',
                    tag: 'Tiến Vua',
                    meta: 'Thảo mộc 16 vị: Tim sen, hoa cúc, cam thảo, cỏ ngọt',
                    img: 'images/products/p3_tra_cung_dinh.jpg',
                    imgAlt: 'images/products/p3_tra_cung_dinh.jpg',
                    fullDesc: 'Bài trà tiến vua gia truyền kết hợp 16 vị thảo mộc quý của đất Thần Kinh, giúp thanh nhiệt, ngủ ngon giấc và điều hòa khí huyết.'
                },
                {
                    id: 10,
                    name: 'Mứt Hạt Sen Tươi Cố Đô',
                    price: '95.000₫',
                    tag: 'Ngự Trù',
                    meta: 'Sen tươi hồ Tịnh Tâm rim đường phèn thanh tao',
                    img: 'images/codo-main.jpg',
                    imgAlt: 'images/codo-main.jpg',
                    fullDesc: 'Hạt sen bở tơi, ngọt thanh dịu nhẹ đầu lưỡi, đậm đà cốt cách vương giả cung đình Huế xưa.'
                }
            ]
        },
        kimlong: {
            id: 'kimlong',
            name: 'Làng Cổ Kim Long & Bến Thuyền Thiên Mụ',
            tag: 'Bánh Huế Dân Gian Nghìn Năm',
            icon: '🏮',
            rating: '★ 4.9 (950+ đánh giá)',
            verse: 'Kim Long có gái mỹ miều / Bánh bèo tôm chấy sớm chiều đợi anh',
            desc: 'Kim Long ven bờ bắc sông Hương vốn là nơi đóng thủ phủ chúa Nguyễn xưa, nức tiếng với những bàn tay khéo léo làm nên món Bánh Bèo chén mỏng như cánh hoa, bánh nậm thanh tao bọc lá chuối non và bánh lọc trong vắt lộ rõ tôm sông tươi cong mình.',
            tips: 'Bánh bèo Kim Long chan nước mắm nhĩ dầm ớt hiểm cay nồng, dùng thìa tre vót mỏng xắn từng góc bánh. Hãy thưởng thức ngay khi chén bánh còn bốc hơi nghi ngút để cảm nhận trọn vẹn vị mềm bùi của bột gạo mới.',
            category: 'banh',
            gallery: [
                { url: 'images/spotlight-banh.jpg', caption: 'Bánh Bèo Chén Kim Long rắc tôm chấy son au & da heo giòn rụm' },
                { url: 'images/products/p1_banh_beo_nam_loc.jpg', caption: 'Mẹt Bánh Huế Nậm - Bèo - Lọc gia truyền O Hương' },
                { url: 'images/che.jpg', caption: 'Khung cảnh bến thuyền Thiên Mụ chiều tà bên sông Hương' }
            ],
            products: [
                {
                    id: 1,
                    name: 'Mẹt Bánh Bèo Chén Kim Long',
                    price: '45.000₫',
                    tag: 'Bán Chạy Nhất',
                    meta: '12 chén bánh bèo mỏng tang, tôm chấy son au & da heo giòn',
                    img: 'images/spotlight-banh.jpg',
                    imgAlt: 'images/spotlight-banh.jpg',
                    fullDesc: 'Bánh bèo đổ trong từng chén sành nhỏ, rắc tôm chấy vàng ruộm, hành phi thơm lừng cùng tóp mỡ chiên giòn, chan ngập nước mắm ớt cay nồng.'
                },
                {
                    id: 2,
                    name: 'Bánh Nậm Tôm Thịt Lá Chuối',
                    price: '50.000₫',
                    tag: 'Gia Truyền',
                    meta: 'Bột gạo thơm bọc nhân tôm thịt đậm đà, gói lá chuối tiêu',
                    img: 'images/products/p1_banh_beo_nam_loc.jpg',
                    imgAlt: 'images/products/p1_banh_beo_nam_loc.jpg',
                    fullDesc: 'Từng chiếc bánh nậm phẳng phiu, nhân tôm thịt xào tiêu ngào ngạt, bóc lớp lá chuối nóng hổi thơm nức mũi.'
                }
            ]
        },
        conhen: {
            id: 'conhen',
            name: 'Cồn Hến & Thôn Vĩ Dạ',
            tag: 'Hương Vị Sông Hương Cay Nồng',
            icon: '🏝️',
            rating: '★ 4.8 (1.420+ đánh giá)',
            verse: 'Mặt nước sông Hương xanh biếc ngọc / Cồn Hến khói mờ ngạt ngào cay',
            desc: 'Được dòng sông Hương ôm ấp chở che, Cồn Hến là cái nôi duy nhất sản sinh ra loài hến nước ngọt béo bùi trứ danh. Món Cơm Hến, Bún Hến cay xé lưỡi kết hợp rau thơm bắp chuối, tóp mỡ giòn rụm và thìa mắm ruốc xào sả ớt đã trở thành linh hồn ẩm thực đất Cố Đô.',
            tips: 'Đừng ngại gọi thêm chén ớt xanh và thìa mắm ruốc xào sả. Ăn cơm hến cay chảy nước mắt rồi húp bát nước luộc hến nóng hổi bốc khói ngào ngạt mới đúng chất thưởng thức của người Huế sành ăn!',
            category: 'dangian',
            gallery: [
                { url: 'images/codo-salad.jpg', caption: 'Hương Vị Cồn Hến Sông Hương - Cái nôi ẩm thực dân dã cay nồng' },
                { url: 'images/codo-banhep.jpg', caption: 'Bánh Ép Huế giòn dai kẹp rau răm chua ngọt' },
                { url: 'images/che.jpg', caption: 'Chè bắp tươi bãi bồi Cồn Hến ngọt mát bờ sông' }
            ],
            products: [
                {
                    id: 11,
                    name: 'Mắm Ruốc Huế Xào Sả Cay',
                    price: '65.000₫',
                    tag: 'Đặc Sản Gốc',
                    meta: 'Ruốc biển tươi ủ men gia truyền xào ớt hiểm & sả thơm',
                    img: 'images/codo-salad.jpg',
                    imgAlt: 'images/codo-salad.jpg',
                    fullDesc: 'Gia vị bất hủ làm nên linh hồn bát bún bò và đĩa cơm hến. Vị mặn mòi, cay ấm nồng nàn thơm nức.'
                },
                {
                    id: 12,
                    name: 'Mắm Nêm Cá Cơm Cố Đô',
                    price: '55.000₫',
                    tag: 'Truyền Thống',
                    meta: 'Cá cơm than đầm phá ủ lu sành theo bí quyết xưa',
                    img: 'images/che.jpg',
                    imgAlt: 'images/che.jpg',
                    fullDesc: 'Mùi thơm đặc trưng, chua mặn vừa vặn, chuẩn vị nêm chấm bánh ướt thịt luộc xứ Huế.'
                }
            ]
        },
        dongba: {
            id: 'dongba',
            name: 'Chợ Đông Ba Cổ Kính',
            tag: 'Quà Biếu & Tinh Hoa Kẹo Mứt',
            icon: '🛍️',
            rating: '★ 4.9 (2.150+ đánh giá)',
            verse: 'Chợ Đông Ba ba tầng lầu chuông đổ / Nhớ miếng mè xửng ngọt ngào tình quê',
            desc: 'Chợ Đông Ba bên bờ sông Hương là trái tim giao thương và ẩm thực sầm uất nhất xứ Thần Kinh từ hơn 120 năm nay. Nơi đây hội tụ từ kẹo mè xửng dẻo quánh vàng ruộm mạch nha, tôm chua đỏ mọng ớt tươi đến những gánh chè hẻm thơm ngát mùi hoa bưởi.',
            tips: 'Mè xửng mua về làm quà nên dùng kèm ấm trà Cung Đình nóng. Vị ngọt dẻo dai bùi bùi của hạt mè quyện cùng vị thanh đắng nhẹ của trà tạo nên phong vị tao nhã không đâu sánh bằng.',
            category: 'quabieu',
            gallery: [
                { url: 'images/spotlight-mexung.jpg', caption: 'Mè Xửng Hoàng Gia - Dẻo thơm hạt mè vàng óng, đậu phộng bùi béo' },
                { url: 'images/products/p4_me_xung.jpg', caption: 'Kẹo mè xửng giòn đặc sản trứ danh O Hương' },
                { url: 'images/che.jpg', caption: 'Quầy chè Hẻm 20 món chợ Đông Ba rực rỡ sắc màu' }
            ],
            products: [
                {
                    id: 4,
                    name: 'Mè Xửng Cung Đình O Hương',
                    price: '40.000₫',
                    tag: 'Quà Tặng',
                    meta: 'Mạch nha kim hoàng, mè rang thơm bùi & đậu phộng tuyển',
                    img: 'images/spotlight-mexung.jpg',
                    imgAlt: 'images/spotlight-mexung.jpg',
                    fullDesc: 'Miếng mè xửng dẻo thơm, ngọt thanh vị mật mía và mạch nha, hạt mè rang vàng ruộm quyện đậu phộng béo bùi.'
                },
                {
                    id: 9,
                    name: 'Tôm Chua Huế Thượng Hạng',
                    price: '85.000₫',
                    tag: 'Đặc Sản O Hương',
                    meta: 'Tôm đất đầm phá lên men tự nhiên với riềng, tỏi, ớt bột',
                    img: 'images/codo-salad.jpg',
                    imgAlt: 'images/codo-salad.jpg',
                    fullDesc: 'Tôm chua có màu đỏ tự nhiên bắt mắt, vị chua cay mặn ngọt hài hòa, ăn kèm thịt luộc bánh tráng ngon trứ danh.'
                }
            ]
        },
        thuyxuan: {
            id: 'thuyxuan',
            name: 'Làng Hương Thủy Xuân & Đồi Vọng Cảnh',
            tag: 'Chè Ngự Thanh Khiết & Bột Lọc Lầu Son',
            icon: '🌿',
            rating: '★ 4.8 (890+ đánh giá)',
            verse: 'Ngát hương trầm bay đồi Vọng Cảnh / Chén chè thanh khiết mát lòng ai',
            desc: 'Dưới chân đồi Vọng Cảnh thơ mộng, làng Thủy Xuân rực rỡ sắc màu của những bó hương trầm và thảo mộc tự nhiên bung tỏa như hoa. Vùng đất thanh tịnh này nổi tiếng với các món chè Cung Đình thanh mát như chè hạt sen long nhãn bọc đường phèn, chè hạt lựu và bột lọc heo quay độc nhất vô nhị.',
            tips: 'Nên thử món chè bột lọc bọc heo quay: lớp bột lọc mềm dai bọc viên thịt quay mặn béo ngậy, đượm trong nước đường phèn thơm thoang thoảng vị gừng cay ấm độc đáo chỉ Huế mới có.',
            category: 'cungdinh',
            gallery: [
                { url: 'images/che.jpg', caption: 'Chè Hạt Sen Nhãn Lồng Cung Đình - Ngọt mát thanh khiết' },
                { url: 'images/codo-main.jpg', caption: 'Mâm tiệc bánh hoa sen dâng yến triều Nguyễn' },
                { url: 'images/products/p3_tra_cung_dinh.jpg', caption: 'Trà sen ướp sương sớm đồi Vọng Cảnh' }
            ],
            products: [
                {
                    id: 15,
                    name: 'Chè Hạt Sen Long Nhãn Cung Đình',
                    price: '38.000₫',
                    tag: 'Thanh Nhiệt',
                    meta: 'Hạt sen Tịnh Tâm lồng trong múi nhãn cùi dày mọng nước',
                    img: 'images/che.jpg',
                    imgAlt: 'images/che.jpg',
                    fullDesc: 'Vị ngọt thanh tao dịu nhẹ của đường phèn, hạt sen bở tơi quyện cùng vị giòn ngọt của nhãn lồng xứ Huế.'
                },
                {
                    id: 16,
                    name: 'Bánh Bột Lọc Bọc Thịt Heo Quay',
                    price: '42.000₫',
                    tag: 'Độc Đáo Cố Đô',
                    meta: 'Bột lọc trong suốt bọc thịt heo quay giòn da ngập sốt gừng',
                    img: 'images/spotlight-banh.jpg',
                    imgAlt: 'images/spotlight-banh.jpg',
                    fullDesc: 'Sự kết hợp kỳ diệu giữa vị béo mặn của thịt heo quay và vị ngọt thanh của nước đường phèn gừng ấm.'
                }
            ]
        },
        baovinh: {
            id: 'baovinh',
            name: 'Phố Cổ Bao Vinh & Đầm Phá Cố Đô',
            tag: 'Bánh Ép Nóng Giòn & Ẩm Thực Đường Phố',
            icon: '🌊',
            rating: '★ 4.9 (1.100+ đánh giá)',
            verse: 'Sông Hương đưa nước về Bao Vinh / Bánh ép giòn thơm thắm nghĩa tình',
            desc: 'Phố cổ Bao Vinh từng là thương cảng sầm uất bậc nhất nối dòng Hương giang ra đầm phá Tam Giang - Cầu Hai. Nơi đây là cái nôi của món bánh ép Huế dẻo thơm kẹp thịt mỡ, trứng gà chấm nước mắm ớt dầm đu đủ chua ngọt khiến bao thế hệ mê đắm.',
            tips: 'Bánh ép ăn ngon nhất khi vừa mới ép nóng hổi trên chảo gang đỏ lửa. Cuộn cùng thật nhiều rau răm, dưa leo xắt mỏng và chấm ngập chén mắm nêm chua ngọt cay xé lưỡi.',
            category: 'dangian',
            gallery: [
                { url: 'images/codo-banhep.jpg', caption: 'Bánh Ép Nóng Giòn Cố Đô - Hương vị đường phố gây nghiện xứ Huế' },
                { url: 'images/spotlight-banh.jpg', caption: 'Bánh nậm gói lá tươi mộc mạc phố cổ' },
                { url: 'images/codo-salad.jpg', caption: 'Gỏi tôm thịt đầm phá chua ngọt thanh mát' }
            ],
            products: [
                {
                    id: 13,
                    name: 'Bánh Ép Cố Đô Giòn Dai',
                    price: '35.000₫',
                    tag: 'Món Hot Giới Trẻ',
                    meta: 'Bột lọc ép nóng chảo gang kẹp thịt mỡ, trứng & hành lá',
                    img: 'images/codo-banhep.jpg',
                    imgAlt: 'images/codo-banhep.jpg',
                    fullDesc: 'Bánh ép thơm phức mùi mỡ hành, chấm sốt mắm ớt tỏi hoặc mắm nêm cay xè, ăn kèm rau răm đu đủ chua giòn tan.'
                },
                {
                    id: 14,
                    name: 'Chả Cua Huế Nấu Bún Bò',
                    price: '90.000₫',
                    tag: 'Đặc Sản Bổ Dưỡng',
                    meta: 'Thịt cua biển phá Tam Giang trộn giò sống quết dẻo',
                    img: 'images/che.jpg',
                    imgAlt: 'images/che.jpg',
                    fullDesc: 'Viên chả cua đỏ gạch tự nhiên, thơm ngọt đậm đà vị cua đầm phá, nấu nước dùng bún bò ngậy béo khó quên.'
                }
            ]
        }
    };

    // QUẢN LÝ ÂM THANH CỐ ĐÔ BẰNG WEB AUDIO API (KHÔNG CẦN TẢI FILE NGOÀI, CHẠY 100% ỔN ĐỊNH)
    let audioCtx = null;
    let isSoundPlaying = false;
    let soundTimer = null;

    function playImperialBellChime() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!audioCtx) {
                audioCtx = new AudioContext();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }

            // Hòa âm ngũ cung chuông chùa Thiên Mụ (E, G, A, B, D)
            const frequencies = [329.63, 392.00, 440.00, 493.88, 587.33];
            const baseFreq = frequencies[Math.floor(Math.random() * frequencies.length)];
            const now = audioCtx.currentTime;

            // 1. Âm thanh chuông Cố Đô vang vọng
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();

            osc.type = 'sine';
            osc.frequency.setValueAtTime(baseFreq, now);
            osc.frequency.exponentialRampToValueAtTime(baseFreq * 0.995, now + 3.5);

            gain.gain.setValueAtTime(0.001, now);
            gain.gain.linearRampToValueAtTime(0.25, now + 0.05);
            gain.gain.exponentialRampToValueAtTime(0.0001, now + 3.5);

            // Bổ sung âm bội harmonic
            const oscHarmonic = audioCtx.createOscillator();
            const gainHarmonic = audioCtx.createGain();
            oscHarmonic.type = 'triangle';
            oscHarmonic.frequency.setValueAtTime(baseFreq * 2.76, now);

            gainHarmonic.gain.setValueAtTime(0.001, now);
            gainHarmonic.gain.linearRampToValueAtTime(0.08, now + 0.04);
            gainHarmonic.gain.exponentialRampToValueAtTime(0.0001, now + 2.0);

            osc.connect(gain);
            gain.connect(audioCtx.destination);

            oscHarmonic.connect(gainHarmonic);
            gainHarmonic.connect(audioCtx.destination);

            osc.start(now);
            oscHarmonic.start(now);

            osc.stop(now + 3.6);
            oscHarmonic.stop(now + 2.1);
        } catch(e) {
            console.log('Web Audio Note:', e);
        }
    }

    function toggleMapSound() {
        const btn = document.getElementById('btnMapSoundToggle');
        const eq = document.getElementById('hudAudioEq');
        const text = document.getElementById('hudAudioText');

        isSoundPlaying = !isSoundPlaying;

        if (isSoundPlaying) {
            if (btn) btn.classList.add('active');
            if (eq) eq.classList.add('playing');
            if (text) text.textContent = 'Đang Ngân Vang';
            playImperialBellChime();
            soundTimer = setInterval(() => {
                if (isSoundPlaying) playImperialBellChime();
            }, 4500);
        } else {
            if (btn) btn.classList.remove('active');
            if (eq) eq.classList.remove('playing');
            if (text) text.textContent = 'Chuông & Nước';
            if (soundTimer) {
                clearInterval(soundTimer);
                soundTimer = null;
            }
        }
    }

    // THUYẾT MINH GIỌNG ĐỌC CỐ ĐÔ (AUDIO GUIDE)
    let isNarrating = false;
    function toggleAudioGuide(spotId) {
        const btn = document.getElementById('btnAudioGuide');
        const label = document.getElementById('audioGuideLabel');
        const spot = HUE_SPOTS[spotId] || HUE_SPOTS.dainoi;

        if (!isNarrating) {
            // Khởi động thuyết minh
            isNarrating = true;
            if (btn) btn.classList.add('playing');
            if (label) label.textContent = 'Đang Thuyết Minh... (Bấm để Dừng)';
            playImperialBellChime();

            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const textToSpeak = `${spot.name}. ${spot.tag}. ${spot.verse}. ${spot.desc}`;
                const utterance = new SpeechSynthesisUtterance(textToSpeak);
                utterance.lang = 'vi-VN';
                utterance.rate = 0.92; // Giọng đọc chậm rãi, truyền cảm
                utterance.pitch = 1.05;

                utterance.onend = function() {
                    isNarrating = false;
                    if (btn) btn.classList.remove('playing');
                    if (label) label.textContent = 'Nghe Thuyết Minh (Giọng Huế Di Sản)';
                };
                utterance.onerror = function() {
                    isNarrating = false;
                    if (btn) btn.classList.remove('playing');
                    if (label) label.textContent = 'Nghe Thuyết Minh (Giọng Huế Di Sản)';
                };

                window.speechSynthesis.speak(utterance);
            }
        } else {
            // Dừng thuyết minh
            isNarrating = false;
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
            }
            if (btn) btn.classList.remove('playing');
            if (label) label.textContent = 'Nghe Thuyết Minh (Giọng Huế Di Sản)';
        }
    }

    // CẬP NHẬT GIAO DIỆN KHI CHỌN MỘT ĐỊA DANH
    function updateLandmarkView(spotId, playBell) {
        const spot = HUE_SPOTS[spotId];
        if (!spot) return;

        if (playBell) {
            playImperialBellChime();
        }

        // Cập nhật trạng thái active của Pin trên SVG
        document.querySelectorAll('.hue-map-pin, .hue-map-pin-group').forEach(el => {
            if (el.getAttribute('data-spot') === spotId) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');
            }
        });

        // Cập nhật Quick Jump Strip
        document.querySelectorAll('.hue-quick-jump-chip').forEach(chip => {
            if (chip.getAttribute('data-jump') === spotId) {
                chip.classList.add('active');
            } else {
                chip.classList.remove('active');
            }
        });

        // Dừng thuyết minh cũ nếu đang đọc
        if (isNarrating && 'speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            isNarrating = false;
            const btn = document.getElementById('btnAudioGuide');
            const label = document.getElementById('audioGuideLabel');
            if (btn) btn.classList.remove('playing');
            if (label) label.textContent = 'Nghe Thuyết Minh (Giọng Huế Di Sản)';
        }

        // Cập nhật Thẻ Chi Tiết Landmark Card
        const iconEl = document.getElementById('mapDetailIcon');
        const tagEl = document.getElementById('mapDetailTag');
        const titleEl = document.getElementById('mapDetailTitle');
        const ratingEl = document.getElementById('mapDetailRating');
        const photoEl = document.getElementById('mapDetailPhoto');
        const captionEl = document.getElementById('mapPhotoCaption');
        const verseEl = document.getElementById('mapDetailVerse');
        const descEl = document.getElementById('mapDetailDesc');
        const tipsEl = document.getElementById('mapDetailTips');
        const thumbsEl = document.getElementById('mapGalleryThumbs');
        const gridEl = document.getElementById('mapDishesGrid');

        if (iconEl) iconEl.textContent = spot.icon;
        if (tagEl) tagEl.textContent = spot.tag;
        if (titleEl) titleEl.textContent = spot.name;
        if (ratingEl) ratingEl.textContent = spot.rating || '★ 4.9 (1.000+ đánh giá)';
        if (verseEl) verseEl.textContent = `"${spot.verse}"`;

        // Đổi ảnh chính
        const primaryImg = (spot.gallery && spot.gallery.length > 0) ? spot.gallery[0] : { url: spot.photo, caption: spot.photoCaption };
        if (photoEl) {
            photoEl.src = getAssetUrl(primaryImg.url);
            photoEl.alt = spot.name;
        }
        if (captionEl) captionEl.textContent = primaryImg.caption;

        // Render Dải Thumbnails Ảnh Chân Thực
        if (thumbsEl && spot.gallery && spot.gallery.length > 0) {
            thumbsEl.innerHTML = spot.gallery.map((item, idx) => `
                <div class="hue-gallery-thumb-item hue-thumb-item ${idx === 0 ? 'active' : ''}" data-idx="${idx}" title="${item.caption}">
                    <img src="${getAssetUrl(item.url)}" alt="${item.caption}" loading="lazy">
                </div>
            `).join('');

            thumbsEl.querySelectorAll('.hue-gallery-thumb-item, .hue-thumb-item').forEach(thumb => {
                thumb.addEventListener('click', function() {
                    thumbsEl.querySelectorAll('.hue-gallery-thumb-item, .hue-thumb-item').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    const idx = parseInt(this.getAttribute('data-idx')) || 0;
                    const selected = spot.gallery[idx];
                    if (photoEl && selected) photoEl.src = getAssetUrl(selected.url);
                    if (captionEl && selected) captionEl.textContent = selected.caption;
                });
            });
        }

        // Nội dung Giai thoại
        if (descEl) {
            descEl.innerHTML = `
                <p style="font-size: 15px; line-height: 1.8; color: #ebd7be; margin-bottom: 12px;">
                    ${spot.desc}
                </p>
                <div style="padding: 12px 16px; background: rgba(212, 175, 55, 0.08); border-left: 3px solid #d4af37; border-radius: 6px; font-size: 13.5px; color: #ffd700;">
                    📜 <em>Giai thoại cố đô ghi chép: Địa danh này là nơi hội tụ các nghệ nhân bếp cung đình và dân gian, lưu truyền công thức bí truyền qua nhiều thế hệ.</em>
                </div>
            `;
        }

        // Nội dung Bí quyết thưởng thức
        if (tipsEl) {
            tipsEl.innerHTML = `
                <p style="font-size: 15px; line-height: 1.8; color: #ebd7be; margin-bottom: 12px;">
                    ${spot.tips || 'Hãy thưởng thức chậm rãi để cảm nhận từng tầng hương vị đặc trưng của vùng đất Cố Đô.'}
                </p>
                <div style="padding: 12px 16px; background: rgba(34, 197, 94, 0.08); border-left: 3px solid #22c55e; border-radius: 6px; font-size: 13.5px; color: #86efac;">
                    💡 <strong>Mẹo chuẩn vị O Hương:</strong> Đặt món tươi nóng trực tiếp từ bếp gia truyền để giữ trọn vẹn hương vị tinh túy nhất.
                </div>
            `;
        }

        // Render Danh sách món ăn
        if (gridEl) {
            gridEl.innerHTML = spot.products.map(p => `
                <div class="hue-dish-card">
                    <div class="hue-dish-photo-wrap hue-dish-thumb-box" onclick="openPhotoLightbox('${p.name.replace(/'/g, "\\'")}', '${getAssetUrl(p.img)}', '${p.fullDesc.replace(/'/g, "\\'")}', '${p.price}', '${p.tag}')">
                        <img src="${getAssetUrl(p.img)}" alt="${p.name}" class="hue-dish-photo hue-dish-thumb" loading="lazy">
                        <span class="hue-dish-tag">${p.tag}</span>
                    </div>
                    <div class="hue-dish-content hue-dish-info">
                        <h4 class="hue-dish-name" onclick="openPhotoLightbox('${p.name.replace(/'/g, "\\'")}', '${getAssetUrl(p.img)}', '${p.fullDesc.replace(/'/g, "\\'")}', '${p.price}', '${p.tag}')">${p.name}</h4>
                        <div class="hue-dish-meta">${p.meta}</div>
                        <div class="hue-dish-price-row">
                            <span class="hue-dish-price">${p.price}</span>
                        </div>
                    </div>
                    <button type="button" class="hue-dish-btn-add" onclick="orderDishAjax(${p.id}, '${p.name.replace(/'/g, "\\'")}')" title="Thêm vào giỏ">
                        🛒 Đặt Món
                    </button>
                </div>
            `).join('');
        }
    }

    // XỬ LÝ THÊM VÀO GIỎ HÀNG
    window.orderDishAjax = function(prodId, prodName) {
        if (typeof window.addCartAjax === 'function') {
            window.addCartAjax(prodId, prodName);
        } else {
            var cart = [];
            try { cart = JSON.parse(localStorage.getItem('ohx_cart')) || []; } catch(e){}
            var existing = cart.find(i => i.id == prodId);
            if (existing) {
                existing.quantity = (parseInt(existing.quantity) || 1) + 1;
            } else {
                cart.push({ id: prodId, name: prodName, price: '45.000₫', quantity: 1, image: getAssetUrl('images/products/p1_banh_beo_nam_loc.jpg') });
            }
            localStorage.setItem('ohx_cart', JSON.stringify(cart));
            if (typeof window.updateCartBadge === 'function') window.updateCartBadge();
            alert('Đã thêm "' + prodName + '" vào giỏ hàng O Hương Xứ Huế!');
        }
    };

    // MODAL LIGHTBOX XEM ẢNH PHÓNG TO
    window.openPhotoLightbox = function(title, imgSrc, desc, price, tag) {
        let modal = document.getElementById('huePhotoLightbox');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'huePhotoLightbox';
            modal.className = 'hue-lightbox-modal';
            modal.innerHTML = `
                <div class="hue-lightbox-content">
                    <button type="button" class="hue-lightbox-close" onclick="closePhotoLightbox()">✕</button>
                    <div class="hue-lightbox-img-box">
                        <img id="lightboxImg" src="" alt="" class="hue-lightbox-img">
                    </div>
                    <div class="hue-lightbox-body">
                        <h3 id="lightboxTitle" class="hue-lightbox-title"></h3>
                        <p id="lightboxDesc" class="hue-lightbox-desc"></p>
                        <div class="hue-lightbox-footer">
                            <span id="lightboxPrice" style="font-size: 18px; font-weight: 800; color: #ffd700;"></span>
                            <button type="button" class="hue-dish-btn-add" id="lightboxBtnOrder">
                                🛒 Thêm Vào Giỏ Hàng
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);

            modal.addEventListener('click', (e) => {
                if (e.target === modal) closePhotoLightbox();
            });
        }

        const imgEl = document.getElementById('lightboxImg');
        const titleEl = document.getElementById('lightboxTitle');
        const descEl = document.getElementById('lightboxDesc');
        const priceEl = document.getElementById('lightboxPrice');
        const orderBtn = document.getElementById('lightboxBtnOrder');

        if (imgEl) imgEl.src = imgSrc;
        if (titleEl) titleEl.textContent = title;
        if (descEl) descEl.textContent = desc;
        if (priceEl) priceEl.textContent = price;

        if (orderBtn) {
            orderBtn.onclick = function() {
                orderDishAjax(99, title);
                closePhotoLightbox();
            };
        }

        modal.classList.add('is-open');
    };

    window.closePhotoLightbox = function() {
        const modal = document.getElementById('huePhotoLightbox');
        if (modal) modal.classList.remove('is-open');
    };

    // BỘ LỌC PHÂN VÙNG
    function initFilters() {
        const pills = document.querySelectorAll('.hue-filter-pill');
        pills.forEach(pill => {
            pill.addEventListener('click', () => {
                pills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');

                const filter = pill.getAttribute('data-filter');
                document.querySelectorAll('.hue-map-pin, .hue-map-pin-group').forEach(pin => {
                    const spotKey = pin.getAttribute('data-spot');
                    const spot = HUE_SPOTS[spotKey];
                    if (filter === 'all' || (spot && spot.category === filter)) {
                        pin.style.opacity = '1';
                        pin.style.pointerEvents = 'auto';
                    } else {
                        pin.style.opacity = '0.2';
                        pin.style.pointerEvents = 'none';
                    }
                });

                const firstMatch = document.querySelector('.hue-map-pin[style*="opacity: 1"], .hue-map-pin-group[style*="opacity: 1"]');
                if (firstMatch) {
                    const id = firstMatch.getAttribute('data-spot');
                    if (id) updateLandmarkView(id, false);
                }
            });
        });
    }

    // GÁN CLICK CHO CÁC PIN TRÊN BẢN ĐỒ SVG
    function initMapPins() {
        document.querySelectorAll('.hue-map-pin, .hue-map-pin-group').forEach(pin => {
            pin.addEventListener('click', function() {
                const spotId = this.getAttribute('data-spot');
                if (spotId) updateLandmarkView(spotId, true);
            });
        });

        // Nút xem ảnh phong cảnh lớn
        const btnViewLandscape = document.getElementById('btnViewLandscape');
        if (btnViewLandscape) {
            btnViewLandscape.addEventListener('click', () => {
                const activePin = document.querySelector('.hue-map-pin.active, .hue-map-pin-group.active');
                const spotId = activePin ? activePin.getAttribute('data-spot') : 'dainoi';
                const spot = HUE_SPOTS[spotId];
                if (spot) {
                    const primary = (spot.gallery && spot.gallery.length > 0) ? spot.gallery[0] : { url: spot.photo, caption: spot.photoCaption };
                    openPhotoLightbox(spot.name, getAssetUrl(primary.url), spot.desc, 'Di Sản Cố Đô', spot.tag);
                }
            });
        }
    }

    // THANH QUICK JUMP CHIPS
    function initQuickJump() {
        document.querySelectorAll('.hue-quick-jump-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                const spotId = this.getAttribute('data-jump');
                if (spotId) {
                    updateLandmarkView(spotId, true);
                }
            });
        });
    }

    // HỆ THỐNG 3 TABS (Món ăn / Giai thoại / Bí quyết)
    function initTabs() {
        const tabBtns = document.querySelectorAll('.hue-tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                tabBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const targetTab = this.getAttribute('data-tab');
                document.querySelectorAll('.hue-tab-pane').forEach(pane => {
                    pane.classList.remove('active');
                });

                if (targetTab === 'dishes') {
                    const p = document.getElementById('paneDishes');
                    if (p) p.classList.add('active');
                } else if (targetTab === 'story') {
                    const p = document.getElementById('paneStory');
                    if (p) p.classList.add('active');
                } else if (targetTab === 'tips') {
                    const p = document.getElementById('paneTips');
                    if (p) p.classList.add('active');
                }
            });
        });
    }

    // THANH ĐIỀU KHIỂN HUD TOOLBAR (TÌM KIẾM, ĐỔI CHẾ ĐỘ ÁNH SÁNG, ÂM THANH, TOÀN CẢNH)
    function initHudControls() {
        // 1. Chuyển đổi chế độ ánh sáng (Đêm Hội / Hoàng Hôn / Sớm Mai)
        const livingContainer = document.getElementById('livingMapContainer');
        const themeBtns = document.querySelectorAll('.hue-hud-btn[data-theme]');
        themeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                themeBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const theme = this.getAttribute('data-theme');
                if (livingContainer) {
                    livingContainer.setAttribute('data-theme', theme);
                }
            });
        });

        // 2. Tìm kiếm thông minh địa danh & món ăn
        const searchInput = document.getElementById('mapSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                if (!query) {
                    // Hiện lại tất cả
                    document.querySelectorAll('.hue-map-pin, .hue-map-pin-group').forEach(pin => {
                        pin.style.opacity = '1';
                        pin.style.pointerEvents = 'auto';
                    });
                    return;
                }

                let firstMatchedSpot = null;
                document.querySelectorAll('.hue-map-pin, .hue-map-pin-group').forEach(pin => {
                    const spotKey = pin.getAttribute('data-spot');
                    const spot = HUE_SPOTS[spotKey];
                    let matched = false;

                    if (spot) {
                        if (spot.name.toLowerCase().includes(query) || spot.tag.toLowerCase().includes(query)) {
                            matched = true;
                        }
                        if (spot.products && spot.products.some(p => p.name.toLowerCase().includes(query))) {
                            matched = true;
                        }
                    }

                    if (matched) {
                        pin.style.opacity = '1';
                        pin.style.pointerEvents = 'auto';
                        if (!firstMatchedSpot) firstMatchedSpot = spotKey;
                    } else {
                        pin.style.opacity = '0.15';
                        pin.style.pointerEvents = 'none';
                    }
                });

                if (firstMatchedSpot) {
                    updateLandmarkView(firstMatchedSpot, false);
                }
            });
        }

        // 3. Âm thanh chuông Cố Đô
        const soundBtn = document.getElementById('btnMapSoundToggle');
        if (soundBtn) {
            soundBtn.addEventListener('click', toggleMapSound);
        }

        // 4. Thuyết minh Audio Guide
        const audioGuideBtn = document.getElementById('btnAudioGuide');
        if (audioGuideBtn) {
            audioGuideBtn.addEventListener('click', function() {
                const activePin = document.querySelector('.hue-map-pin.active, .hue-map-pin-group.active');
                const spotId = activePin ? activePin.getAttribute('data-spot') : 'dainoi';
                toggleAudioGuide(spotId);
            });
        }

        // 5. Đặt lại góc nhìn toàn cảnh (Reset)
        const resetBtn = document.getElementById('btnMapReset');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                document.querySelectorAll('.hue-map-pin, .hue-map-pin-group').forEach(pin => {
                    pin.style.opacity = '1';
                    pin.style.pointerEvents = 'auto';
                });
                document.querySelectorAll('.hue-filter-pill').forEach(p => p.classList.remove('active'));
                const allPill = document.querySelector('.hue-filter-pill[data-filter="all"]');
                if (allPill) allPill.classList.add('active');
                updateLandmarkView('dainoi', true);
            });
        }
    }

    function initAll() {
        initFilters();
        initMapPins();
        initQuickJump();
        initTabs();
        initHudControls();
        updateLandmarkView('dainoi', false);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
