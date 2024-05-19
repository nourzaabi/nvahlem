document.addEventListener('DOMContentLoaded', () => {
    const searchIcon = document.querySelector('.fa-magnifying-glass');
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');
    const resultsDiv = document.createElement('div');
    resultsDiv.id = 'results';
    searchForm.appendChild(resultsDiv);

    searchIcon.addEventListener('click', () => {
        searchInput.classList.toggle('show');
        if (searchInput.classList.contains('show')) {
            searchInput.focus();
        }
    });

    searchForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const query = searchInput.value.trim();
        if (query) {
            try {
                const movies = await searchMovies(query);
                displayResults(movies);
            } catch (error) {
                console.error('Error fetching movies:', error);
                displayResults([]);
            }
        }
    });

    async function searchMovies(query) {
        // Simulate fetching data from an API
        // Replace this with actual API call
        const allMovies = [
            'Breaking Bad',
            'Bad Boys',
            'The Bad Batch',
            'Batman',
            'Bad Santa'
        ];
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(allMovies.filter(movie => movie.toLowerCase().includes(query.toLowerCase())));
            }, 500); // Simulate network delay
        });
    }

    function displayResults(movies) {
        resultsDiv.innerHTML = '';
        if (movies.length > 0) {
            const ul = document.createElement('ul');
            movies.forEach(movie => {
                const li = document.createElement('li');
                li.textContent = movie;
                ul.appendChild(li);
            });
            resultsDiv.appendChild(ul);
            resultsDiv.classList.add('show');
        } else {
            resultsDiv.classList.remove('show');
        }
    }

    document.addEventListener('click', (event) => {
        if (!searchForm.contains(event.target) && searchInput.classList.contains('show')) {
            searchInput.classList.remove('show');
            resultsDiv.classList.remove('show');
        }
    });

    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Apply debounce to the search function
    searchForm.addEventListener('input', debounce(async (event) => {
        const query = searchInput.value.trim();
        if (query) {
            try {
                const movies = await searchMovies(query);
                displayResults(movies);
            } catch (error) {
                console.error('Error fetching movies:', error);
                displayResults([]);
            }
        }
    }, 300));
});
