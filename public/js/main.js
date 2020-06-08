const todos = document.getElementById('todos')

if (todos) {
    todos.addEventListener('click', (e) => {
        if(e.target.dataset.custom_attr === 'delete-btn') {
            if (confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id')

                fetch(`/todo/delete/${id}`, { method: 'DELETE' })
                    .then(res => window.location.reload())
            }
        }
    })
}