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


// Function to open the modal and display the content
const totalVote = (total) =>  `(${total} ${total > 1 ? 'utilisateurs' : 'utilisateur'})`;

const starRate = (rating) => {
    const stars = ['☆☆☆☆☆', '★☆☆☆☆', '★★☆☆☆', '★★★☆☆', '★★★★☆', '★★★★★'];
    const index = Math.floor(rating / 2);
    if (index < 0) return stars[0];
    if (index >= stars.length) return stars[stars.length - 1];

    return stars[index];
}

const openModal = (movieId) => {
    // Fetch movie details from the API
    document.getElementById('movieModal').classList.remove('hidden');

    fetch(`http://localhost:8080/movie/${movieId}`)
        .then(response => response.json())
        .then(data => {
            // Fill modal with fetched data
            document.getElementById('movieTitle').innerText = data.title;
            document.getElementById('movieDescription').innerText = data.overview;
            document.getElementById('ratingCount').innerText = `pour ${totalVote(data.vote_count)}`;
            document.getElementById('ratingValue').innerText = starRate(data.vote_average);
            fetch(`http://localhost:8080/movie/${movieId}/video`)
                .then(response => response.json())
                .then(videoData => {
                    console.log(videoData);
                    document.getElementById('movieTrailer').src = `https://www.youtube.com/embed/${videoData.key}?rel=0&autoplay=0&controls=1`;
                }
            ).catch(error => {
                console.error('Erreur lors de la récupération des données de la vidéo du film:', error);
            });

            // Display the modal
            document.getElementById('movieModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données du film:', error);
        });
};

// Function to close the modal
const closeModal = () => {
    document.getElementById('movieModal').classList.add('hidden');
    document.getElementById('movieTrailer').src = "";  // Clear the trailer
};

// Add event listener to "Lire le détail" buttons
const addDetailButtonsEvent = () => {
    const buttons = document.querySelectorAll('.detail-button');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const movieId = button.getAttribute('data-movie-id');
            openModal(movieId);
        });
    });
};

// Add event listener to close button
document.getElementById('closeModal').addEventListener('click', closeModal);

addDetailButtonsEvent();
selectGenre();