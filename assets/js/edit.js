 function updateHiddenInput(input) {
        const hiddenInput = document.getElementById('avatar_value');
        if (input.files.length > 0) {
            hiddenInput.value = input.files[0].name;
        } else {
            hiddenInput.value = '';
        }
    }
