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

const openModal = async (movieId) => {
    const modal = document.getElementById('movieModal');
    const movieTrailer = document.getElementById('movieTrailer');
    const noVideoMessage = document.getElementById('noVideoMessage');

    // Show the modal initially
    modal.classList.remove('hidden');

    try {
        // Fetch movie details
        const movieResponse = await fetch(`http://localhost:8080/movie/${movieId}`);
        const movieData = await movieResponse.json();

        // Fill modal with fetched data
        document.getElementById('movieTitle').innerText = movieData.title;
        document.getElementById('movieDescription').innerText = movieData.overview;
        document.getElementById('ratingCount').innerText = `pour ${totalVote(movieData.vote_count)}`;
        document.getElementById('ratingValue').innerText = starRate(movieData.vote_average);

        // Fetch movie trailer
        const videoResponse = await fetch(`http://localhost:8080/movie/${movieId}/video`);
        const videoData = await videoResponse.json();

        if (videoData && videoData.key) {
            // Show trailer if available
            movieTrailer.src = `https://www.youtube.com/embed/${videoData.key}?rel=0&autoplay=0&controls=1`;
            movieTrailer.classList.remove('hidden');
            noVideoMessage.classList.add('hidden');
        } else {
            // No video found
            handleNoVideo();
        }
    } catch (error) {
        console.error('Erreur lors de la récupération des données du film ou de la vidéo:', error);
        handleNoVideo();
    }
};

const handleNoVideo = () => {
    // Show "no video" message and hide the trailer
    document.getElementById('noVideoMessage').classList.remove('hidden');
    document.getElementById('movieTrailer').classList.add('hidden');
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

//Autocomplete
const searchInput = document.getElementById('movieSearch');
const autocompleteList = document.getElementById('autocompleteResults');

const updateAutocompleteList = (suggestions) => {
    autocompleteList.innerHTML = ''; // Vide la liste des suggestions précédentes
    if (suggestions.length === 0) {
        autocompleteList.classList.add('hidden');
        return;
    }

    // Affiche la liste des suggestions
    suggestions.forEach(suggestion => {
        const listItem = document.createElement('li');
        listItem.textContent = suggestion;
        listItem.addEventListener('click', () => {
            searchInput.value = suggestion; // Met à jour l'input avec la suggestion sélectionnée
            autocompleteList.classList.add('hidden'); // Cache la liste après la sélection
        });
        autocompleteList.appendChild(listItem);
    });

    autocompleteList.classList.remove('hidden');
};

const fetchAutocompleteSuggestions = (query) => {
    fetch(`http://localhost:8080/autocomplete?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            updateAutocompleteList(data);
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des suggestions :', error);
        });
};

const autoComplete = () => {
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();
        // Cache la liste si le nombre de caractères est inférieur à 3
        if (query.length < 3) {
            autocompleteList.classList.add('hidden');
            return;
        }

        fetchAutocompleteSuggestions(query);
    });
}

autoComplete();
addDetailButtonsEvent();
selectGenre();