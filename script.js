// Обработка переключения темы
document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Функция для обновления темы
    function updateTheme() {
        if (themeToggle.checked) {
            body.classList.add('dark-theme');
        } else {
            body.classList.remove('dark-theme');
        }
    }

    updateTheme();

    // Обработчик для переключения темы
    themeToggle.addEventListener('change', updateTheme);
});

// Обработка загрузки страницы
document.addEventListener('DOMContentLoaded', function () {
    fetch('parser.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('title').textContent = data.title;
            document.getElementById('extract').textContent = data.extract;

            const imagesDiv = document.getElementById('images');
            imagesDiv.innerHTML = ''; // Очищаем блок с изображениями перед добавлением новых

            data.images.forEach(image => {
                const img = document.createElement('img');
                img.src = 'https:' + image;
                imagesDiv.appendChild(img);
            });

            // Создаем и заполняем блок для названия статьи и ссылки
            const articleTitleLink = document.getElementById('article-title-link');

            const articleLink = document.createElement('a');
            articleLink.href = 'https://ru.wikipedia.org/wiki/' + encodeURIComponent(data.title);
            articleLink.textContent = "Ссылка на статью";
            articleTitleLink.appendChild(articleLink);
        })
        .catch(error => console.error('Ошибка:', error));
});
