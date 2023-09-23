/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// #region ------------------- Accordion Bibliothèque -------------------
document.addEventListener('DOMContentLoaded', function () {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach((item) => {
        const accordionButton = item.querySelector('.accordion-button');

        accordionButton.addEventListener('click', () => {
            // Fermez tous les éléments de l'accordéon
            accordionItems.forEach((otherItem) => {
                if (otherItem !== item) {
                    const otherCollapse = otherItem.querySelector('.accordion-collapse');
                    otherCollapse.classList.remove('show');
                }
            });

            // Ouvrez ou fermez l'élément actuel de l'accordéon
            const collapse = item.querySelector('.accordion-collapse');
            collapse.classList.toggle('show');
        });
    });
});
// #endregion ------------------- Accordion Bibliothèque -------------------


