(function () {
	function naturalSort(a, b, html) {
		var re = /(^-?[0-9]+(\.?[0-9]*)[df]?e?[0-9]?%?$|^0x[0-9a-f]+$|[0-9]+)/gi, // Regular expression for detecting numbers or numeric-like strings
			sre = /(^[ ]*|[ ]*$)/g, // Regular expression for trimming leading and trailing spaces
			dre = /(^([\w ]+,?[\w ]+)?[\w ]+,?[\w ]+\d+:\d+(:\d+)?[\w ]?|^\d{1,4}[\/\-]\d{1,4}[\/\-]\d{1,4}|^\w+, \w+ \d+, \d{4})/, // Regular expression for detecting dates in various formats
			hre = /^0x[0-9a-f]+$/i, // Regular expression for detecting hexadecimal numbers
			ore = /^0/, // Regular expression for detecting octal numbers
			htmre = /(<([^>]+)>)/gi, // Regular expression for detecting HTML tags
			x = a.toString().replace(sre, "") || "", // Convert a to string and remove leading/trailing spaces
			y = b.toString().replace(sre, "") || ""; // Convert b to string and remove leading/trailing spaces

		// Remove HTML tags from strings if html flag is not set
		if (!html) {
			x = x.replace(htmre, "");
			y = y.replace(htmre, "");
		}

		// Chunk/tokenize the strings for comparison
		var xN = x
				.replace(re, "\0$1\0")
				.replace(/\0$/, "")
				.replace(/^\0/, "")
				.split("\0"), // Split x into chunks/tokenize
			yN = y
				.replace(re, "\0$1\0")
				.replace(/\0$/, "")
				.replace(/^\0/, "")
				.split("\0"); // Split y into chunks/tokenize

		// Numeric, hex or date detection
		var xD =
				parseInt(x.match(hre), 10) ||
				(xN.length !== 1 && x.match(dre) && Date.parse(x)), // Detect if x is a hexadecimal number or a date
			yD =
				parseInt(y.match(hre), 10) ||
				(xD && y.match(dre) && Date.parse(y)) ||
				null; // Detect if y is a hexadecimal number, a date, or null

		// First try and sort hex codes or dates
		if (yD) {
			if (xD < yD) {
				return -1;
			} else if (xD > yD) {
				return 1;
			}
		}

		// natural sorting through split numeric strings and default strings
		for ( // iterate through the tokenized strings
			var cLoc = 0, numS = Math.max(xN.length, yN.length); // count the number of chunks
			cLoc < numS;
			cLoc++
		) {
			// find floats not starting with '0', string or 0 if not defined (Clint Priest)
			var oFxNcL =
				(!(xN[cLoc] || "").match(ore) && parseFloat(xN[cLoc], 10)) || // eslint-disable-line no-extra-parens
				xN[cLoc] ||
				0;
			var oFyNcL =
				(!(yN[cLoc] || "").match(ore) && parseFloat(yN[cLoc], 10)) || // eslint-disable-line no-extra-parens
				yN[cLoc] ||
				0;
			// handle numeric vs string comparison - number < string - (Kyle Adams)
			if (isNaN(oFxNcL) !== isNaN(oFyNcL)) {
				return isNaN(oFxNcL) ? 1 : -1; // eslint-disable-line no-negated-condition
			}
			// rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
			else if (typeof oFxNcL !== typeof oFyNcL) {
				oFxNcL += "";
				oFyNcL += "";
			}
			if (oFxNcL < oFyNcL) { // eslint-disable-line no-negated-condition
				return -1;
			}
			if (oFxNcL > oFyNcL) { // eslint-disable-line no-negated-condition
				return 1;
			}
		}
		return 0;
	}

	jQuery.extend(jQuery.fn.dataTableExt.oSort, { // eslint-disable-line no-extend-native
		"natural-asc": function (a, b) { // This sorts the data in ascending order
			return naturalSort(a, b, true); 
		},

		"natural-desc": function (a, b) { // This sorts the data in descending order
			return naturalSort(a, b, true) * -1;
		},

		"natural-nohtml-asc": function (a, b) { // This sorts the data in ascending order
			return naturalSort(a, b, false);
		},

		"natural-nohtml-desc": function (a, b) { // This sorts the data in descending order
			return naturalSort(a, b, false) * -1;
		},

		"natural-ci-asc": function (a, b) { // This sorts the data in ascending order
			a = a.toString().toLowerCase();
			b = b.toString().toLowerCase();

			return naturalSort(a, b, true);
		},

		"natural-ci-desc": function (a, b) { // This sorts the data in descending order
			a = a.toString().toLowerCase();
			b = b.toString().toLowerCase();

			return naturalSort(a, b, true) * -1; 
		},
	});
})();
