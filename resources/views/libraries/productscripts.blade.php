<script>
    // document.querySelector('input[name="productname"]').addEventListener('input', function() {
    //     const productName = this.value.trim();
    //     if (productName.length > 0) {
    //         const firstLetter = productName[0].toUpperCase();
    //         document.querySelector('input[name="productcode"]').value = `${firstLetter}001`;
    //     } else {
    //         document.querySelector('input[name="productcode"]').value = '';
    //     }
    // });

    // Toggle Form Visibility
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggleFormButton');
        const formArea = document.getElementById('productForm');

        // Set initial state for the form
        formArea.style.display = 'block'; // Ensure it's explicitly visible initially

        toggleButton.addEventListener('click', function() {
            if (formArea.style.display === 'block') {
                formArea.style.display = 'none';
                toggleButton.textContent = 'Show Product Form';
            } else {
                formArea.style.display = 'block';
                toggleButton.textContent = 'Hide Product Form';
            }
        });
    });
    //automatic barcode
    document.addEventListener('DOMContentLoaded', function() {
        const productNameInput = document.querySelector('input[name="productname"]');
        const productCodeInput = document.querySelector('input[name="productcode"]');

        // Inject all product codes from the backend
        const existingProductCodes = @json($allProductCodes);

        productNameInput.addEventListener('input', function() {
            const productName = this.value.trim();
            if (productName.length > 0) {
                const firstLetter = productName[0].toUpperCase();

                // Filter and find the highest existing product code for the given letter
                const filteredCodes = existingProductCodes.filter(code => code.startsWith(firstLetter));
                let highestNumber = 0;

                if (filteredCodes.length > 0) {
                    highestNumber = Math.max(
                        ...filteredCodes.map(code => parseInt(code.substring(1), 10))
                    );
                }

                // Generate the next product code
                const nextNumber = highestNumber + 1;
                const productCode = `${firstLetter}${String(nextNumber).padStart(3, '0')}`;

                productCodeInput.value = productCode;
            } else {
                productCodeInput.value = '';
            }
        });
    });


    //Computation
    document.addEventListener('DOMContentLoaded', function() {
        const costPerGramInput = document.getElementById('cost_per_gram');
        const pricePerGramInput = document.getElementById('price_per_gram');
        const gramsInput = document.getElementById('grams');
        const costPriceInput = document.getElementById('cost_price');
        const sellingPriceInput = document.getElementById('selling_price');

        function calculatePrices() {
            const costPerGram = parseFloat(costPerGramInput.value) || 0;
            const pricePerGram = parseFloat(pricePerGramInput.value) || 0;
            const grams = parseFloat(gramsInput.value) || 0;

            // Calculate cost price and selling price
            const costPrice = costPerGram * grams;
            const sellingPrice = pricePerGram * grams;

            // Update the fields
            costPriceInput.value = costPrice.toFixed(2);
            sellingPriceInput.value = sellingPrice.toFixed(2);
        }

        // Attach event listeners to inputs
        [costPerGramInput, pricePerGramInput, gramsInput].forEach(input => {
            input.addEventListener('input', calculatePrices);
        });
    });



    //Search function
    // document.addEventListener('DOMContentLoaded', function() {
    //     document.getElementById('search').addEventListener('input', function() {
    //         const searchQuery = this.value.toLowerCase();
    //         const rows = document.querySelectorAll('tbody tr');

    //         rows.forEach(row => {
    //             const productCode = row.querySelector('td:nth-child(2)').textContent
    //                 .toLowerCase();
    //             const productName = row.querySelector('td:nth-child(4)').textContent
    //                 .toLowerCase();

    //             if (productName.includes(searchQuery) || productCode.includes(searchQuery)) {
    //                 row.style.display = '';
    //             } else {
    //                 row.style.display = 'none';
    //             }
    //         });
    //     });
    // });

    ///Search New
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('search').addEventListener('input', function() {
            const searchQuery = this.value;
            const url = new URL(window.location.href);

            url.searchParams.set('search', searchQuery);
            window.location.href = url.href;
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
    const goldDropdown = document.getElementById('gold_id');
    const costInput = document.getElementById('cost_per_gram');
    const priceInput = document.getElementById('price_per_gram');

    // Listen for changes in the gold type dropdown
    goldDropdown.addEventListener('change', function () {
        // Get the selected option
        const selectedOption = goldDropdown.options[goldDropdown.selectedIndex];
        
        // Retrieve data attributes for gold cost and gold price
        const goldCost = selectedOption.getAttribute('data-gold-cost');
        const goldPrice = selectedOption.getAttribute('data-gold-price');

        console.log('Selected Option:', selectedOption.text); // Log the selected option text
        console.log('Gold Cost:', goldCost); // Log the gold cost
        console.log('Gold Price:', goldPrice); // Log the gold price

        // Update the input fields with the values from the selected option
        costInput.value = goldCost || ''; // Set to empty if no value
        priceInput.value = goldPrice || ''; // Set to empty if no value
    });

    // Trigger the change event manually to initialize fields with the default selected value
    goldDropdown.dispatchEvent(new Event('change'));
});


</script>

@stack('js')
