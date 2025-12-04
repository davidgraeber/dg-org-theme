/**
 * Main theme script
 *
 */

;( function( $ ) {



} )( jQuery )

// Фильтрация связанных постов
function initRelatedPostsFilter() {
    const filterButtons = document.querySelectorAll('.content-type-filter li');
    const relatedPosts = document.querySelectorAll('.related-post');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            
            if (this.classList.contains('active')) {
                // Если кнопка уже активна, снимаем выделение и показываем все посты
                this.classList.remove('active');
                relatedPosts.forEach(post => {
                    post.style.display = '';
                });
            } else {
                // Если кнопка не активна, активируем ее и фильтруем посты
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                relatedPosts.forEach(post => {
                    if (post.classList.contains(type)) {
                        post.style.display = '';
                    } else {
                        post.style.display = 'none';
                    }
                });
            }
        });
    });
}

// Инициализация функций при загрузке DOM
document.addEventListener('DOMContentLoaded', function() {
    // ... другие инициализации ...
    initRelatedPostsFilter();
});