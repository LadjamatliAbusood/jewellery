<script>
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
</script>

@stack('js')
