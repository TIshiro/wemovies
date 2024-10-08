// Fonction pour gérer le changement de genre
const onChecked = (checkbox) => {
    const genreId = checkbox.value;
    window.location.href = checkbox.checked ? `/genre/${genreId}/movies` : '/';
};

const selectGenre = () => {
    document.querySelectorAll('input.cd_gender[type="checkbox"]').forEach(genre => {
        genre.addEventListener('change', () => onChecked(genre));
    });
};

// Fonction pour formater les votes
const totalVote = (total) => `(${total} ${total > 1 ? 'utilisateurs' : 'utilisateur'})`;

// Fonction pour générer les étoiles de notation
const starRate = (rating) => {
    const stars = ['☆☆☆☆☆', '★☆☆☆☆', '★★☆☆☆', '★★★☆☆', '★★★★☆', '★★★★★'];
    const index = Math.min(Math.max(Math.floor(rating / 2), 0), stars.length - 1);
    return stars[index];
};

// Ouvre le modal et affiche les données du film
const openModal = async (movieId) => {
    const modal = document.getElementById('movieModal');
    const movieTrailer = document.getElementById('movieTrailer');
    const noVideoMessage = document.getElementById('noVideoMessage');

    // Affiche le modal immédiatement
    modal.classList.remove('hidden');

    try {
        // Récupère les détails du film
        const movieData = await fetchData(`/movie/${movieId}`);
        updateModal(movieData);

        // Essaye de récupérer la vidéo du film
        const videoData = await fetchData(`/movie/${movieId}/video`);

        if (videoData?.key) {
            // Si une vidéo est disponible, on l'affiche
            showVideo(videoData.key);
            movieTrailer.classList.remove('hidden');
            noVideoMessage.classList.add('hidden');
        } else {
            // Si aucune vidéo n'est trouvée, on affiche le message de non-disponibilité
            handleNoVideo();
        }
    } catch (error) {
        console.error('Erreur lors de la récupération des données :', error);
        handleNoVideo();
    }
};

// Met à jour le contenu du modal avec les données du film
const updateModal = (movieData) => {
    document.getElementById('movieTitle').innerText = movieData.title;
    document.getElementById('movieDescription').innerText = movieData.overview;
    document.getElementById('ratingCount').innerText = `pour ${totalVote(movieData.vote_count)}`;
    document.getElementById('ratingValue').innerText = starRate(movieData.vote_average);
};

// Gère l'absence de vidéo
const handleNoVideo = () => {
    document.getElementById('noVideoMessage').classList.remove('hidden');
    document.getElementById('movieTrailer').classList.add('hidden');
};

// Affiche la vidéo si elle est disponible
const showVideo = (videoKey) => {
    const movieTrailer = document.getElementById('movieTrailer');
    movieTrailer.src = `https://www.youtube.com/embed/${videoKey}?rel=0&autoplay=0&controls=1`;
    movieTrailer.classList.remove('hidden');
    document.getElementById('noVideoMessage').classList.add('hidden');
};

// Ferme le modal
const closeModal = () => {
    document.getElementById('movieModal').classList.add('hidden');
    document.getElementById('movieTrailer').src = '';  // Efface la vidéo
};

// Ajoute des écouteurs sur les boutons "Lire le détail"
const addDetailButtonsEvent = () => {
    document.querySelectorAll('.detail-button').forEach(button => {
        button.addEventListener('click', () => openModal(button.getAttribute('data-movie-id')));
    });
};

// Récupère les données de l'API
const fetchData = async (url) => {
    const response = await fetch(url);
    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status} - ${response.statusText}`);
    }
    try {
        return await response.json();
    } catch (error) {
        throw new Error(`Erreur de parsing JSON : ${error.message}`);
    }
};

// Gère les suggestions d'autocomplétion
const searchInput = document.getElementById('movieSearch');
const autocompleteList = document.getElementById('autocompleteResults');

const updateAutocompleteList = (suggestions) => {
    autocompleteList.innerHTML = ''; // Vide la liste des suggestions précédentes
    if (!suggestions.length) {
        autocompleteList.classList.add('hidden');
        return;
    }

    suggestions.forEach(suggestion => {
        const listItem = document.createElement('li');
        listItem.textContent = suggestion;
        listItem.addEventListener('click', () => {
            searchInput.value = suggestion;
            autocompleteList.classList.add('hidden');
        });
        autocompleteList.appendChild(listItem);
    });

    autocompleteList.classList.remove('hidden');
};

const fetchAutocompleteSuggestions = async (query) => {
    try {
        const data = await fetchData(`/autocomplete?q=${encodeURIComponent(query)}`);
        updateAutocompleteList(data);
    } catch (error) {
        console.error('Erreur lors de la récupération des suggestions :', error);
    }
};

const autoComplete = () => {
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();
        if (query.length < 3) {
            autocompleteList.classList.add('hidden');
            return;
        }
        fetchAutocompleteSuggestions(query);
    });
};

document.getElementById('closeModal').addEventListener('click', closeModal);

autoComplete();
addDetailButtonsEvent();
selectGenre();