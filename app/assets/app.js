/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
const onChecked = (checkbox) =>  {
    const baseURL = 'http://localhost:8080';
    if (checkbox.checked) {
        const genreId = checkbox.value;
        window.location.href = `${baseURL}/genre/${genreId}/movies`;
    } else {
        window.location.href = baseURL;
    }
}
const selectGenre = () => {
    const genres = document.querySelectorAll('input.cd_gender[type="checkbox"]');

    genres.forEach(genre => {
        genre.addEventListener('change', (event) => {
            const target = event.target
            onChecked(target);
        });
    });
}

selectGenre();