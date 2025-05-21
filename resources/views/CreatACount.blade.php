<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>إنشاء حساب جديد - كتابي</title>
    <style>
     body {
        font-family: 'Tajawal', sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
      }

      .container {
        max-width: 700px;
        height: 100%;
        color: black;
        margin: auto;
        background-color: rgba(255, 255, 255, 0.85);
        padding: 30px;
        border-radius: 16px;
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        text-align: right;
      }

      h1 {
        font-family: 'Times New Roman', Times, serif;
        text-align: center;
        color: #07060c;
        margin-bottom: 10px;
      }

      p {
        text-align: center;
        color: #555;
        margin-bottom: 30px;
      }

      form {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      .form-row {
        display: flex;
        gap:35px;
        width: 100%;
      }

      .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
      }

      label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
      }

      input, select {
        width: 100%;
        height: 40px;
        border-radius: 8px;
        border: 0;
        padding: 0 10px;
        background-color: #f4f4f4;
      }

      input:focus, select:focus {
        border-color: #4F46E5;
      }

      .full-width {
        width: 100%;
      }

      .checkbox-group {
        display: flex;
        align-items: center;
        position: relative;
        top: -15px;
      }

      .checkbox-group input {
        width: auto;
        margin-left: 10px;
      }

      .terms {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
      }

      .submit-btn {
        width: 100%;
        padding: 12px;
        background-color: #4F46E5;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s;
      }

      .submit-btn:hover {
        background-color: #4F46E5;
      }

      .user-type-section {
        display: none;
      }

      .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-bottom: -90px;
      }

      @media (max-width: 600px) {
        .form-row {
          flex-direction: column;
          gap: 15px;
        }
      }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="../image/20250429_000806(2).png" alt="لوجو " style="width: 300px;height:auto;">
    </div>
    <h1>مرحبًا بك في كتابي </h1>
    <p>اكتشف عالماً من المعرفة بين يديك</p>

    <div class="container">
        <h1 style="color: black; font-family:'Tajawal', sans-serif ; text-align: center;">انشاء حساب جديد</h1>
        <form id="registerForm">
            <!-- الصف الأول -->
            <div class="form-row">
                <div class="form-group">
                    <label for="userType">اختر صفتك:</label>
                    <select id="userType" name="userType" required>
                        <option value="">اختر</option>
                        <option value="professor">أستاذ</option>
                        <option value="student">طالب</option>
                        <option value="employer">موظف</option>
                    </select>
                </div>
                <div class="form-group"></div> <!-- خانة فارغة للمحافظة على التنسيق -->
            </div>

            <!-- الصف الثاني -->
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">الاسم الأول</label>
                    <input type="text" id="firstName" name="first_name" placeholder="ادخل الاسم الاول" required>
                </div>
                <div class="form-group">
                    <label for="lastName">اسم العائلة</label>
                    <input type="text" id="lastName" name="last_name" placeholder="ادخل اسم العائلة" required>
                </div>
            </div>

            <!-- الصف الثالث -->
            <div class="form-row">
                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" id="address" name="address" placeholder="ادخل عنوان " required>
                </div>
                <div class="form-group">
                    <label for="city">المدينة</label>
                    <input type="text" id="city" name="city" placeholder="ادخل اسم المدينة" required>
                </div>
            </div>

            <!-- الصف الرابع -->
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">رقم الهاتف</label>
                    <input type="text" id="phone" name="phone" placeholder=" ادخل رقم الهاتف" required>
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>

            <!-- قسم الأستاذ -->
            <div class="form-row user-type-section" id="professorSection">
                <div class="form-group">
                    <label for="affiliation">الانتماء</label>
                    <input type="text" id="affiliation" placeholder="ادخل الانتماء" name="affiliation">
                </div>
                <div class="form-group"></div> <!-- خانة فارغة للمحافظة على التنسيق -->
            </div>

            <!-- قسم الطالب -->
            <div class="user-type-section" id="studentSection">
                <div class="form-row">
                    <div class="form-group">
                        <label for="registrationNumber">رقم التسجيل</label>
                        <input type="text" id="registrationNumber" name="registrationNumber" placeholder="ادخل رقم التسجيل">
                    </div>
                    <div class="form-group">
                        <label for="level">المستوى</label>
                        <input type="text" id="level" placeholder="ادخل المستوى" name="level">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="academicYear">السنة الأكاديمية</label>
                        <input type="text" id="academicYear" name="academicYear" placeholder="YYYY-YYYY">
                    </div>
                    <div class="form-group">
                        <label for="specialty">التخصص</label>
                        <input type="text" id="specialty" name="specialty" placeholder="ادخل اسم التخصص">
                    </div>
                </div>
            </div>

            <!-- قسم العامل -->
            <div class="form-row user-type-section" id="employerSection">
                <div class="form-group">
                    <label for="employerId">معرّف العامل</label>
                    <input type="text" id="employerId" name="employerId" placeholder="ادخل معرف الخاص بك">
                </div>
                <div class="form-group"></div> <!-- خانة فارغة للمحافظة على التنسيق -->
            </div>

            <!-- الصف الخامس -->
            <div class="form-row">
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" placeholder="ادخل كلمة المرور" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">تأكيد كلمة المرور</label>
                    <input type="password" id="confirmPassword" name="confirm_password" placeholder=" تاكيد كلمة المرور" required>
                </div>
            </div>

            <!-- شروط الاستخدام -->
            <div class="full-width">
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms" class="terms">
                        أوافق على <a href="#">شروط الاستخدام وسياسة الخصوصية</a>
                    </label>
                </div>
            </div>

            <!-- زر الإرسال -->
            <button type="submit" class="submit-btn" onclick="window.location.href='{{route('home')}}'">إنشاء حساب</button>
        </form>
    </div>
    <script>
        // إظهار الحقول حسب نوع المستخدم
        document.getElementById('userType').addEventListener('change', function() {
            document.querySelectorAll('.user-type-section').forEach(sec => sec.style.display = 'none');
            if (this.value === 'professor') {
                document.getElementById('professorSection').style.display = 'flex';
            } else if (this.value === 'student') {
                document.getElementById('studentSection').style.display = 'block';
            } else if (this.value === 'employer') {
                document.getElementById('employerSection').style.display = 'flex';
            }
        });

        // عند إرسال النموذج
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // جمع البيانات
            const userType = document.getElementById('userType').value;
            const account = {
                userType: userType,
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                affiliation: userType === 'professor' ? document.getElementById('affiliation').value : '',
                registrationNumber: userType === 'student' ? document.getElementById('registrationNumber').value : '',
                level: userType === 'student' ? document.getElementById('level').value : '',
                academicYear: userType === 'student' ? document.getElementById('academicYear').value : '',
                specialty: userType === 'student' ? document.getElementById('specialty').value : '',
                employerId: userType === 'employer' ? document.getElementById('employerId').value : ''
            };

            // جلب الحسابات القديمة أو مصفوفة فارغة
            let accounts = JSON.parse(localStorage.getItem('accounts')) || [];
            accounts.push(account);
            localStorage.setItem('accounts', JSON.stringify(accounts));
        });
    </script>
</body>
</html>
