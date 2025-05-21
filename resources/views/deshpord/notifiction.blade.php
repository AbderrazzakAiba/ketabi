<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إدارة الإشعارات | منصة كتابي</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4F46E5;
      --secondary-color: #423add;
      --text-color: #30382F;
      --light-bg: #f5f7fa;
      --success-color: #28a745;
      --danger-color: #dc3545;
    }

    body {
      font-family: 'Tajawal', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--light-bg);
      color: var(--text-color);
    }

    /* التصميم متطابق تماماً مع صفحة إدارة الحسابات */
    .sidebar {
      width: 250px;
      background-color: white;
      position: fixed;
      top: 0;
      right: 0;
      height: 100vh;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 20px 0;
    }

    .sidebar-header {
      text-align: center;
      padding: 20px;
      border-bottom: 1px solid #bbadad;
      margin-bottom: 20px;
    }

    .sidebar-title {
      color: var(--primary-color);
      margin: 10px 0 0;
    }

    .nav-links {
      list-style: none;
      padding: 0;
    }

    .nav-links li a {
      display: block;
      padding: 12px 25px;
      color: var(--text-color);
      text-decoration: none;
      transition: all 0.3s;
      font-weight: bold;
    }

    .nav-links li a:hover,
    .nav-links li a.active {
      background-color: var(--light-bg);
      color: var(--primary-color);
      border-right: 4px solid var(--primary-color);
    }

    .nav-links li a i {
      margin-left: 10px;
      width: 20px;
      text-align: center;
    }

    .main-content {
      margin-right: 250px;
      padding: 30px;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title {
      color: var(--primary-color);
      margin: 0;
    }

    /* كروت الإشعارات بنفس نمط جدول الحسابات */
    .notifications-container {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      overflow: hidden;
    }

    .notification-item {
      padding: 15px 20px;
      border-bottom: 1px solid #eee;
      transition: all 0.3s;
    }

    .notification-item.unread {
      background-color: #f8f9fe;
      border-right: 3px solid var(--primary-color);
    }

    .notification-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .notification-title {
      font-weight: bold;
      color: var(--primary-color);
    }

    .notification-time {
      color: #777;
      font-size: 14px;
    }

    .notification-content {
      margin-bottom: 10px;
    }

    .notification-recipient {
      font-size: 14px;
      color: #555;
    }

    .notification-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    .action-btn {
      padding: 5px 10px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-family: 'Tajawal';
      font-size: 14px;
    }

    .mark-read-btn {
      background-color: #e2e3e5;
      color: #b9c1c7;
    }

    .delete-btn {
      background-color: #f8d7da;
      color: var(--danger-color);
    }

    /* نموذج الإرسال */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
      background-color: white;
      margin: 5% auto;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      max-width: 700px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .close-btn {
      float: left;
      font-size: 24px;
      cursor: pointer;
      color: #a4a4a4;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: 'Tajawal';
    }

    textarea.form-control {
      min-height: 120px;
    }

    /* قائمة المستخدمين */
    .users-list {
      max-height: 300px;
      overflow-y: auto;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .user-item {
      padding: 10px;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
    }

    .user-item:last-child {
      border-bottom: none;
    }

    .user-checkbox {
      margin-left: 10px;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-left: 10px;
    }

    .user-details {
      flex: 1;
    }

    .user-name {
      font-weight: bold;
    }

    .user-email {
      font-size: 14px;
      color: #666;
    }

    .user-type {
      display: inline-block;
      padding: 2px 8px;
      font-size: 12px;
      border-radius: 10px;
      background-color: #e9ecef;
      margin-left: 10px;
    }

    /* أزرار التحكم */
    .add-btn {
      background-color: var(--primary-color);
      color: white;
      padding: 8px 15px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-family: 'Tajawal';
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .send-btn {
      background-color: var(--success-color);
      color: white;
      padding: 8px 20px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-family: 'Tajawal';
    }

    /* رسائل التنبيه */
    .alert {
      padding: 10px 15px;
      margin-bottom: 15px;
      border-radius: 4px;
      text-align: center;
    }

    .alert-success {
      background-color: #d4edda;
      color: var(--success-color);
    }

    .alert-danger {
      background-color: #f8d7da;
      color: var(--danger-color);
    }
  </style>
</head>
<body>
  <!-- الشريط الجانبي المطابق لصفحة الحسابات -->
  <div class="sidebar">
    <div class="sidebar-header">
      <i class="fas fa-bell" style="font-size: 30px; color: var(--primary-color);"></i>
      <h3 class="sidebar-title">لوحة التحكم</h3>
    </div>
    <ul class="nav-links">
      <li><a href="gerelbbok.html"><i class="fas fa-book"></i> إدارة الكتب</a></li>
      <li><a href="manage-accounts.html"><i class="fas fa-users"></i> إدارة الحسابات</a></li>
      <li><a href="messag.html"class="active"><i class="fas fa-bell"></i> الإشعارات</a></li>
      <li><a href="registerloan.html" ><i class="fas fa-history"></i> سجل الإعارة</a></li>
    <li><a href="ordermang.html" ><i class="fas fa-calendar-plus"></i> طلبات التمديد</a></li>
    <li><a href="DAR-AINasher.html"><i class="fas fa-building"></i> دور النشر</a></li>
  </ul>
  </div>

  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <div class="page-header">
      <h1 class="page-title">إدارة الإشعارات</h1>
      <button onclick="openSendModal()" class="add-btn">
        <i class="fas fa-paper-plane"></i> إرسال إشعار
      </button>
    </div>

    <div id="alertMessage" style="display: none;"></div>

    <div class="notifications-container" id="notificationsList">
      <!-- سيتم ملؤها من قاعدة البيانات -->
    </div>
  </div>

  <!-- نموذج إرسال إشعار جديد -->
  <div id="sendModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 20px;">إرسال إشعار جديد</h2>

      <form id="notificationForm">
        <div class="form-group">
          <label>اختيار المستلمين</label>
          <input type="text" id="userSearch" class="form-control" placeholder="ابحث عن مستخدم..." oninput="filterUsers()">

          <div class="users-list" id="usersList">
            <!-- سيتم ملؤها من JavaScript -->
          </div>
        </div>

        <div class="form-group">
          <label for="notificationTitle">عنوان الإشعار</label>
          <input type="text" id="notificationTitle" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="notificationMessage">محتوى الإشعار</label>
          <textarea id="notificationMessage" class="form-control" required></textarea>
        </div>

        <div class="form-actions" style="text-align: center;">
          <button type="submit" class="send-btn">
            <i class="fas fa-paper-plane"></i> إرسال الإشعارات
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // بيانات المستخدمين (سيتم جلبها من صفحة إدارة الحسابات)
    let allUsers = [];
    let notifications = [];

    // جلب بيانات المستخدمين من نظام الحسابات
    async function fetchUsers() {
      try {
        const response = await fetch('/api/users');
        const data = await response.json();

        // تحويل البيانات لتتناسب مع نظام الإشعارات
        allUsers = data.map(user => ({
          id: user.id,
          name: `${user.firstName} ${user.lastName}`,
          email: user.email,
          type: getUserTypeArabic(user.userType),
          avatar: user.photo || 'https://via.placeholder.com/40',
          isActive: user.status === 'active'
        }));

        renderUserList(allUsers);
      } catch (error) {
        console.error('حدث خطأ أثناء جلب المستخدمين:', error);
        showAlert('حدث خطأ أثناء جلب بيانات المستخدمين', 'danger');
      }
    }

    // جلب الإشعارات من قاعدة البيانات
    async function fetchNotifications() {
      try {
        const response = await fetch('/api/notifications');
        notifications = await response.json();
        renderNotifications();
      } catch (error) {
        console.error('حدث خطأ أثناء جلب الإشعارات:', error);
        showAlert('حدث خطأ أثناء جلب الإشعارات', 'danger');
      }
    }

    // عرض قائمة المستخدمين
    function renderUserList(users) {
      const container = document.getElementById('usersList');
      container.innerHTML = '';

      if (users.length === 0) {
        container.innerHTML = '<p style="text-align: center; padding: 20px;">لا يوجد مستخدمين</p>';
        return;
      }

      users.forEach(user => {
        const userItem = document.createElement('div');
        userItem.className = 'user-item';
        userItem.innerHTML = `
          <input type="checkbox" class="user-checkbox"
                 id="user-${user.id}"
                 value="${user.id}"
                 data-email="${user.email}"
                 ${user.isActive ? '' : 'disabled'}>
          <img src="${user.avatar}" alt="صورة المستخدم" class="user-avatar">
          <div class="user-details">
            <div>
              <span class="user-name">${user.name}</span>
              <span class="user-type">${user.type}</span>
            </div>
            <div class="user-email">${user.email}</div>
          </div>
        `;
        container.appendChild(userItem);
      });
    }

    // تصفية المستخدمين حسب البحث
    function filterUsers() {
      const searchTerm = document.getElementById('userSearch').value.toLowerCase();
      const filteredUsers = allUsers.filter(user =>
        user.name.toLowerCase().includes(searchTerm) ||
        user.email.toLowerCase().includes(searchTerm)
      );
      renderUserList(filteredUsers);
    }

    // تحويل نوع المستخدم للعربية
    function getUserTypeArabic(type) {
      const types = {
        'employer': 'موظف',
        'professor': 'أستاذ',
        'student': 'طالب',
        'admin': 'مدير'
      };
      return types[type] || type;
    }

    // إرسال الإشعارات
    document.getElementById('notificationForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const title = document.getElementById('notificationTitle').value;
      const message = document.getElementById('notificationMessage').value;

      // جمع المستلمين المحددين
      const recipients = [];
      document.querySelectorAll('.user-checkbox:checked').forEach(checkbox => {
        recipients.push({
          id: checkbox.value,
          email: checkbox.dataset.email
        });
      });

      if (recipients.length === 0) {
        showAlert('الرجاء تحديد مستلم واحد على الأقل', 'danger');
        return;
      }

      try {
        // إرسال البيانات إلى الخادم
        const response = await fetch('/api/send-notifications', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ title, message, recipients })
        });

        const result = await response.json();

        if (result.success) {
          showAlert(`تم إرسال الإشعار إلى ${recipients.length} مستخدم`, 'success');
          closeModal();
          fetchNotifications(); // تحديث قائمة الإشعارات
        } else {
          showAlert('حدث خطأ أثناء إرسال الإشعارات', 'danger');
        }
      } catch (error) {
        console.error('حدث خطأ:', error);
        showAlert('فشل في إرسال الإشعارات', 'danger');
      }
    });

    // عرض الإشعارات
    function renderNotifications() {
      const container = document.getElementById('notificationsList');
      container.innerHTML = '';

      if (notifications.length === 0) {
        container.innerHTML = `
          <div style="text-align: center; padding: 40px;">
            <i class="fas fa-bell-slash" style="font-size: 50px; color: #ccc;"></i>
            <p>لا توجد إشعارات لعرضها</p>
          </div>
        `;
        return;
      }

      notifications.forEach(notification => {
        const notificationItem = document.createElement('div');
        notificationItem.className = `notification-item ${notification.isRead ? '' : 'unread'}`;
        notificationItem.innerHTML = `
          <div class="notification-header">
            <div class="notification-title">${notification.title}</div>
            <div class="notification-time">${formatDate(notification.createdAt)}</div>
          </div>
          <div class="notification-content">${notification.message}</div>
          <div class="notification-recipient">إلى: ${notification.recipientEmail}</div>
          <div class="notification-actions">
            <button class="action-btn mark-read-btn" onclick="toggleReadStatus(${notification.id}, ${!notification.isRead})">
              ${notification.isRead ? 'تعيين كغير مقروء' : 'تعيين كمقروء'}
            </button>
            <button class="action-btn delete-btn" onclick="deleteNotification(${notification.id})">
              حذف
            </button>
          </div>
        `;
        container.appendChild(notificationItem);
      });
    }

    // تغيير حالة القراءة
    async function toggleReadStatus(id, isRead) {
      try {
        const response = await fetch(`/api/notifications/${id}`, {
          method: 'PATCH',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ isRead })
        });

        if (response.ok) {
          fetchNotifications(); // تحديث القائمة
        }
      } catch (error) {
        console.error('حدث خطأ:', error);
      }
    }

    // حذف إشعار
    async function deleteNotification(id) {
      if (confirm('هل أنت متأكد من حذف هذا الإشعار؟')) {
        try {
          const response = await fetch(`/api/notifications/${id}`, {
            method: 'DELETE'
          });

          if (response.ok) {
            showAlert('تم حذف الإشعار بنجاح', 'success');
            fetchNotifications(); // تحديث القائمة
          }
        } catch (error) {
          console.error('حدث خطأ:', error);
        }
      }
    }

    // تنسيق التاريخ
    function formatDate(dateString) {
      const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      };
      return new Date(dateString).toLocaleDateString('ar-EG', options);
    }

    // فتح وإغلاق النموذج
    function openSendModal() {
      document.getElementById('sendModal').style.display = 'block';
      fetchUsers(); // جلب أحدث بيانات المستخدمين
    }

    function closeModal() {
      document.getElementById('sendModal').style.display = 'none';
    }

    // عرض رسالة تنبيه
    function showAlert(message, type) {
      const alertBox = document.getElementById('alertMessage');
      alertBox.style.display = 'block';
      alertBox.className = `alert alert-${type}`;
      alertBox.innerText = message;
      setTimeout(() => {
        alertBox.style.display = 'none';
      }, 3000);
    }

    // تحميل البيانات عند فتح الصفحة
    window.onload = function() {
      fetchNotifications();
    };
  </script>
</body>
</html>
