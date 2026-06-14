<?php
global $connect;

$stmt = $connect->prepare("SELECT id, title, description, image_path FROM stickers ORDER BY id DESC");
$stmt->execute(); 

$stickers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>
<div class="banner">
    <div class="banner-slides">
        <div class="banner-slide active" style="background-image: url('../images/banner1.png');"></div>
        <div class="banner-slide" style="background-image: url('../images/banner2.png');"></div>
        <div class="banner-slide" style="background-image: url('../images/banner3.png');"></div>
    </div>

    <div class="content banner-content-wrapper">
        <div class="banner_content">
            <img src="/images/banner_btn.png" alt="Banner Button">
            <div class="banner_btn">
                <button class="color">НАЧАТЬ ИГРУ</button>
                <button class="lor">ОБ ИГРЕ</button>
            </div>
        </div>
    </div>

    <button class="slider-arrow prev" aria-label="Предыдущий слайд">&#10094;</button>
    <button class="slider-arrow next" aria-label="Следующий слайд">&#10095;</button>
    <div class="slider-dots"></div>
</div>

<div class="pravila py content" id="pravila">
    <h2>ПРАВИЛА ИГРЫ</h2>
    <div class="cart">
        <div class="cart_item">
            <img src="/images/cart1.png" alt="">
            <div class="cart_content">
                <h3>Приезд на ферму</h3>
                <p>Ты приезжаешь на ферму
                    к дедушке, который уехал
                    в отпуск и оставил хозяйство на тебя</p>
            </div>
        </div>
        <div class="cart_item">
            <img src="/images/cart2.png" alt="">
            <div class="cart_content">
                <h3>Фермерские задания</h3>
                <p>За неделю тебе нужно выполнить все фермерские задания и навести порядок на ферме</p>
            </div>
        </div>
        <div class="cart_item">
            <img src="/images/cart3.png" alt="">
            <div class="cart_content">
                <h3>Испытания</h3>
                <p>Корми животных,
                    собирай урожай, лови нарушителей и справляйся
                    с неожиданностями!</p>
            </div>
        </div>
        <div class="cart_item">
            <img src="/images/cart4.png" alt="">
            <div class="cart_content">
                <h3>Главный приз</h3>
                <p>Пройди все испытания
                    и получи главный приз — семейный рецепт пирога!</p>
            </div>
        </div>
    </div>
</div>
<div class="pravila py content" id="lavel">
    <h2>УРОВНИ ИГРЫ</h2>
    <h3>6 захватывающих испытаний ждут тебя</h3>
    <div class="cart2">
        <div class="cart_item2">
            <div class="level">Уровень 1</div>
            <div class="cart_content">
                <h3>Куриный переполох</h3>
                <p>Осмотри все хозяйство, познакомься
                    с животными и узнай, что нужно сделать за неделю</p>
            </div>
            <img src="/images/cart5.png" alt="" class="img">
        </div>
        <div class="cart_item2">
            <div class="level2">Уровень 2</div>
            <div class="cart_content">
                <h3>Кормление упрямой коровы</h3>
                <p>Собери корм для всех животных</p>
            </div>
            <img src="/images/cart6.png" alt="" class="img">
        </div>
        <div class="cart_item2">
            <div class="level">Уровень 3</div>
            <div class="cart_content">
                <h3>Сбор поле чудес</h3>
                <p>Собери все спелые овощи и фрукты до начала дождя. Время ограничено!
                </p>
            </div>
            <img src="/images/cart7.png" alt="" class="img">
        </div>
        <div class="cart_item2">
            <div class="level2">Уровень 4</div>
            <div class="cart_content">
                <h3>Ловля нарушителя</h3>
                <p>Лисица забралась в курятник!
                    Придумай способ поймать
                    хитрого зверя</p>
            </div>
            <img src="/images/cart8.png" alt="" class="img">
        </div>
        <div class="cart_item2">
            <div class="level">Уровень 5</div>
            <div class="cart_content">
                <h3>Неожиданности</h3>
                <p>Трактор сломался в самый неудобный момент — реши все непредвиденные проблемы!</p>
            </div>
            <img src="/images/cart9.png" alt="" class="img">
        </div>
        <div class="cart_item2">
            <div class="level2">Уровень 6</div>
            <div class="cart_content">
                <h3>Финальный раунд</h3>
                <p>Отчитайся перед дедушкой о проделанной работе и испеки семейный пирог!
                </p>
            </div>
            <img src="/images/cart10.png" alt="" class="img">
        </div>
    </div>
</div>

<div class="pravila py content" id="stik">
    <h2>СТИКЕРЫ</h2>
    <h3>Собери все стикеры во время прохождения уровней!</h3>
    <?php if ($isAdmin): ?>
    <a href="index.php?page=edit" class="color">Добавить стикер</a>
    <?php endif; ?>

    <div class="cart2">
        <?php if (empty($stickers)): ?>
        <p style="text-align:center; padding:30px; color:#666;">Стикеров пока нет</p>
        <?php else: ?>
        <?php foreach ($stickers as $sticker): ?>
        <div class="cart_item">
            <img src="<?= htmlspecialchars($sticker['image_path']) ?>" alt="<?= htmlspecialchars($sticker['title']) ?>">
            <div class="cart_content">
                <h3><?= htmlspecialchars($sticker['title']) ?></h3>
                <p><?= htmlspecialchars($sticker['description']) ?></p>
            </div>
            <a href="<?= htmlspecialchars($sticker['image_path']) ?>" class="b" download>Скачать</a>
            <?php if ($isAdmin): ?>
            <div class="button-content">
                <a href="index.php?page=update&id=<?= (int)$sticker['id'] ?>" class="u">Изменить</a>
                <form action="php/delete_sticker.php" method="POST" class="delete-form" style="display:inline;">
                    <input type="hidden" name="sticker_id" value="<?= (int)$sticker['id'] ?>">
                    <button type="submit" class="u delete-btn">Удалить</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="pravila py content" id="faq">
    <h2>ВОПРОС / ОТВЕТ</h2>
    <div class="faq-list">
        <div class="faq-item active">
            <button class="faq-question">
                Сколько участников может играть одновременно?
                <svg class="faq-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    от 1 человека в соло-режимах
                </div>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                Сколько времени занимает прохождение игры?
                <svg class="faq-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Примерно 2–3 часа на полное прохождение всех раундов.
                </div>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                Как получить стикеры?
                <svg class="faq-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Стикеры выдаются за выполнение специальных заданий в игре.
                </div>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                Что такое главный приз?
                <svg class="faq-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Главный приз — это уникальный подарок для победителя финального раунда.
                </div>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                Можно ли проходить раунды в произвольном порядке?
                <svg class="faq-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Да, вы можете выбирать раунды в любом удобном для вас порядке.
                </div>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                Есть ли возрастные ограничения?
                <svg class="faq-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Игра рекомендована для участников от 12 лет.
                </div>
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal-overlay">
    <div class="modal-content">
        <h3>Удалить стикер?</h3>
        <p>Это действие нельзя будет отменить. Файл будет удален с сервера.</p>
        <div class="modal-buttons">
            <button type="button" id="cancelDelete" class="modal-btn cancel">Отмена</button>
            <button type="button" id="confirmDelete" class="modal-btn confirm">Да, удалить</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('deleteModal');
    const confirmBtn = document.getElementById('confirmDelete');
    const cancelBtn = document.getElementById('cancelDelete');
    let formToSubmit = null;

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            formToSubmit = this;
            modal.classList.add('active');
        });
    });

    confirmBtn.addEventListener('click', () => {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });

    const closeModal = () => {
        modal.classList.remove('active');
        formToSubmit = null;
    };

    cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
</script>