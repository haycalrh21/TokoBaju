// JavaScript to handle search functionality
document.getElementById('search-form').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent form submission
    const query = document.getElementById('query').value;
    searchDatabase(query);
});

function searchDatabase(query) {
    fetch(`/search?query=${query}`)
        .then(response => response.json())
        .then(data => {
            displayResults(data);
        })
        .catch(error => {
            console.error('Search failed', error);
        });
}

function displayResults(results) {
    const resultsContainer = document.getElementById('search-results');
    resultsContainer.innerHTML = ''; // Clear previous results

    if (results.length === 0) {
        resultsContainer.innerHTML = 'No results found.';
    } else {
        results.forEach(result => {
            const resultElement = document.createElement('div');
            resultElement.innerHTML = `<h3>${result.judul}</h3><p>${result.isi}</p>`;
            resultsContainer.appendChild(resultElement);
        });
    }
}
