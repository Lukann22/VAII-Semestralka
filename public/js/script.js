// Asks for confirmation before submitting a form that has the data-confirm attribute (e.g. deleting a product)
document.addEventListener('submit', (event) => {
    const message = event.target.dataset.confirm;
    if (message && !confirm(message)) {
        event.preventDefault();
    }
});