function levenshtein(a, b) {
    if (a.length === 0) return b.length;
    if (b.length === 0) return a.length;

    const matrix = [];

    for (let i = 0; i <= b.length; i++) {
        matrix[i] = [i];
    }

    for (let j = 0; j <= a.length; j++) {
        matrix[0][j] = j;
    }

    for (let i = 1; i <= b.length; i++) {
        for (let j = 1; j <= a.length; j++) {
            if (b.charAt(i - 1) === a.charAt(j - 1)) {
                matrix[i][j] = matrix[i - 1][j - 1];
            } else {
                matrix[i][j] = Math.min(matrix[i - 1][j - 1] + 1, Math.min(matrix[i][j - 1] + 1, matrix[i - 1][j] + 1));
            }
        }
    }

    const similarity = 1 - (matrix[b.length][a.length] / Math.max(a.length, b.length));
    return {
        distance: matrix[b.length][a.length],
        similarity: similarity
    };
}

function removeEmpty(arr, index) {
    if (index >= arr.length) {
        return arr;
    }

    if (arr[index].length === 0 || arr[index] === ' ') {
        arr.splice(index, 1);
        return removeEmpty(arr, index);
    } else {
        return removeEmpty(arr, index + 1);
    }
}

function checkSearchTerm(splitSearch, splitData, x, y, highestCollated, threshold) {
    if (x >= splitSearch.length) {
        return highestCollated;
    }

    if (y >= splitData.length) {
        return checkSearchTerm(splitSearch, splitData, x + 1, 0, highestCollated, threshold);
    }

    var highest = {
        pass: undefined,
        score: 0
    };

    if (splitData[y].indexOf(splitSearch[x]) === 0) {
        var newScore = splitSearch[x].length / splitData[y].length;
        highest = {
            pass: true,
            score: highest.score < newScore ? newScore : highest.score
        };
    }

    var steps = levenshtein(splitSearch[x], splitData[y]).similarity;
    if (steps > highest.score) {
        highest.score = steps;
    }

    if (highestCollated[x].score < highest.score || highest.pass) {
        highestCollated[x] = {
            pass: highest.pass || highestCollated.pass ? true : highest.score > threshold,
            score: highest.score
        };
    }

    return checkSearchTerm(splitSearch, splitData, x, y + 1, highestCollated, threshold);
}

function fuzzySearch(searchVal, data, threshold) {
    if (searchVal === undefined || searchVal.length === 0) {
        return {
            pass: true,
            score: ''
        };
    }

    var splitSearch = searchVal.split(/[^(a-z|A-Z|0-9)]/g);
    var highestCollated = [];

    splitSearch = removeEmpty(splitSearch, 0);

    for (var x = 0; x < splitSearch.length; x++) {
        if (highestCollated.length < splitSearch.length) {
            highestCollated.push({ pass: false, score: 0 });
        }
    }

    for (var i = 0; i < data.length; i++) {
        data[i] = data[i].toLowerCase();
        var splitData = data[i].split(/[^(a-z|A-Z|0-9)]/g);
        splitData = removeEmpty(splitData, 0);

        highestCollated = checkSearchTerm(splitSearch, splitData, 0, 0, highestCollated, threshold);
    }

    for (var i = 0; i < highestCollated.length; i++) {
        if (!highestCollated[i].pass) {
            return {
                pass: false,
                score: Math.round(((highestCollated.reduce((a, b) => a + b.score, 0) / highestCollated.length) * 100)) + "%"
            };
        }
    }

    return {
        pass: true,
        score: Math.round(((highestCollated.reduce((a, b) => a + b.score, 0) / highestCollated.length) * 100)) + "%"
    };
}

// Get data from PHP script
async function getData() {
    try {
        const response = await fetch('getdata.php'); // Fetch data from the PHP script
        const data = await response.json(); // Convert response to JSON
        return data; // Return the data
    } catch (error) {
        console.error(error); // Log any errors that occur during fetching
    }
}

// Bind data to DataTable
$(document).ready(function() {
    const table = $('Users').DataTable({ // Initialize DataTable on the 'Users' table element
        data: [], // Set initial data to an empty array
        columns: [
            { title: 'firstName' },
            { title: 'lastName' },
            { title: 'email' },
            { title: 'phone' },
            { title: 'empNo' },
            { title: 'address'},
            { title: 'accountType'},
            { title: 'gender'},
            { title: 'dob'},
            { title: 'teams'},
        ] // Define column titles for the DataTable
    });

// Load data and bind to table
    getData().then(data => { // Fetch data and then execute the following code
        table.clear(); // Clear the DataTable
        table.rows.add(data).draw(); // Add fetched data to the DataTable and redraw
    });

    // Fuzzy search
    $('#searchInput').on('keyup', function() { // Add event listener to the search input field for keyup event
        table.rows().every(function(rowIdx, tableLoop, rowLoop) {
            const data = this.data(); // Get data for the current row
            const searchVal = $('#searchInput').val(); // Get the value of the search input field
            const result = fuzzySearch(searchVal, data); // Call fuzzySearch function to perform search
            if(result.pass) {
                $(this.node()).show(); // If search is successful, show the row
            } else {
                $(this.node()).hide(); // If search is not successful, hide the row
            }
        });
    });
});
