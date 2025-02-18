import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import ujs from '@rails/ujs';

ujs.start();

document.addEventListener('DOMContentLoaded', function () {
    let resetButton = document.getElementById('resetButton');
    if (resetButton) {
        resetButton.addEventListener('click', function (event) {
            event.preventDefault();
            this.form.reset();
            window.location.href = this.form.action;
        });
    }

    let labelCreateButton = document.getElementById('labelCreateButton');
    let taskForm = document.getElementById('taskForm');

    if (labelCreateButton && taskForm) {
        labelCreateButton.addEventListener('click', function (event) {
            event.preventDefault();

            let formData = new FormData(taskForm);
            let formObject = {};

            formData.forEach((value, key) => {
                formObject[key] = value;
            });

            sessionStorage.setItem('task_form_data', JSON.stringify(formObject));
            window.location.href = labelCreateButton.href;
        });
    }

    if (taskForm) {
        let formData = JSON.parse(sessionStorage.getItem('task_form_data')) || {};

        for (let [key, value] of Object.entries(formData)) {
            let input = taskForm.querySelector(`[name="${key}"]`);
            if (input) {
                input.value = value;
            }
        }
        sessionStorage.removeItem('task_form_data')
    }
});
