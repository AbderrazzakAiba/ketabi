@extends('layouts.app')
@section('content')


  <main>
    <div class="welcome">أهلاً بك في مكتبة المعرفة</div>
    <div class="description">يمكنك من خلال هذه المنصة إدارة كافة عمليات استعارة وإضافة الكتب بكل سهولة واحترافية.</div>
    <hr>
    <div class="description" style="font-weight: bold;">إبحث عن كتاب، مؤلف، أو تصنيف...</div>
  </main>

  <section class="books-section">
    <h2 class="section-title">آخر الكتب المضافة</h2>
    <div id="booksContainer" class="books-container">
        @if ($books->count() != 0)
            @foreach($books as $book)
            <div class="book-card">
                <img src="{{ $book->image ?? 'https://via.placeholder.com/300x250?text=لا+يوجد+غلاف' }}"
                alt="{{ $book->title}}"
                class="book-cover">
                <div class="book-details">
                    <div class="book-title">{{ $book->title}}</div>
                    <div class="book-author">{{ $book->author}}</div>
                    <div class="book-status ${book.status === 'متوفر' ? 'available' : 'unavailable'}">
                        {{ $book->status}}
                    </div>
                    <div class="book-actions">
                        <a href="book_detail.html?id={{ $book->index}}" class="book-btn details-btn">التفاصيل</a>
                        <a href="Etudiants/borrows.html" class="book-btn borrow-btn">استعارة</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="no-books">
                <i class="fas fa-book-open" style="font-size: 50px; color: #ccc; margin-bottom: 15px;"></i>
                <p>لا توجد كتب متاحة حالياً</p>
            </div>
        @endif
        <!-- الكتب ستظهر هنا تلقائياً -->
    </div>
  </section>

  <footer>
    © 2025 منصة إدارة المكتبة. جميع الحقوق محفوظة.
  </footer>

  <script>
    // عرض الكتب مع إمكانية البحث
    // function displayBooks(booksToShow = null) {
    //   const booksContainer = document.getElementById('booksContainer');
    //   const books = booksToShow || JSON.parse(localStorage.getItem('books')) || [];

    //   if (books.length === 0) {
    //     booksContainer.innerHTML = `
    //       <div class="no-books">
    //         <i class="fas fa-book-open" style="font-size: 50px; color: #ccc; margin-bottom: 15px;"></i>
    //         <p>لا توجد كتب متاحة حالياً</p>
    //       </div>
    //     `;
    //     return;
    //   }

    //   booksContainer.innerHTML = books.map((book, index) => `

    //   `).join('');
    // }

    // وظيفة البحث المتقدمة
    function searchBooks() {
      const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
      const allBooks = JSON.parse(localStorage.getItem('books')) || [];

      if (!searchTerm) {
        displayBooks();
        return;
      }

      const filteredBooks = allBooks.filter(book => {
        const titleMatch = book.title.toLowerCase().includes(searchTerm);
        const authorMatch = book.author.toLowerCase().includes(searchTerm);
        const categoryMatch = book.category && book.category.toLowerCase().includes(searchTerm);
        return titleMatch || authorMatch || categoryMatch;
      });

      displayBooks(filteredBooks);
    }

    // البحث عند الضغط على Enter
    document.getElementById('searchInput').addEventListener('keyup', (e) => {
      if (e.key === 'Enter') searchBooks();
    });

    // تحميل الكتب عند فتح الصفحة
    window.addEventListener('DOMContentLoaded', () => {
      displayBooks();

      // تحديث تلقائي عند تغيير localStorage
      window.addEventListener('storage', () => {
        displayBooks();
      });
    });
  </script>

@endsection

