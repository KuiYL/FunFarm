<header>
    <div class="content">
        <div class="header_content">
            <div class="nav nav-left">
                <a href="?page=main">Главная</a>
                <a href="?page=main#pravila">Правила</a>
                <a href="?page=main#lavel">Уровни</a>
            </div>

            <div class="logo">
                <a href="?page=main">
                    <img src="/images/logo.png" alt="Logo">
                </a>
            </div>

            <div class="nav nav-right">
                <a href="?page=main#stik">Стикеры</a>
                <a href="?page=main#faq">Вопрос / Ответ</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="?page=profile" class="acc-link"><img src="/images/acc.png" alt=""></a>
                    <a href="php/logout.php" id="voiti">Выйти</a>
                <?php else: ?>
                    <a href="?page=login" class="acc-link"><img src="/images/acc.png" alt=""></a>
                <?php endif; ?>
            </div>

            <div class="burger-menu" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <div class="mobile-nav-overlay" id="mobileNav">
        <div class="mobile-nav-content">
            <a href="?page=main" onclick="toggleMenu()">Главная</a>
            <a href="?page=main#pravila" onclick="toggleMenu()">Правила</a>
            <a href="?page=main#lavel" onclick="toggleMenu()">Уровни</a>
            <a href="?page=main#stik" onclick="toggleMenu()">Стикеры</a>
            <a href="?page=main#faq" onclick="toggleMenu()">Вопрос / Ответ</a>
            
            <div class="mobile-auth">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="?page=profile" onclick="toggleMenu()">Профиль</a>
                    <a href="php/logout.php" onclick="toggleMenu()">Выйти</a>
                <?php else: ?>
                    <a href="?page=login" onclick="toggleMenu()">Войти</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileNav');
        const burger = document.querySelector('.burger-menu');
        
        menu.classList.toggle('active');
        burger.classList.toggle('active');
        
        if (menu.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
</script>