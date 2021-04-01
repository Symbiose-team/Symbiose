/*
const products = document.getElementById('products');

if (products) {
    products.addEventListener('click', e => {
        if (e.target.className === 'btn btn-danger delete product') {
            if (confirm('Are ou sure?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/product/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}*/
