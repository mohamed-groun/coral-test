document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.custom-control-input');
    const searchInput = document.getElementById('search-input');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const checkedCheckboxes = [];
            checkboxes.forEach(function (cb) {
                if (cb.checked) {
                    checkedCheckboxes.push(cb.id.replace('checkbox', ''));
                }
            });

            // Send AJAX request
            fetch('/', {
                method: 'GET', 
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({checkedCheckboxes: checkedCheckboxes}),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const content = document.getElementById("#movies-container")
                    if (data.content) {
                        content.innerHTML = data.content 
                    } else {
                        content.innerHTML = "<p style='padding: 25%; '><strong>NO MOVIES</strong></p>"
                    }
                })
                .catch(error => {
                    console.error('There was an error with the fetch operation:', error);
                });
        });
    });
    searchInput.addEventListener('input', function() {
        const searchValue = searchInput.value.trim();
        if(searchValue !=="")  {

            // Send AJAX request
            fetch('/', {
                method: 'GET', 
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({searchValue: searchValue}),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const content = document.getElementById("#movies-container")
                    if (data.content) {
                        content.innerHTML = data.content 
                    } else {
                        content.innerHTML = "<p style='padding: 25%; '><strong>NO MOVIES</strong></p>"
                    }
                })
                .catch(error => {
                    console.error('There was an error with the fetch operation:', error);
                });
        }

    });
});

