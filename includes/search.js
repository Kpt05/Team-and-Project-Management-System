function fuzzySearch(searchVal, data, initial) {
    // If no searchVal has been defined then return all rows.
    if(searchVal === undefined || searchVal.length === 0) {
        return {
            pass: true,
            score: ''
        }
    }
   
}

// Split the searchVal into individual words.
var splitSearch = searchVal.split(/[^(a-z|A-Z|0-9)]/g);
 
// Array to keep scores in
var highestCollated = [];
 
// Remove any empty words or spaces
for(var x = 0; x < splitSearch.length; x++) {
    if (splitSearch[x].length === 0 || splitSearch[x] === ' ') {
        splitSearch.splice(x, 1);
        x--;
    }
    // Aside - Add to the score collection if not done so yet for this search word
    else if (highestCollated.length < splitSearch.length) {
        highestCollated.push({pass: false, score: 0});
    }
}


// Going to check each cell for potential matches
for(var i = 0; i < data.length; i++) {
    // Convert all data points to lower case for insensitive sorting
    data[i] = data[i].toLowerCase();
 
    // Split the data into individual words
    var splitData = data[i].split(/[^(a-z|A-Z|0-9)]/g);
 
    // Remove any empty words or spaces
    for (var y = 0; y < splitData.length; y++){
        if(splitData[y].length === 0 || splitData[y] === ' ') {
            splitData.splice(y, 1);
            y--;
        }
    }

    // Check each search term word
    for(var x = 0; x < splitSearch.length; x++) {
        // Reset highest score
        var highest = {
            pass: undefined,
            score: 0
        };
 
        // Against each word in the cell
        for (var y = 0; y < splitData.length; y++){
            // If this search Term word is the beginning of the word in
            // the cell we want to pass this word
            if(splitData[y].indexOf(splitSearch[x]) === 0){
                var newScore =
                    splitSearch[x].length / splitData[y].length;
                highest = {
                    pass: true,
                    score: highest.score < newScore ?
                        newScore :
                        highest.score
                };
            }
 
            // Get the levenshtein similarity score for the two words
            var steps =
                levenshtein(splitSearch[x], splitData[y]).similarity;
             
            // If the levenshtein similarity score is better than a
            // previous one for the search word then let's store it
            if(steps > highest.score) {
                highest.score = steps;
            }
        }
 
        // If this cell has a higher scoring word than previously found
        // to the search term in the row, store it
        if(highestCollated[x].score < highest.score || highest.pass) {
            highestCollated[x] = {
                pass: highest.pass || highestCollated.pass ?
                    true :
                    highest.score > threshold,
                score: highest.score
            };
        }
    }
}

// Check that all of the search words have passed
for(var i = 0; i < highestCollated.length; i++) {
    if(!highestCollated[i].pass) {
        return {
            pass:
false,
score: Math.round(((highestCollated.reduce((a,b) => a+b.score, 0) / highestCollated.length) * 100)) + "%"
};
}
}

// If we get to here, all scores greater than 0.5 so display the row
return {
pass: true,
score: Math.round(((highestCollated.reduce((a,b) => a+b.score, 0) / highestCollated.length) * 100)) + "%"
};

// Get data from PHP script
async function getData() {
try {
const response = await fetch('getdata.php');
const data = await response.json();
return data;
} catch (error) {
console.error(error);
}
}

// Bind data to DataTable
$(document).ready(function() {
const table = $('Users').DataTable({
data: [],
columns: [
{ title: 'ID' },
{ title: 'Name' },
{ title: 'Email' },
{ title: 'Phone' },
{ title: 'City' },
{ title: 'Country' },
{ title: 'Language' },
]
});

// Load data and bind to table
getData().then(data => {
table.clear();
table.rows.add(data).draw();
});

// Fuzzy search
$('#searchInput').on('keyup', function() {
table.rows().every(function(rowIdx, tableLoop, rowLoop) {
const data = this.data();
const searchVal = $('#searchInput').val();
const result = fuzzySearch(searchVal, data);
if(result.pass) {
$(this.node()).show();
} else {
$(this.node()).hide();
}
});
});
});