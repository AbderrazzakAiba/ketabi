<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إدارة الحسابات | منصة كتابي</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4F46E5;
      --secondary-color: #423add;
      --text-color: #30382F;
      --light-bg: #f5f7fa;
    }
    body {
      height: 100%;
      overflow: auto;
      font-family: 'Tajawal', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--light-bg);
      color: var(--text-color);
    }
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
      border-bottom: 1px solid #eee;
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
    .accounts-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 30px;
    }
    .accounts-table th, .accounts-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    .accounts-table th {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
    }
    .accounts-table tr:hover {
      background-color: #f9f9f9;
    }
    .action-btn {
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Tajawal';
      margin: 0 3px;
    }
    .edit-btn {
      background-color: #28a745;
      color: white;
    }
    .delete-btn {
      background-color: #dc3545;
      color: white;
    }
    .notify-btn {
      background-color: #f59e42;
      color: white;
    }
    .add-btn {
      background-color: var(--primary-color);
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    .action-btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      overflow: auto;
    }
    .modal-content {
      background-color: white;
      margin: 5% auto;
      padding: 25px;
      border-radius: 8px;
      width: 80%;
      max-width: 600px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .close-btn {
      float: left;
      font-size: 24px;
      cursor: pointer;
      color: #aaa;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    .form-group input, 
    .form-group select, 
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: 'Tajawal';
    }
    .form-actions {
      text-align: center;
      margin-top: 20px;
    }
    .save-btn {
      background-color: var(--primary-color);
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-family: 'Tajawal';
      font-weight: bold;
    }
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
      text-align: center;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
    footer {
      text-align: center;
      padding: 20px;
      background-color: var(--primary-color);
      color: white;
      margin-right: 250px;
    }
    .user-type-section {
      display: none;
    }
  </style>
</head>
<body>
  <!-- الشريط الجانبي -->
  <div class="sidebar">
    <div class="sidebar-header">
      <i class="fas fa-book" style="font-size: 30px; color: var(--primary-color);"></i>
      <h3 class="sidebar-title">لوحة التحكم</h3>
    </div>
    <ul class="nav-links">
      <li><a href="gerelbbok.html"><i class="fas fa-book"></i> إدارة الكتب</a></li>
      <li><a href="manage-accounts.html" class="active"><i class="fas fa-users"></i> إدارة الحسابات</a></li>
      <li><a href="messag.html"><i class="fas fa-bell"></i> الإشعارات</a></li>
      <li><a href="registerloan.html"><i class="fas fa-history"></i> سجل الإعارة</a></li>
      <li><a href="ordermang.html"><i class="fas fa-calendar-plus"></i> طلبات التمديد</a></li>
      <li><a href="barren.html"><i class="fas fa-clipboard-check"></i> جرد </a></li>
      <li><a href="DAR-AINasher.html"><i class="fas fa-building"></i> دور النشر</a></li>
      <li><a href="book-requests.html"><i class="fas fa-clipboard-list"></i> طلبات توفير الكتب</a></li>
      <li><a href="approved-books.html"><i class="fas fa-check-circle"></i> الموافقة على الكتب</a></li>
    </ul>
  </div>

  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <div class="page-header">
      <h1 class="page-title">إدارة الحسابات</h1>
      <button onclick="openAddModal()" class="add-btn">
        <i class="fas fa-plus"></i> إضافة حساب جديد
      </button>
    </div>

    <div id="alertMessage" style="display: none;"></div>

    <table class="accounts-table">
      <thead>
        <tr>
          <th>#</th>
          <th>الصورة</th>
          <th>الاسم</th>
          <th>البريد الإلكتروني</th>
          <th>نوع الحساب</th>
          <th>الهاتف</th>
          <th>الإجراءات</th>
        </tr>
      </thead>
      <tbody id="accountsTableBody">
        <!-- سيتم ملء الجدول من خلال JavaScript -->
      </tbody>
    </table>
  </div>

  <!-- نموذج إضافة/تعديل حساب -->
  <div id="accountModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2 style="text-align: center; color: var(--primary-color);" id="modalTitle">إضافة حساب جديد</h2>
      
      <form id="accountForm">
        <input type="hidden" id="accountId">
        
        <div class="form-group">
          <label for="userType">نوع المستخدم</label>
          <select id="userType" onchange="showUserTypeFields()" required>
            <option value="" selected disabled>اختر نوع المستخدم</option>
            <option value="employer">موظف</option>
            <option value="professor">أستاذ</option>
            <option value="student">طالب</option>
          </select>
        </div>

        <div class="form-group">
          <label for="firstName">الاسم الأول</label>
          <input type="text" id="firstName" required>
        </div>

        <div class="form-group">
          <label for="lastName">الاسم الأخير</label>
          <input type="text" id="lastName" required>
        </div>

        <div class="form-group">
          <label for="email">البريد الإلكتروني</label>
          <input type="email" id="email" required>
        </div>

        <div class="form-group">
          <label for="phone">رقم الهاتف</label>
          <input type="tel" id="phone" required>
        </div>

        <div class="form-group">
          <label for="address">العنوان</label>
          <input type="text" id="address">
        </div>

        <!-- قسم الموظف -->
        <div id="employerSection" class="user-type-section">
          <div class="form-group">
            <label for="employerId">رقم الموظف</label>
            <input type="text" id="employerId">
          </div>
        </div>

        <!-- قسم الأستاذ -->
        <div id="professorSection" class="user-type-section">
          <div class="form-group">
            <label for="affiliation">الانتماء الجامعي</label>
            <input type="text" id="affiliation">
          </div>
        </div>

        <!-- قسم الطالب -->
        <div id="studentSection" class="user-type-section">
          <div class="form-group">
            <label for="registrationNumber">رقم التسجيل</label>
            <input type="text" id="registrationNumber" name="registrationNumber">
          </div>
          <div class="form-group">
            <label for="level">المستوى الدراسي</label>
            <input type="text" id="level">
          </div>
          <div class="form-group">
            <label for="academicYear">السنة الأكاديمية</label>
            <input type="text" id="academicYear" placeholder="YYYY-MM-DD">
          </div>
          <div class="form-group">
            <label for="specialty">التخصص</label>
            <input type="text" id="specialty">
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="save-btn">حفظ البيانات</button>
        </div>
      </form>
    </div>
  </div>

  <footer>
    © 2025 منصة كتابي - جميع الحقوق محفوظة
  </footer>

  <script>
    // متغيرات عامة
    let accounts = JSON.parse(localStorage.getItem('accounts')) || [];
    let currentEditId = null;

    // عرض الحسابات في الجدول
    function renderAccountsTable() {
      const tbody = document.getElementById('accountsTableBody');
      tbody.innerHTML = '';

      if (accounts.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="7" style="text-align: center; padding: 30px;">
              <i class="fas fa-users-slash" style="font-size: 50px; color: #ccc;"></i>
              <p>لا توجد حسابات مسجلة حالياً</p>
            </td>
          </tr>
        `;
        return;
      }

      accounts.forEach((account, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${index + 1}</td>
          <td><img src="${account.photo || 'https://via.placeholder.com/60x60?text=صورة'}" 
                   alt="صورة المستخدم" 
                   style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"></td>
          <td>${account.firstName} ${account.lastName}</td>
          <td>${account.email}</td>
          <td>${getUserTypeArabic(account.userType)}</td>
          <td>${account.phone}</td>
          <td>
            ${!account.confirmed ? `
              <button class="action-btn edit-btn" onclick="confirmAccount(${index})">
                <i class="fas fa-check"></i> تأكيد
              </button>
            ` : ''}
            <button class="action-btn delete-btn" onclick="confirmDelete(${index})">
              <i class="fas fa-trash"></i> حذف
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    function getUserTypeArabic(type) {
      switch (type) {
        case 'employer': return 'موظف';
        case 'professor': return 'أستاذ';
        case 'student': return 'طالب';
        default: return 'غير معروف';
      }
    }

    function openAddModal() {
      document.getElementById('modalTitle').innerText = 'إضافة حساب جديد';
      document.getElementById('accountForm').reset();
      document.getElementById('accountId').value = '';
      hideAllSections();
      document.getElementById('accountModal').style.display = 'block';
    }

    function openEditModal(index) {
      const account = accounts[index];
      document.getElementById('modalTitle').innerText = 'تعديل الحساب';
      document.getElementById('accountId').value = index;
      document.getElementById('userType').value = account.userType;
      document.getElementById('firstName').value = account.firstName;
      document.getElementById('lastName').value = account.lastName;
      document.getElementById('email').value = account.email;
      document.getElementById('phone').value = account.phone;
      document.getElementById('address').value = account.address;
      showUserTypeFields(account.userType);
      document.getElementById('employerId').value = account.employerId || '';
      document.getElementById('affiliation').value = account.affiliation || '';
      document.getElementById('registrationNumber').value = account.registrationNumber || '';
      document.getElementById('level').value = account.level || '';
      document.getElementById('academicYear').value = account.academicYear || '';
      document.getElementById('specialty').value = account.specialty || '';
      document.getElementById('accountModal').style.display = 'block';
    }

    function closeModal() {
      document.getElementById('accountModal').style.display = 'none';
    }

    function showUserTypeFields() {
      const userType = document.getElementById('userType').value;
      hideAllSections();
      if (userType === 'employer') {
        document.getElementById('employerSection').style.display = 'block';
      } else if (userType === 'professor') {
        document.getElementById('professorSection').style.display = 'block';
      } else if (userType === 'student') {
        document.getElementById('studentSection').style.display = 'block';
      }
    }

    function hideAllSections() {
      document.getElementById('employerSection').style.display = 'none';
      document.getElementById('professorSection').style.display = 'none';
      document.getElementById('studentSection').style.display = 'none';
    }

    function confirmDelete(index) {
      if (confirm('هل أنت متأكد أنك تريد حذف هذا الحساب؟')) {
        accounts.splice(index, 1);
        localStorage.setItem('accounts', JSON.stringify(accounts));
        renderAccountsTable();
        showAlert('تم حذف الحساب بنجاح.', 'success');
      }
    }

    // تأكيد الحساب
    function confirmAccount(index) {
      accounts[index].confirmed = true;
      localStorage.setItem('accounts', JSON.stringify(accounts));
      renderAccountsTable();
      showAlert('تم تأكيد الحساب بنجاح.', 'success');
    }

    // إرسال إشعار
    function sendNotification(index) {
      const account = accounts[index];
      showAlert(`تم إرسال إشعار إلى: ${account.firstName} ${account.lastName}`, 'success');
    }

    // إضافة أو تعديل حساب
    document.getElementById('accountForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const id = document.getElementById('accountId').value;
      const userType = document.getElementById('userType').value;
      const firstName = document.getElementById('firstName').value;
      const lastName = document.getElementById('lastName').value;
      const email = document.getElementById('email').value;
      const phone = document.getElementById('phone').value;
      const address = document.getElementById('address').value;
      const employerId = document.getElementById('employerId').value;
      const affiliation = document.getElementById('affiliation').value;
      const registrationNumber = document.getElementById('registrationNumber').value;
      const level = document.getElementById('level').value;
      const academicYear = document.getElementById('academicYear').value;
      const specialty = document.getElementById('specialty').value;

      const newAccount = {
        userType,
        firstName,
        lastName,
        email,
        phone,
        address,
        employerId,
        affiliation,
        registrationNumber,
        level,
        academicYear,
        specialty,
        confirmed: false // خاصية التأكيد الافتراضية
      };

      if (id === '') {
        accounts.push(newAccount);
        showAlert('تم إضافة الحساب بنجاح.', 'success');
      } else {
        // إذا كان الحساب مؤكد يبقى مؤكد بعد التعديل
        newAccount.confirmed = accounts[id].confirmed;
        accounts[id] = newAccount;
        showAlert('تم تعديل الحساب بنجاح.', 'success');
      }
      localStorage.setItem('accounts', JSON.stringify(accounts));
      closeModal();
      renderAccountsTable();
    });

    function showAlert(message, type) {
      const alertDiv = document.getElementById('alertMessage');
      alertDiv.innerHTML = message;
      alertDiv.className = `alert alert-${type}`;
      alertDiv.style.display = 'block';
      setTimeout(() => {
        alertDiv.style.display = 'none';
      }, 3000);
    }

    // عند تحميل الصفحة
    window.onload = function() {
      renderAccountsTable();
    };
  </script>
</body>
</html>
