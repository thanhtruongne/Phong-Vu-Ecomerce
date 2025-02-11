import './bootstrap';
Echo.channel('notifications')
    .listen('NotificationSent', (event) => {
        console.log('New notification:', event.message);
        // Hiển thị thông báo trên giao diện người dùng
    });
