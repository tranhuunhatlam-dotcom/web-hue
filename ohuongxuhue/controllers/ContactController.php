<?php
/**
 * Controller quản lý trang Liên hệ & Hỗ trợ khách hàng (ContactController)
 */

class ContactController extends BaseController {
    public function index() {
        $successMessage = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name    = sanitize_text_field($_POST['fullname'] ?? '');
            $phone   = sanitize_text_field($_POST['phone'] ?? '');
            $subject = sanitize_text_field($_POST['subject'] ?? '');
            $message = sanitize_textarea_field($_POST['message'] ?? '');

            if (!empty($name) && !empty($phone)) {
                $successMessage = 'Cảm ơn quý khách ' . htmlspecialchars($name) . '! Lời nhắn của bạn đã được gửi thành công. Đội ngũ O Hương Xứ Huế sẽ liên hệ lại trong thời gian sớm nhất!';
            }
        }

        $this->render('contact/index', [
            'pageTitle'      => 'Liên Hệ Với O Hương Xứ Huế - Đặt Hàng & Tư Vấn Quà Biếu',
            'currentNav'     => 'contact',
            'successMessage' => $successMessage
        ]);
    }
}
